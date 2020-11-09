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

        $file = storage_path('app/seeders_documents/attachment.json');
        $attachments = json_decode(file_get_contents($file), true);

        $array = array();

        foreach($attachments as $attachment)
        {
            $array[] = [
                'document_id' => 0,
                'employee_id' => 0,
                'description' => $attachment['name']
            ];
        }

        FTS_DA::insert($array);
    }
}
