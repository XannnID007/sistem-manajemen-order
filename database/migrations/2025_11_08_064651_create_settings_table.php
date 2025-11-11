<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('pangkalan_name');
            $table->text('pangkalan_address');
            $table->string('pangkalan_phone', 15);
            $table->string('logo')->nullable();
            $table->decimal('price_per_unit', 10, 2)->default(20000);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
