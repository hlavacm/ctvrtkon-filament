<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create("categories", function (Blueprint $table) {
            $table->id();
            $table->foreignId("parent_id")->nullable()->constrained("categories");
            $table->string("title", 100);
            $table->string("slug", 100)->unique();
            $table->string("description", 250)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("categories");
    }
};
