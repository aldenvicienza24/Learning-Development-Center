<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->foreignId('partner_discount_id')->nullable()->after('institution')->constrained('partner_discounts')->nullOnDelete();
            $table->unsignedTinyInteger('discount_percentage')->default(0)->after('partner_discount_id');
            $table->unsignedInteger('discount_amount')->default(0)->after('discount_percentage');
            $table->unsignedInteger('final_price')->nullable()->after('discount_amount');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropForeign(['partner_discount_id']);
            $table->dropColumn(['partner_discount_id', 'discount_percentage', 'discount_amount', 'final_price']);
        });
    }
};
