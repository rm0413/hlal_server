<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgreementListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreement_lists', function (Blueprint $table) {
            $table->id();
            $table->string('trial_number', 255);
            $table->timestamp('request_date');
            $table->timestamp('additional_request_qty_date');
            $table->string('tri_number', 255);
            $table->string('tri_quantity', 255);
            $table->string('request_person', 255);
            $table->string('superior_approval', 255);
            $table->string('supplier_name', 255);
            $table->string('part_number', 255);
            $table->string('sub_part_number', 255);
            $table->string('revision', 155);
            $table->string('coordinates', 255);
            $table->string('dimension', 255);
            $table->string('actual_value', 255);
            $table->string('critical_parts', 200);
            $table->string('critical_dimension', 200);
            $table->string('request_type', 200);
            $table->string('request_value', 255);
            $table->string('request_quantity', 200);
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->string('requestor_employee_id');
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
        Schema::dropIfExists('agreement_lists');
    }
}
