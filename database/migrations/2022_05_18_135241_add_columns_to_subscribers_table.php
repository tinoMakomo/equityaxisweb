<?php

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
        Schema::table('subscribers', function (Blueprint $table) {
            $table->string('mobile_number')->nullable();
            $table->string('full_name')->nullable();
            $table->string('company')->nullable();
            $table->boolean('news_updates')->default(false);
            $table->boolean('e_newspaper')->default(false);
            $table->boolean('email_services')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->dropColumn([
                'mobile_number', 'full_name', 'company', 'news_updates', 'e_newspaper', 'email_services',
            ]);
        });
    }
};
