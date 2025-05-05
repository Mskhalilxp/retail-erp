<?php

use App\Enums\OrderStatus;
use App\Models\Admin;
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

            $table->string('client_name')->nullable();
            $table->string('client_mobile'); // +964 [10]
            $table->json('city'); // ['id', 'name']
            $table->json('region'); // ['id', 'name']]
            $table->string('address')->nullable(); // location
            $table->text('type_name')->nullable();
            $table->integer('items_number');
            $table->integer('sale_price')->default(0);
            $table->integer('actual_price')->default(0);
            // package_size always 1
            $table->string('client_notes')->nullable(); // merchant_notes
            // replacement always 0
            $table->string('qr_id')->nullable(); // will be stored from order creation api response
            $table->json('shipping_status')->nullable(); // ['id', 'name']
            $table->integer('shipping_price')->default(0);
            $table->integer('discount')->default(0);
            $table->date('preparation_date');
            $table->string('warehouse_notes')->nullable();
            $table->tinyInteger('status')->default(OrderStatus::created->value)->comment('1: created, 2: prepared, 3: delivered, 4: returned, 5: client_contacted, 6: finished');
            $table->foreignIdFor(Admin::class, 'created_by')->constrained('admins')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Admin::class, 'prepared_by')->nullable()->constrained('admins')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Admin::class, 'client_contacted_by')->nullable()->constrained('admins')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('delivery_date')->nullable(); // عشان لما يتحول لتم التوصيل نحط التاريخ وبعدها بيومين نخفيه من عند موظف المخزن والسوشيال

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
