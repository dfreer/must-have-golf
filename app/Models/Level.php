<?php

namespace App\Models;

use App\Enums\LevelSlug;
use Illuminate\Support\Collection;

class Level
{
    public static function first(string|LevelSlug $slug): object
    {
        return self::all()->firstWhere('slug', $slug);
    }

    public static function all(): Collection
    {
        return collect([
            (object)[
                'label' => 'Beginner',
                'slug' => LevelSlug::BEGINNER,
                'points' => [
                    'Thinks &ldquo;par&rdquo; is short for &ldquo;par-tially hit the ball.&rdquo;',
                    'Uses more tees than a toddler at snack time',
                    'Celebrates any shot that gets airborne… even if it goes backwards',
                ]
            ],
            (object)[
                'label' => 'High Handicap',
                'slug' => LevelSlug::HIGH_HANDICAP,
                'points' => [
                    'Owns 14 clubs, uses 3, blames all of them',
                    'Can find the only water hazard on a desert course',
                    'Has a frequent flyer account for lost golf balls',
                ]
            ],
            (object)[
                'label' => 'Mid Handicap',
                'slug' => LevelSlug::MID_HANDICAP,
                'points' => [
                    'Hits one great shot per round — and talks about it all week',
                    'Thinks &ldquo;course management&rdquo; means remembering to pack snacks',
                    'Still yells &ldquo;FORE!&rdquo; even when putting',
                ]
            ],
            (object)[
                'label' => 'Low Handicap',
                'slug' => LevelSlug::LOW_HANDICAP,
                'points' => [
                    'Misses a green by two feet and sighs like they lost the Open',
                    'Carries a rangefinder, backup rangefinder, and a backup for the backup',
                    'Knows every rule, except how to have fun',
                ]
            ],
            (object)[
                'label' => 'Scratch',
                'slug' => LevelSlug::SCRATCH,
                'points' => [
                    'Has opinions on dimple patterns and ball compression',
                    'Puts backspin on chips — and on compliments',
                    'Always &ldquo;just working on a few things&rdquo; while shooting 71',
                ]
            ],
            (object)[
                'label' => 'Pro',
                'slug' => LevelSlug::PRO,
                'points' => [
                    'Knows which blade of grass the ball will land on',
                    'Gets paid to golf, but still complains about 5 a.m. tee times',
                    'Can hit a draw, a fade, and your confidence — all on command',
                ]
            ],
        ]);
    }
}
