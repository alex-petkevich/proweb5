<?php 

use Illuminate\Database\Seeder;

class VisibilityTableSeeder extends Seeder {

    public function run()
    {
        Visibility::create([
            "hash"          => blogify()->makeHash('visibility', 'hash', true),
            "name"          => "Public",
        ]);

        Visibility::create([
            "hash"          => blogify()->makeHash('visibility', 'hash', true),
            "name"          => "Protected",
        ]);

        Visibility::create([
            "hash"          => blogify()->makeHash('visibility', 'hash', true),
            "name"          => "Private",
        ]);
    }

}