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
        Schema::create('customer_visits', function (Blueprint $table) {
            $table->id();
            $table->enum('visit_type', ['new_call', 'repeat_call', 'order_call', 'payment_visit', 'sales_promotion_visit']);
            $table->string('location')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('shop_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('pincode')->nullable();
            $table->string('name_board_image')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('customer_category_id')->nullable()->constrained('customer_categories');
            $table->string('voice_record')->nullable();
            $table->string('reason_for_visit')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_visits');
    }
};
