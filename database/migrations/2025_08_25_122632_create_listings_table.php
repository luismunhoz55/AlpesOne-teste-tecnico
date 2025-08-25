<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string("type");
            $table->string("brand");
            $table->string("model");
            $table->string("version")->nullable();
            $table->string("year_model");
            $table->string("year_build");
            $table->json("optionals")->nullable();
            $table->integer("doors");
            $table->string("board");
            $table->string("chassi")->nullable();
            $table->string("transmission");
            $table->integer("km");
            $table->text("description")->nullable();
            $table->timestamp("created");
            $table->timestamp("updated");
            $table->boolean("sold")->default(false);
            $table->string("category");
            $table->string("url_car");
            $table->decimal("price", 10, 2);
            $table->decimal("old_price", 10, 2)->nullable();
            $table->string("color");
            $table->string("fuel");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};

