<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class, 'creator_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('title');
            $table->text('content');
            $table->text('slug');
            $table->text('photo_background')
                ->nullable()
                ->default(null);
            $table->boolean('is_publish')
                ->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
