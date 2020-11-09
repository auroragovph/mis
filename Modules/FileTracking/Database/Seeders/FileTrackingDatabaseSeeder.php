<?php

namespace Modules\FileTracking\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class FileTrackingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            DocumentAttachmentsTableSeeder::class,
            DocumentsTableSeeder::class,
        ]);
    }
}
