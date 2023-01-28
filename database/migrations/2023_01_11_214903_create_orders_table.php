<?php

use App\Enums\OrderStatusEnum;
use App\Enums\SaleStatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
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
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('total_price', 12, 2)->default(0.00);
            $table->boolean('delivered')->default(0);
            $table->decimal('total_paid', 12, 2)->default(0.00);
            $table->date('date')->default(now());
            $table->enum('status', OrderStatusEnum::values());
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
};
