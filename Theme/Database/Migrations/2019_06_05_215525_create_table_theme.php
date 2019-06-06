<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTheme extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theme', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group');
            $table->string('section');
            $table->string('type');
            $table->longText('value')->nullable();

            foreach (config('cms.locales') as $locale => $localeName) {
                $table->string('title_'.$locale)->nullable();
                $table->longText('content_'.$locale)->nullable();
            }

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
        Schema::dropIfExists('theme');
    }
}
