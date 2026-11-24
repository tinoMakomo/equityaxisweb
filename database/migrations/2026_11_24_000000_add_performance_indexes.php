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
        Schema::table('category_posts', function (Blueprint $table) {
            $table->index(['category_id', 'post_id'], 'idx_category_posts_cat_post');
            $table->index('post_id', 'idx_category_posts_post_id');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->index(['status', 'deleted_at', 'id'], 'idx_posts_status_deleted_id');
            $table->index(['status', 'is_archived', 'created_at'], 'idx_posts_status_archived_created');
            $table->index('user_id', 'idx_posts_user_id');
            $table->index('slug', 'idx_posts_slug');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->index(['parent', 'position'], 'idx_categories_parent_position');
        });

        Schema::table('ads', function (Blueprint $table) {
            $table->index('preset', 'idx_ads_preset');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_posts', function (Blueprint $table) {
            $table->dropIndex('idx_category_posts_cat_post');
            $table->dropIndex('idx_category_posts_post_id');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex('idx_posts_status_deleted_id');
            $table->dropIndex('idx_posts_status_archived_created');
            $table->dropIndex('idx_posts_user_id');
            $table->dropIndex('idx_posts_slug');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_parent_position');
        });

        Schema::table('ads', function (Blueprint $table) {
            $table->dropIndex('idx_ads_preset');
        });
    }
};
