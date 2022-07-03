<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('freelance_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('order_status_id')->constrained('order_statuses')->onDelete('cascade')->onUpdate('cascade');

            $table->text('file')->nullable();
            $table->text('note')->nullable();
            $table->date('expired')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
