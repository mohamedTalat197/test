<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone')->nullable();
            $table->string('facebook')->nullable();
            $table->string('whatsApp')->nullable();
            $table->string('twitter')->nullable();
            $table->string('snap')->nullable();
            $table->string('companyLogo')->nullable();
            $table->longText('terms_ar')->nullable();
            $table->longText('terms_en')->nullable();
            $table->longText('about_ar')->nullable();
            $table->longText('about_en')->nullable();
            $table->string('aboutImage')->nullable();
            $table->longText('aboutCompany_ar')->nullable();
            $table->longText('aboutCompany_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
