<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
    {
        Schema::create('whatsapp_instance', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('instance_name');
            $table->string('number');
            $table->string('status')->nullable();          // 'connecting', 'connected', 'disconnected', etc.
            $table->integer('status_reason')->nullable();  // ex: 401
            $table->string('sender')->nullable();          // ex: 5581...@s.whatsapp.net
            $table->json('last_event')->nullable();        // Último webhook recebido
            $table->timestamp('last_event_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('whatsapp_instance');
    }
};
