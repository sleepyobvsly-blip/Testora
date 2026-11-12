<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('upload_fee', 10, 2)->nullable();

            $table->string('payment_status')->default('paid');

            $table->timestamp('paid_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'upload_fee',
                'payment_status',
                'paid_at',
            ]);
        });
    }
};
