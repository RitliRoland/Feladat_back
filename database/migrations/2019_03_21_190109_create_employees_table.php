<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('First_name')->nullable(false);
			$table->string('Last_name')->nullable(false);
			$table->biginteger('Company')->unsigned();
			$table->foreign('Company')->references('id')->on('companies')->onDelete('cascade');;
			$table->string('Email')->unique();
			$table->string('Phone');
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
        Schema::dropIfExists('employees');
    }
}
