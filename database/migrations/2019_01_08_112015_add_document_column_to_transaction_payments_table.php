<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDocumentColumnToTransactionPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->string('document')->nullable()->after('note');
        });

        $dirs = ['img', 'documents', 'business_logos', 'invoice_logos'];
        foreach ($dirs as $dir) {
            $this->copyFiles($dir);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->dropColumn('document');
        });
    }

    private function copyFiles($dir){

        if (!file_exists(storage_path('app/public/' . $dir))) {
            return false;
        }

        $delete = [];
        // Get array of all source files
        $files = scandir(storage_path('app/public/' . $dir));
        // Identify directories
        $source = storage_path('app/public/' . $dir . '/');
        $destination = public_path('uploads/' . $dir . '/');

        if (!file_exists($destination)) {
            @mkdir($destination, 0775, true);
        }
        // Cycle through all source files
        foreach ($files as $file) {
          if (in_array($file, array(".",".."))) continue;
          // If we copied this successfully, mark it for deletion
          if ( file_exists($source.$file) && @copy($source.$file, $destination.$file)) {
            $delete[] = $source.$file;
          }
        }

        // Delete all successfully-copied files
        foreach ($delete as $file) {
            @unlink($file);
        }
    }
}
