<?php 

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder {

    public function run()
    {
        Status::create([
            "hash"          => blogify()->makeHash('statuses', 'hash', true),
            "name"          => "Draft",
        ]);

        Status::create([
            "hash"          => blogify()->makeHash('statuses', 'hash', true),
            "name"          => "Pending review",
        ]);

        Status::create([
            "hash"          => blogify()->makeHash('statuses', 'hash', true),
            "name"          => "Reviewed",
        ]);
    }

}