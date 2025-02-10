<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('currency_rates', function (Blueprint $table) {
            $table->id();
            $table->string('currency_code');
            $table->string('denomination')->nullable();
            $table->decimal('buy_rate', 15, 3);
            $table->decimal('sell_rate', 15, 3);
            $table->datetime('last_update');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('currency_rates');
    }
};
