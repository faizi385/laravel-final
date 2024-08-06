<?php

// database/migrations/YYYY_MM_DD_HHMMSS_create_likes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
  
public function up()
{
    Schema::table('posts', function (Blueprint $table) {
        $table->integer('likes')->default(0);
    });
}

public function down()
{
    Schema::table('posts', function (Blueprint $table) {
        $table->dropColumn('likes');
    });
}
}
