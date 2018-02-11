<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsLastChecked extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            // up ()
            DB::statement("ALTER TABLE `accounts` CHANGE `expires_at` `expires_at` TIMESTAMP NULL");
            $table->timestamp('last_check')->useCurrent = true;;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `accounts` CHANGE `expires_at` `expires_at` DATETIME NOT NULL;");
        DB::statement("ALTER TABLE `accounts` DROP COLUMN last_check");
    }
}
