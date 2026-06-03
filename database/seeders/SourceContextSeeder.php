<?php

namespace Database\Seeders;

use App\Models\SourceContext;
use Illuminate\Database\Seeder;

class SourceContextSeeder extends Seeder
{
    public function run(): void
    {
        $contexts = [
            // YouTube Channels
            ['name' => 'Rick Shiels Golf', 'type' => 'youtube-channel', 'url' => 'https://www.youtube.com/@RickShielsPGAPro', 'score' => 0.88],
            ['name' => 'TXG - Tour Experience Golf', 'type' => 'youtube-channel', 'url' => 'https://www.youtube.com/@TXGgolf', 'score' => 0.93],
            ['name' => 'Mark Crossfield', 'type' => 'youtube-channel', 'url' => 'https://www.youtube.com/@MarkCrossfield', 'score' => 0.85],
            ['name' => 'Peter Finch Golf', 'type' => 'youtube-channel', 'url' => 'https://www.youtube.com/@PeterFinchGolf', 'score' => 0.80],
            ['name' => 'Golf Sidekick', 'type' => 'youtube-channel', 'url' => 'https://www.youtube.com/@golfsidekick', 'score' => 0.78],
            ['name' => 'GolfWRX (YouTube)', 'type' => 'youtube-channel', 'url' => 'https://www.youtube.com/OfficialGolfwrx', 'score' => 0.85],
            ['name' => 'MyGolfSpy (YouTube)', 'type' => 'youtube-channel', 'url' => 'https://www.youtube.com/channel/UCQGFteokFe4j0i8xcNklQFA', 'score' => 0.90],
            ['name' => 'Golf Monthly (YouTube)', 'type' => 'youtube-channel', 'url' => 'https://www.youtube.com/@GolfMonthly', 'score' => 0.82],
            ['name' => 'Plugged In Golf (YouTube)', 'type' => 'youtube-channel', 'url' => 'https://www.youtube.com/@PluggedInGolf1', 'score' => 0.85],
            ['name' => 'Golf Digest (YouTube)', 'type' => 'youtube-channel', 'url' => 'https://www.youtube.com/@GolfDigest', 'score' => 0.80],
            ['name' => '2nd Swing Golf (YouTube)', 'type' => 'youtube-channel', 'url' => 'https://www.youtube.com/@2ndSwingGolf', 'score' => 0.75],
            ['name' => 'Danny Maude Golf', 'type' => 'youtube-channel', 'url' => 'https://www.youtube.com/@DannyMaudeGolf', 'score' => 0.78],
            ['name' => 'Scratch Golf Academy', 'type' => 'youtube-channel', 'url' => 'https://www.youtube.com/@ScratchGolfAcademy', 'score' => 0.72],
            ['name' => 'James Robinson Golf', 'type' => 'youtube-channel', 'url' => 'https://www.youtube.com/@JamesRobinsonGolf', 'score' => 0.75],
            ['name' => 'Good Good Golf', 'type' => 'youtube-channel', 'url' => 'https://www.youtube.com/@GoodGoodGolf', 'score' => 0.65],

            // Subreddits
            ['name' => 'r/golf', 'type' => 'subreddit', 'url' => 'https://www.reddit.com/r/golf', 'score' => 0.75],
            ['name' => 'r/golfequipment', 'type' => 'subreddit', 'url' => 'https://www.reddit.com/r/golfequipment', 'score' => 0.72],
            ['name' => 'r/golfswing', 'type' => 'subreddit', 'url' => 'https://www.reddit.com/r/golfswing', 'score' => 0.65],
            ['name' => 'r/PGA', 'type' => 'subreddit', 'url' => 'https://www.reddit.com/r/PGA', 'score' => 0.65],
            ['name' => 'r/SimGolf', 'type' => 'subreddit', 'url' => 'https://www.reddit.com/r/SimGolf', 'score' => 0.62],
            ['name' => 'r/LPGA', 'type' => 'subreddit', 'url' => 'https://www.reddit.com/r/LPGA', 'score' => 0.60],

            // Websites
            ['name' => 'MyGolfSpy', 'type' => 'website', 'url' => 'https://www.mygolfspy.com', 'score' => 0.95],
            ['name' => 'GolfWRX', 'type' => 'website', 'url' => 'https://www.golfwrx.com', 'score' => 0.90],
            ['name' => 'Plugged In Golf', 'type' => 'website', 'url' => 'https://www.pluggedingolf.com', 'score' => 0.88],
            ['name' => 'Golf Digest', 'type' => 'website', 'url' => 'https://www.golfdigest.com', 'score' => 0.82],
            ['name' => 'Golf Channel', 'type' => 'website', 'url' => 'https://www.golfchannel.com', 'score' => 0.80],
            ['name' => 'Golf Monthly', 'type' => 'website', 'url' => 'https://www.golfmonthly.com', 'score' => 0.80],
            ['name' => 'Golf.com', 'type' => 'website', 'url' => 'https://www.golf.com', 'score' => 0.78],
            ['name' => 'Golfweek', 'type' => 'website', 'url' => 'https://golfweek.usatoday.com', 'score' => 0.78],
            ['name' => 'Practical Golf', 'type' => 'website', 'url' => 'https://practical.golf', 'score' => 0.78],
            ['name' => 'No Laying Up', 'type' => 'website', 'url' => 'https://nolayingup.com', 'score' => 0.76],
            ['name' => 'The Sand Trap', 'type' => 'website', 'url' => 'https://thesandtrap.com', 'score' => 0.75],
            ['name' => "Today's Golfer", 'type' => 'website', 'url' => 'https://www.todays-golfer.com', 'score' => 0.75],
            ['name' => 'Golf Magic', 'type' => 'website', 'url' => 'https://www.golfmagic.com', 'score' => 0.72],
            ['name' => 'Golf Tips Magazine', 'type' => 'website', 'url' => 'https://www.golftipsmag.com', 'score' => 0.68],

            // E-commerce
            ['name' => '2nd Swing Golf', 'type' => 'ecommerce', 'url' => 'https://www.2ndswing.com', 'score' => 0.83],
            ['name' => 'PGA Tour Superstore', 'type' => 'ecommerce', 'url' => 'https://www.pgatoursuperstore.com', 'score' => 0.80],
            ['name' => 'Golf Galaxy', 'type' => 'ecommerce', 'url' => 'https://www.golfgalaxy.com', 'score' => 0.78],
            ['name' => 'Global Golf', 'type' => 'ecommerce', 'url' => 'https://www.globalgolf.com', 'score' => 0.75],
            ['name' => 'The Golf Warehouse', 'type' => 'ecommerce', 'url' => 'https://www.tgw.com', 'score' => 0.72],
            ['name' => 'Rock Bottom Golf', 'type' => 'ecommerce', 'url' => 'https://www.rockbottomgolf.com', 'score' => 0.70],
            ['name' => 'Worldwide Golf Shops', 'type' => 'ecommerce', 'url' => 'https://www.worldwidegolfshops.com', 'score' => 0.70],
            ['name' => 'Fairway Golf USA', 'type' => 'ecommerce', 'url' => 'https://www.fairwaygolfusa.com', 'score' => 0.67],
            ['name' => 'Amazon Golf', 'type' => 'ecommerce', 'url' => 'https://www.amazon.com/golf', 'score' => 0.65],
            ['name' => 'Callaway Golf', 'type' => 'ecommerce', 'url' => 'https://www.callawaygolf.com', 'score' => 0.65],

            // Forums
            ['name' => 'GolfWRX Forums', 'type' => 'forum', 'url' => 'https://forums.golfwrx.com', 'score' => 0.90],
            ['name' => 'MyGolfSpy Forum', 'type' => 'forum', 'url' => 'https://forum.mygolfspy.com', 'score' => 0.85],
            ['name' => 'The Sand Trap Forum', 'type' => 'forum', 'url' => 'https://thesandtrap.com/forums', 'score' => 0.78],
            ['name' => 'Golf Monthly Forum', 'type' => 'forum', 'url' => 'https://www.golfmonthly.com/forum', 'score' => 0.68],
            ['name' => "Hacker's Paradise", 'type' => 'forum', 'url' => 'https://www.hackersparadise.com', 'score' => 0.60],
        ];

        foreach ($contexts as $context) {
            SourceContext::updateOrCreate(
                ['url' => $context['url']],
                $context
            );
        }
    }
}
