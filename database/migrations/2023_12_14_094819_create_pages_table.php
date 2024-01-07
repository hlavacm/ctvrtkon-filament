<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create("pages", function (Blueprint $table) {
            $table->id();
            $table->string("title", 100);
            $table->string("slug", 100)->unique();
            $table->string("description", 250)->nullable();
            $table->text("content");
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("pages");
    }
};
