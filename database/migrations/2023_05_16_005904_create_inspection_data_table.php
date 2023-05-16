<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agreement_request_id');
            $table->foreign('agreement_request_id')->references('id')->on('agreement_lists')->onDelete('cascade');
            $table->string('cpk_data', 200);
            $table->string('inspection_after_rework', 200);
            $table->timestamp('revised_date_igm')->nullable();
            $table->timestamp('sent_date_igm')->nullable();
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
        Schema::dropIfExists('inspection_data');
    }
}
