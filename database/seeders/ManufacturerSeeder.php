<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ManufacturerSeeder extends Seeder
{
    /**
     * Seed golf club manufacturers and club brands active during 2011-2026.
     */
    public function run(): void
    {
        $manufacturers = [
            ['name' => 'Acushnet Company', 'website' => 'https://www.acushnet.com'],
            ['name' => 'Adams Golf', 'website' => 'https://www.taylormadegolf.com'],
            ['name' => 'Acer Golf', 'website' => 'https://www.hirekogolf.com'],
            ['name' => 'Alpha Golf', 'website' => 'https://www.alphagolf.com'],
            ['name' => 'Bang Golf', 'website' => 'https://www.banggolf.com'],
            ['name' => 'Ben Hogan Golf', 'website' => 'https://benhogangolf.com'],
            ['name' => 'Bettinardi Golf', 'website' => 'https://bettinardi.com'],
            ['name' => 'Bridgestone Golf', 'website' => 'https://www.bridgestonegolf.com'],
            ['name' => 'Callaway Golf', 'website' => 'https://www.callawaygolf.com'],
            ['name' => 'Cobra Golf', 'website' => 'https://www.cobragolf.com'],
            ['name' => 'Cleveland Golf', 'website' => 'https://www.clevelandgolf.com'],
            ['name' => 'Edel Golf', 'website' => 'https://edelgolf.com'],
            ['name' => 'Epon Golf', 'website' => 'https://epongolf.net'],
            ['name' => 'Fourteen Golf', 'website' => 'https://www.fourteengolf.com'],
            ['name' => 'GigaGolf', 'website' => 'https://www.gigagolf.com'],
            ['name' => 'Golden Bear', 'website' => 'https://www.goldenbear.com'],
            ['name' => 'Haywood Golf', 'website' => 'https://www.haywoodgolf.com'],
            ['name' => 'Hireko Golf', 'website' => 'https://www.hirekogolf.com'],
            ['name' => 'Honma Golf', 'website' => 'https://www.honmagolf.com'],
            ['name' => 'Integra Golf', 'website' => 'https://www.hirekogolf.com'],
            ['name' => 'Krank Golf', 'website' => 'https://krankgolf.com'],
            ['name' => 'KZG Golf', 'website' => 'https://www.kzgolf.com'],
            ['name' => 'Lazrus Golf', 'website' => 'https://www.lazrusgolf.com'],
            ['name' => 'MacGregor Golf', 'website' => 'https://www.macgregorgolf.com'],
            ['name' => 'Majek Golf', 'website' => 'https://www.majekgolf.com'],
            ['name' => 'Mizuno Golf', 'website' => 'https://mizunogolf.com'],
            ['name' => 'Miura Golf', 'website' => 'https://miuragolf.com'],
            ['name' => 'New Level Golf', 'website' => 'https://newlevelgolf.com'],
            ['name' => 'Nike Golf', 'website' => 'https://www.nike.com'],
            ['name' => 'Odyssey Golf', 'website' => 'https://www.odysseygolf.com'],
            ['name' => 'Orlimar', 'website' => 'https://www.orlimar.com'],
            ['name' => 'PING', 'website' => 'https://ping.com'],
            ['name' => 'PowerBilt', 'website' => 'https://www.powerbilt.com'],
            ['name' => 'PXG', 'website' => 'https://www.pxg.com'],
            ['name' => 'Ram Golf', 'website' => 'https://www.ramgolf.com'],
            ['name' => 'Scotty Cameron', 'website' => 'https://www.scottycameron.com'],
            ['name' => 'Scratch Golf', 'website' => 'https://scratchgolf.com'],
            ['name' => 'Srixon', 'website' => 'https://www.srixon.com'],
            ['name' => 'Sub 70 Golf', 'website' => 'https://www.sub70golf.com'],
            ['name' => 'Takomo Golf', 'website' => 'https://takomogolf.com'],
            ['name' => 'TaylorMade Golf', 'website' => 'https://www.taylormadegolf.com'],
            ['name' => 'Titleist', 'website' => 'https://www.titleist.com'],
            ['name' => 'Tommy Armour Golf', 'website' => 'https://www.golfgalaxy.com'],
            ['name' => 'Tour Edge', 'website' => 'https://www.touredge.com'],
            ['name' => 'Vega Golf', 'website' => 'https://vegagolf.com'],
            ['name' => 'Wilson Golf', 'website' => 'https://www.wilson.com'],
            ['name' => 'Wishon Golf', 'website' => 'https://wishongolf.com'],
            ['name' => 'XXIO', 'website' => 'https://xxio.com'],
            ['name' => 'Yonex Golf', 'website' => 'https://www.yonex.com/golf'],
        ];

        foreach ($manufacturers as $manufacturer) {
            Manufacturer::query()->updateOrCreate(
                ['name' => $manufacturer['name']],
                [
                    'slug' => Str::slug($manufacturer['name']),
                    'website' => $manufacturer['website'],
                ],
            );
        }
    }
}
