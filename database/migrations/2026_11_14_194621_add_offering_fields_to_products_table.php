<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
        $table->string('offering_type')->default('product')->after('user_id');
        $table->string('business_name')->nullable()->after('name');
        $table->text('business_address')->nullable()->after('business_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('offering_type');
            $table->dropColumn('business_name');
            $table->dropColumn('business_address');
        });
    }
};
