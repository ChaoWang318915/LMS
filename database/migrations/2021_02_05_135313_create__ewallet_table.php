<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEwalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payu_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('paid_for_id')->nullable();
            $table->string('paid_for_type')->nullable();
            $table->string('transaction_id')->unique();
            $table->text('gateway');
            $table->text('body');
            $table->string('destination');
            $table->text('hash');
            $table->text('response')->nullable();
            $table->enum('status', ['pending', 'failed', 'successful', 'invalid'])->default('pending')->index();
            $table->timestamp('verified_at')->nullable()->index();
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
        Schema::dropIfExists('_ewallet');
    }
}
