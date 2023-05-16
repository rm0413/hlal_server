<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgreementListCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreement_list_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agreement_request_id');
            $table->foreign('agreement_request_id')->references('id')->on('agreement_lists')->onDelete('cascade');
            $table->unsignedBigInteger('code_id');
            $table->foreign('code_id')->references('id')->on('generate_agreement_codes')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agreement_list_codes');
    }
}
