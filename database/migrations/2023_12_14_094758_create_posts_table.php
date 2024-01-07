<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create("posts", function (Blueprint $table) {
            $table->id();
            $table->foreignId("author_id")->constrained("users");
            $table->foreignId("category_id")->constrained("categories");
            $table->string("title", 100);
            $table->string("slug", 100)->unique();
            $table->string("description", 250)->nullable();
            $table->text("content");
            $table->datetime("published_at")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("posts");
    }
};
