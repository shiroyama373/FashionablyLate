<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // 外部キー (categories.id)
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->string('email');
            $table->string('tel');
            $table->string('address');
            $table->string('building')->nullable(); // 任意
            $table->text('detail');
            $table->timestamps(); // created_at, updated_at
        });
    }


    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
