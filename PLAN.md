# Plan: MHG Data Model

## TL;DR
Design and implement the core PostgreSQL data model for Must Have Golf — a product review aggregator for golf simulators and launch monitors. Start with source trust infrastructure, then products, reviews, and MHG score tables. Stack: Laravel 13 + Inertia + PostgreSQL (pgvector-ready).

---

## Decisions
- PostgreSQL (not SQLite) — pgvector for future vector/semantic search
- Source = individual content item (video, post, article, thread)
- Parent context = channel/subreddit/domain (trust inheritance)
- Trust: hybrid (computed from fields + manual override cap)
- Reddit: post/thread = source
- YouTube: video = source, channel = parent context
- Phase 1 scope: launch monitors + simulators only (40-60 products)
- No FK constraints in migrations — plain `string` columns for `_id` fields (ULID). Relationships managed entirely by Eloquent.
- All primary keys are ULIDs — `$table->ulid('id')->primary()` in migrations, `HasUlids` trait on all models.
- Product categories are a seeded lookup table (not enum) for easy expansion
- Sentiments have a unique constraint on (source_id, product_id) — one record per source+product pair

---

## Phase 1: PostgreSQL Setup
1. Update `.env` and `config/database.php` default to `pgsql`
2. No migration changes needed — existing migrations are DB-agnostic

---

## Phase 2: `source_contexts` table
Parent trust context (channel, subreddit, domain, forum)

| Column | Type | Notes |
|---|---|---|
| id | ulid | primary key |
| type | enum | youtube_channel, subreddit, domain, forum |
| name | string | |
| url | string | |
| handle | string, nullable | @channel or r/subreddit |
| subscriber_count | integer, nullable | |
| member_count | integer, nullable | |
| domain_authority | smallint, nullable | 0–100 |
| audience_focus | enum | golf_specific, sports, general_tech, general |
| primary_region | char(2), nullable | |
| editorial_independence | boolean | default true |
| golf_specificity_score | smallint, nullable | 0–100 |
| computed_trust_score | smallint | 0–100 |
| manual_trust_override | smallint, nullable | caps or floors computed score |
| timestamps | | |

---

## Phase 3: `sources` table
Individual content item (video, post, article, thread)

| Column | Type | Notes |
|---|---|---|
| id | ulid | primary key |
| source_context_id | string | no FK constraint |
| type | enum | youtube_video, reddit_post, blog_article, forum_thread |
| url | string, unique | |
| title | string | |
| author | string, nullable | |
| published_at | timestamp, nullable | |
| view_count | integer, nullable | |
| upvote_count | integer, nullable | |
| comment_count | integer, nullable | |
| avg_engagement_rate | decimal, nullable | |
| hands_on_verified | boolean | default false |
| review_depth | enum | first_impressions, long_term, comparison, discussion |
| has_affiliate_links | boolean | default false |
| manufacturer_relationship | enum | independent, loaner, sponsored, unknown |
| computed_trust_score | smallint | 0–100 |
| manual_trust_override | smallint, nullable | |
| ingested_at | timestamp, nullable | |
| last_updated_at | timestamp, nullable | |
| timestamps | | |

---

## Phase 4: `categories` + `products` tables

### `categories`
| Column | Type |
|---|---|
| id | ulid |
| name | string |
| slug | string, unique |
| timestamps | |

### `products`
| Column | Type | Notes |
|---|---|---|
| id | ulid | primary key |
| name | string | |
| slug | string, unique | |
| brand | string | |
| category_id | string | no FK constraint |
| msrp | decimal, nullable | |
| release_year | smallint, nullable | |
| left_handed_available | boolean, nullable | |
| description | text, nullable | |
| specs | jsonb, nullable | |
| affiliate_links | jsonb, nullable | |
| is_active | boolean | default true |
| timestamps | | |

---

## Phase 5: `sentiments` table
Extracted opinions — one record per source+product pair

| Column | Type | Notes |
|---|---|---|
| id | ulid | primary key |
| source_id | string | no FK constraint |
| product_id | string | no FK constraint |
| sentiment_score | decimal | -1 to 1 |
| pros | jsonb | array of strings |
| cons | jsonb | array of strings |
| tags | jsonb | portability, accuracy, value, software, etc. |
| extraction_method | enum | ai, manual, hybrid |
| extracted_at | timestamp | |
| timestamps | | |

Unique constraint on `(source_id, product_id)`.

---

## Phase 6: `product_rankings` table
Computed MHG score per product

| Column | Type | Notes |
|---|---|---|
| id | ulid | primary key |
| product_id | string, unique | no FK constraint |
| mhg_score | decimal | 0–100 |
| score_breakdown | jsonb | accuracy, value, indoor_use, software, setup, etc. |
| source_count | integer | |
| review_volume_weight | decimal | |
| computed_at | timestamp | |
| timestamps | | |

---

## Phase 7: Models + Relationships

- `SourceContext` → hasMany `Source`
- `Source` → belongsTo `SourceContext`, hasMany `Sentiment`
- `Category` → hasMany `Product`
- `Product` → belongsTo `Category`, hasMany `Sentiment`, hasOne `ProductRanking`
- `Sentiment` → belongsTo `Source`, belongsTo `Product`
- `ProductRanking` → belongsTo `Product`

All models use `HasUlids` trait.

---

## Verification
1. `php artisan migrate` runs clean against local Postgres
2. jsonb columns accept and return arrays correctly
3. Seed one product (e.g. Bushnell Launch Pro) with 3 sources across different types — verify all Eloquent relationships resolve
4. Confirm nullable trust override fields accept null and integer values correctly

---

## Excluded (deferred)
- pgvector extension setup
- MHG score computation logic
- Scraping/ingestion jobs
- Frontend/Inertia pages
- Affiliate link tracking
