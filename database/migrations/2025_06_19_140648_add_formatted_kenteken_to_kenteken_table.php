<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFormattedKentekenToKentekenTable extends Migration
{
    public function up()
    {
        Schema::table('kentekens', function (Blueprint $table) {
            $table->string('formatted_licenseplate')->nullable()->after('licenseplate')->comment('Formatted Licenseplate');
        });
    }

    public function down()
    {
        Schema::table('kentekens', function (Blueprint $table) {
            $table->dropColumn('formatted_licenseplate');
        });
    }
}
