<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FmsDocumentAttachmentAddDescriptionColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // SETTING UP FOREIGN RELATIONSHIPS
        Schema::table('fms_documents_attachment', function (Blueprint $table) {

            $table->dropColumn(['type']);

            $table->text('description')->after('employee_id')->nullable()->default(null);
            $table->text('url')->after('description')->nullable()->default(null);
            $table->text('mime')->after('url')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fms_documents_attachment', function (Blueprint $table) {
            $table->dropColumn(['description', 'url', 'mime']);
        });
    }
}
