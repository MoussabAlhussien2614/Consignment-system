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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->string("product_name");
            $table->decimal("price",15,2);
            $table->unsignedInteger("commission");
            $table->unsignedInteger("quantity");
            $table->decimal("extra_expenses",15,2);
            $table->foreignId("invoice_id")->constrained("invoices")->onDelete("cascade");
            $table->timestamp("time_sold");
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
