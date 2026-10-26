<?php

use App\Enums\CurrencyTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PropertyStatus;
use App\Enums\PropertyTypes;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->constrained('users');
            $table->foreignId('owner_id')->constrained();
            $table->foreignId('city_id')->constrained();

            $table->enum('status', array_column(PropertyStatus::cases(), 'value'))
                ->default(PropertyStatus::AVAILABLE->value);
            $table->enum('type', array_column(PropertyTypes::cases(), 'value'))
                  ->default(PropertyTypes::SALE->value);

            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('price');
            $table->enum('currency', array_column(CurrencyTypes::cases(), 'value'))
                  ->default(CurrencyTypes::USD->value);
            $table->text('internal_notes')->nullable();
            $table->decimal('commission_rate',4,2)->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
