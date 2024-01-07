<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create("tags", function (Blueprint $table) {
            $table->id();
            $table->string("title", 100);
            $table->timestamps();
        });

        Schema::create("post_tag", function (Blueprint $table) {
            $table->id();
            $table->foreignId("post_id")->constrained()->cascadeOnDelete();
            $table->foreignId("tag_id")->constrained()->cascadeOnDelete();
            $table->dateTime("created_at")->useCurrent();

            $table->unique(["post_id", "tag_id"], "post_tag_unique");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("tags");
    }
};
