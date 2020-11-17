<?php

namespace Modules\FileTracking\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\FileTracking\Entities\FTS_AFL;
use Modules\FileTracking\Entities\FTS_Cafoa;
use Modules\FileTracking\Entities\FTS_Payroll;
use Modules\FileTracking\Entities\Document\FTS_DA;
use Modules\FileTracking\Entities\Document\FTS_Qr;
use Modules\FileTracking\Entities\Travel\FTS_Itinerary;
use Modules\FileTracking\Entities\Document\FTS_Document;
use Modules\FileTracking\Entities\Document\FTS_Tracking;
use Modules\FileTracking\Entities\Travel\FTS_TravelOrder;
use Modules\FileTracking\Entities\FTS_DisbursementVoucher;
use Modules\FileTracking\Entities\Procurement\FTS_PurchaseRequest;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();


        // setting up the php values
        set_time_limit(0);
        ini_set('memory_limit', '2048M');

        // documents
        $file = file_get_contents(storage_path('app/seeds/fts/documents/documents.json'));
        $batch = collect(json_decode($file, true))->chunk(1000);
        foreach($batch as $documents){
            FTS_Document::insert($documents->toArray());
        }

        // tracks
        $file = file_get_contents(storage_path('app/seeds/fts/documents/tracking.json'));
        $batch = collect(json_decode($file, true))->chunk(5000);
        foreach($batch as $documents){
            FTS_Tracking::insert($documents->toArray());
        }

         // attachments
         $file = file_get_contents(storage_path('app/seeds/fts/documents/attachments.json'));
         $batch = collect(json_decode($file, true))->chunk(5000);
         foreach($batch as $attachments){
             FTS_DA::insert($attachments->toArray());
         }

         // QR CODE
        $file = file_get_contents(storage_path('app/seeds/fts/documents/qr.json'));
        $batch = collect(json_decode($file, true))->chunk(5000);
        foreach($batch as $documents){
            FTS_Qr::insert($documents->toArray());
        }

         // FORM AFL
        $file = file_get_contents(storage_path('app/seeds/fts/documents/form-afl.json'));
        $batch = collect(json_decode($file, true))->chunk(1000);
        foreach($batch as $docs){
            FTS_AFL::insert($docs->toArray());
        }

        // FORM DV
        $file = file_get_contents(storage_path('app/seeds/fts/documents/form-dv.json'));
        $batch = collect(json_decode($file, true))->chunk(1000);
        foreach($batch as $docs){
            FTS_DisbursementVoucher::insert($docs->toArray());
        }

        // FORM CAFOA/OBR
        $file = file_get_contents(storage_path('app/seeds/fts/documents/form-cafoa.json'));
        $batch = collect(json_decode($file, true))->chunk(1000);
        foreach($batch as $docs){
            FTS_Cafoa::insert($docs->toArray());
        }
        
        // FORM IOT
        $file = file_get_contents(storage_path('app/seeds/fts/documents/form-iot.json'));
        $batch = collect(json_decode($file, true))->chunk(1000);
        foreach($batch as $docs){
            FTS_Itinerary::insert($docs->toArray());
        }

        // FORM PAYROLL
        $file = file_get_contents(storage_path('app/seeds/fts/documents/form-payroll.json'));
        $batch = collect(json_decode($file, true))->chunk(1000);
        foreach($batch as $docs){
            FTS_Payroll::insert($docs->toArray());
        }

        // FORM PR
        $file = file_get_contents(storage_path('app/seeds/fts/documents/form-pr.json'));
        $batch = collect(json_decode($file, true))->chunk(1000);
        foreach($batch as $docs){
            FTS_PurchaseRequest::insert($docs->toArray());
        }

        // FORM TRAVEL
        $file = file_get_contents(storage_path('app/seeds/fts/documents/form-to.json'));
        $batch = collect(json_decode($file, true))->chunk(1000);
        foreach($batch as $docs){
            FTS_TravelOrder::insert($docs->toArray());
        }

    }
}
