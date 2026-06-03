# Must Have Golf — Build Plan

## Overview

Must Have Golf (MHG) is an affiliate marketing site for golf products. Its differentiator is the **MHG Score** — an aggregated credibility score built by systematically analysing real-world reviews from YouTube videos, Reddit posts, blog articles, forum threads, and e-commerce pages. Products are ranked by this score and linked to affiliate retailers.

---

## Decisions & Constraints

- **No product categories** — The UI is search-based. Full-text search covers product name and description.
- **Score scale** — 0–10 with 2 decimal places (`decimal(4, 2)`).
- **Source trust weights** — No defaults. Every `Source` and `SourceContext` must have an explicitly confirmed trust score before it contributes to any MHG Score.
- **Product images** — Fetched automatically during the Product Job via `spatie/laravel-medialibrary`.
- **No pricing** — Affiliate links point to retailers; prices are not stored or displayed.
- **No authentication** — Admin routes are unprotected for now.

---

## Data Model (Already Built)

### Scoring Hierarchy

```
SourceContext  (e.g. "Rick Shiels Golf" YouTube channel, r/golf subreddit)
    └── Source  (e.g. specific video, specific reddit thread, specific article)
            └── ProductScore  (score for one product from that source)
                    └── rolls up into → Product.score  (the MHG Score)
```

- **SourceContext** — A trusted publisher or community. Has a confirmed `score` weight (0.0–1.0) and an optional `score_override`. Types: `youtube-channel`, `subreddit`, `website`, `forum`. Must be set before contributing to a score.
- **Source** — A specific piece of content (video, post, article). Has a confirmed `score` weight (0.0–1.0) and optional `score_override`. Types: `youtube-video`, `reddit-post`, `blog-article`, `forum-thread`, `ecommerce-product-page`, `manufacturer-product-page`.
- **ProductReview** — Represents one "review run" for a product. Tracks status (`pending` → `done` / `failed`).
- **ProductScore** — One data point: a product scored (0–10) from one source in one source context. Supports `score_override` for manual correction.
- **Product** — The golf product. `score` is the computed MHG Score. Has `slug` for SEO URLs, `status`, `release_date`, affiliate `ProductLink` entries, and a media library for images.
- **ProductLink** — A link to a retailer (`amazon`, `golf-galaxy`). `affiliate` is nullable — not every link is an affiliate link.

---

## Phases

---

### ~~Phase 1 — Fix Data Model Gaps~~ ✅ Complete

- Added `product_id` FK to `product_reviews`.
- Added `url` column to `sources`.
- Made `score` and `score_override` nullable on `sources` and `source_contexts`; `score_override` nullable on `product_scores`.
- Fixed `Product::reviews()` to `hasMany(ProductReview::class)`.
- Fixed `ProductReview::products()` → renamed to `product()` with correct `belongsTo`.
- Made `product_links.affiliate` nullable (link may not be an affiliate link).
- Verified all `score` columns are `decimal(4, 2)` for the 0–10 scale.
- `migrate:fresh` ran clean.

---

### Phase 2 — Product Job

A queued job responsible for **bootstrapping a new product** with its core data and media.

#### `ProcessProduct` Job

Triggered when a product is created or manually dispatched from the admin. Does the following:

1. **Enrich product metadata** — Given just a product name, use an external source (manufacturer page scrape or an AI lookup) to populate: `description`, `release_date`, and affiliate `url` entries.
2. **Fetch product image** — Download the primary product image and attach it to the product via `spatie/laravel-medialibrary`. Store in the `product-images` media collection.
3. **Update status** — Set `Product.status` to `Active` on success, leave as `Draft` on failure.

#### MHG Score Engine

Also built in this phase since the Product Job triggers scoring later.

Each `ProductScore` contributes a **weighted score**:

```
weighted_score = raw_score × source_weight × source_context_weight
```

Where:
- `raw_score` = `ProductScore.score_override ?? ProductScore.score` (0–10)
- `source_weight` = `Source.score_override ?? Source.score` (0.0–1.0 multiplier)
- `source_context_weight` = `SourceContext.score_override ?? SourceContext.score` (0.0–1.0 multiplier)

The final MHG Score is the **weighted average**:

$$\text{MHG Score} = \frac{\sum(\text{raw\_score} \times w_s \times w_{sc})}{\sum(w_s \times w_{sc})}$$

#### Deliverables

- `composer require spatie/laravel-medialibrary` + `HasMedia` / `InteractsWithMedia` on `Product`.
- `App\Jobs\ProcessProduct` — dispatched on `Product` creation (via model observer or `created` event).
- `App\Services\MhgScoreCalculator` — pure service, accepts a `Product`, returns the computed score (0–10, 2dp).
- `App\Actions\RecalculateProductScore` — calls the calculator and persists `Product.score`.
- `ProductScore` observer that triggers `RecalculateProductScore` on created/updated/deleted.
- Unit tests: score calculation edge cases (no scores, all overrides, mixed weights, zero weight guard).

---

### Phase 3 — Product Review Job

A queued job that **gathers review data** for a product across all known sources and generates `ProductScore` records.

#### `ProcessProductReview` Job

Triggered when a `ProductReview` is created (status: `pending`). Steps:

1. **Discover sources** — Query all existing `Source` records that are relevant to this product (matched by product name against source URL/title, or explicitly linked). Also check for new sources from known `SourceContext` channels/subreddits.
2. **Fetch & analyse content** — For each source:
   - **YouTube video** — Fetch transcript via YouTube Data API v3. Pass transcript to LLM with product name; receive a sentiment score (0–10).
   - **Reddit post** — Fetch top-level comments via Reddit API. Pass to LLM; receive a sentiment score (0–10).
   - **Blog / forum / e-commerce** — Scrape page text. Pass to LLM; receive a sentiment score (0–10).
3. **Persist scores** — Create a `ProductScore` record for each source analysed. Only sources with a confirmed trust weight on both `Source` and `SourceContext` contribute to the MHG Score.
4. **Finalise** — Set `ProductReview.status` to `done` on success, `failed` on error. The `ProductScore` observer triggers `RecalculateProductScore` automatically.

#### Handling New vs. Existing Sources

- If a recognised `SourceContext` (e.g. a tracked YouTube channel) has new content mentioning the product, a new `Source` record is created automatically with `score = null` (unconfirmed). It will **not** contribute to the MHG Score until a trust weight is manually confirmed.
- Existing sources with confirmed weights score immediately.

#### Deliverables

- `App\Jobs\ProcessProductReview` — main job, chains sub-jobs per source type.
- `App\Jobs\ScoreYouTubeSource`, `App\Jobs\ScoreRedditSource`, `App\Jobs\ScoreWebSource` — per-type scoring jobs.
- `App\Services\SentimentScorer` — wraps the LLM call; input: text + product name; output: float 0–10.
- Integration tests: mock API calls; assert `ProductScore` records and `ProductReview.status` transitions.

---

### Phase 4 — Frontend Search UI

Public-facing Inertia + React site. Search-based navigation — no category browsing.

#### Pages

**Homepage** (`/`)
- Hero: one-sentence explanation of the MHG Score.
- Prominent search bar (name/keyword search).
- Showcase of top-scored products (highest `Product.score`, status `active`).

**Search Results** (`/search?q=...`)
- Full-text search across `products.name` and `products.description` using Laravel Scout (or a simple `LIKE` query for v1).
- Results as product cards sorted by MHG Score descending.
- Shows `MhgScoreBadge`, product name, short description excerpt, and a primary affiliate CTA.

**Product Detail** (`/products/{slug}`)
- Product name, hero image (from media library), description, release date.
- Large `MhgScoreBadge` with an expandable `ScoreBreakdown` table: source name, context name, raw score, trust weight, weighted contribution.
- Affiliate buy buttons (`AffiliateCta`) per `ProductLink` with FTC disclosure text.
- "How We Score" explainer collapsed by default.

**Score Methodology** (`/how-we-score`)
- Static Inertia page explaining the formula and source types. Good for SEO and user trust.

#### Component Architecture

| Component | Purpose |
|-----------|---------|
| `MhgScoreBadge` | Score display — large (detail page) and small (card) variants |
| `ProductCard` | Used on homepage and search results |
| `AffiliateCta` | Buy button + affiliate disclosure |
| `ScoreBreakdown` | Expandable table of per-source score breakdown |
| `SearchBar` | Controlled input, submits to `/search?q=` |

#### Backend

- `ProductController@show` — returns product + media + scores + links via Inertia.
- `SearchController@index` — accepts `q`, queries products, returns paginated results via Inertia.
- Wayfinder-generated route functions used on the frontend (see `wayfinder-development` skill).

---

### Phase 5 — SEO Foundation

Non-negotiable for an affiliate site.

- **Sluggable URLs** — `spatie/laravel-sluggable` on `Product`. Auto-generate from `name`. See `sluggable-development` skill.
- **Meta tags** — Per-page `<title>` + `<meta description>` via Inertia `<Head>`. Product pages: `"[Name] Review — MHG Score [X.XX] | Must Have Golf"`.
- **Sitemap** — `spatie/laravel-sitemap`. Regenerated on product status change; covers all `active` products + static pages.
- **Schema.org** — `Product` + `AggregateRating` structured data on product detail pages for rich snippets.
- **Open Graph** — Product image, name, and score for social sharing previews.
- **Canonical URLs** — Set on all pages to prevent duplicate-content issues.
- **Affiliate Disclosure** — Site-wide persistent footer notice (FTC required) + inline notice near each `AffiliateCta`.
- **robots.txt** — Block admin routes from indexing.

---

### Phase 6 — Affiliate Tracking

Anonymous click tracking on outbound affiliate links.

#### Data Model

New `product_link_clicks` table:

| Column | Type | Notes |
|--------|------|-------|
| `id` | ulid | primary key |
| `product_link_id` | foreignUlid | FK to `product_links` |
| `clicked_at` | timestamp | |

No IP addresses or user identifiers stored.

#### Implementation

- `AffiliateRedirectController` — receives `/go/{productLink}`, records the click, then redirects (HTTP 302) to the affiliate URL.
- `ProductLink` model gets a `clicks()` hasMany relationship.
- Frontend `AffiliateCta` links to `/go/{id}` instead of the raw affiliate URL.
- Admin view: top-clicked products table, clicks-per-affiliate breakdown.

---

## Build Order

| # | Phase | Depends On |
|---|-------|------------|
| 1 | Fix data model gaps | — |
| 2 | Product Job + Score Engine | Phase 1 |
| 3 | Product Review Job | Phase 1, 2 |
| 4 | Frontend Search UI | Phase 1, 2 |
| 5 | SEO Foundation | Phase 4 |
| 6 | Affiliate Tracking | Phase 4 |
