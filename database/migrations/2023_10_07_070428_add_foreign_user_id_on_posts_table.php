<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignUserIdOnPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Add a new unsigned big integer column for the user ID
            $table->unsignedBigInteger('user_id');

            // Add a foreign key constraint that references the 'id' column of the 'users' table
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Remove the foreign key constraint
            $table->dropForeign(['user_id']);

            // Drop the 'user_id' column
            $table->dropColumn('user_id');
        });
    }
}
