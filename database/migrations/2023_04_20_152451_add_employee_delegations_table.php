<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_delegations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('country', 100);
            $table->integer('amount_due');
            $table->string('currency');
            $table->timestamps();
        });

        // Add foreign keys.
        $this->addForeignKeys();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_delegations');
    }

    /**
     * Add foreign keys.
     *
     * @return void
     */
    private function addForeignKeys()
    {
        Schema::table('employee_delegations', function (Blueprint $table) {
            $table->foreign('employee_id', 'employee_id_foreign')->references('id')->on('employees')->onDelete('set null');
        });
    }
};
