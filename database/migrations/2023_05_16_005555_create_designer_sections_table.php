<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignerSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designer_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agreement_request_id');
            $table->foreign('agreement_request_id')->references('id')->on('agreement_lists')->onDelete('cascade');
            $table->string('designer_answer', 255);
            $table->string('designer_in_charge', 255);
            $table->string('request_result', 255);
            $table->timestamp('answer_date');
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
        Schema::dropIfExists('designer_sections');
    }
}
