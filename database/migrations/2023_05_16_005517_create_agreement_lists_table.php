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
            $table->string('trial_number', 255)->nullable();
            $table->timestamp('request_date')->nullable();
            $table->timestamp('additional_request_qty_date')->nullable();
            $table->string('tri_number', 255)->nullable();
            $table->string('tri_quantity', 255)->nullable();
            $table->string('request_person', 255)->nullable();
            $table->string('superior_approval', 255)->nullable();
            $table->string('supplier_name', 255)->nullable();
            $table->string('part_number', 255)->nullable();
            $table->string('sub_part_number', 255)->nullable();
            $table->string('revision', 155)->nullable();
            $table->string('coordinates', 255)->nullable();
            $table->string('dimension', 255)->nullable();
            $table->string('actual_value', 255)->nullable();
            $table->string('critical_parts', 200)->nullable();
            $table->string('critical_dimension', 200)->nullable();
            $table->string('request_type', 200)->nullable();
            $table->string('request_value', 255)->nullable();
            $table->string('request_quantity', 200)->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->string('requestor_employee_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     *
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agreement_lists');
    }
}
