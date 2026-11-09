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
        Schema::table('stocks', function (Blueprint $table) {
            $table->string('category')->nullable()->index()->after('description');
            $table->string('supplier')->nullable()->after('category');
            $table->string('rack_location')->nullable()->after('supplier');
            $table->string('order_stage')->default('ready')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropColumn(['category', 'supplier', 'rack_location', 'order_stage']);
        });
    }
};
