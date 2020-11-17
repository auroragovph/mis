<?php

namespace Modules\FileTracking\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\FileTracking\Entities\Document\FTS_DA;

class DocumentAttachmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $file = storage_path('app/seeds/fts/attachments.json');
        $attachments = json_decode(file_get_contents($file), true);
        FTS_DA::insert($attachments);
    }
}
