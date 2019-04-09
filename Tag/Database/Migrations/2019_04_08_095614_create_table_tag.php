<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag', function (Blueprint $table) {
            $table->bigIncrements('id');

            foreach (config('cms.locales') as $locale => $localeName) {
                $table->string('title_'.$locale)->nullable();
                $table->string('slug_'.$locale)->nullable();
                $table->longText('excerpt_'.$locale)->nullable();
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
        Schema::dropIfExists('tag');
    }
}
