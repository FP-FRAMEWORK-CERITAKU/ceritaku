<?php

use App\Models\Comment;
use App\Models\Post;
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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Post::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'creator_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignIdFor(Comment::class, 'reply_to_id')
                ->nullable()
                ->constrained('comments')
                ->cascadeOnDelete();

            $table->text('content');

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
        Schema::dropIfExists('comments');
    }
};
