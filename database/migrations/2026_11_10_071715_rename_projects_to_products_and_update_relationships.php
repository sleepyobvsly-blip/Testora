
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Drop existing foreign keys and unique constraints
        |--------------------------------------------------------------------------
        */

        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('projects_user_id_foreign');
        });

        Schema::table('project_user', function (Blueprint $table) {
            $table->dropForeign('project_user_project_id_foreign');
            $table->dropForeign('project_user_user_id_foreign');

            $table->dropUnique(
                'project_user_project_id_user_id_unique'
            );
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->dropForeign('feedback_project_id_foreign');
            $table->dropForeign('feedback_user_id_foreign');

            $table->dropUnique('feedback_project_user_unique');
        });

        Schema::table('project_analyses', function (Blueprint $table) {
            $table->dropForeign(
                'project_analyses_project_id_foreign'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | 2. Rename tables
        |--------------------------------------------------------------------------
        */

        Schema::rename('projects', 'products');
        Schema::rename('project_user', 'product_user');
        Schema::rename('project_analyses', 'product_analyses');

        /*
        |--------------------------------------------------------------------------
        | 3. Rename project_id columns
        |--------------------------------------------------------------------------
        */

        Schema::table('product_user', function (Blueprint $table) {
            $table->renameColumn('project_id', 'product_id');
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->renameColumn('project_id', 'product_id');
        });

        Schema::table('product_analyses', function (Blueprint $table) {
            $table->renameColumn('project_id', 'product_id');
        });

        /*
        |--------------------------------------------------------------------------
        | 4. Restore foreign keys and unique constraints
        |--------------------------------------------------------------------------
        */

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('user_id', 'products_user_id_foreign')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });

        Schema::table('product_user', function (Blueprint $table) {
            $table->foreign('product_id', 'product_user_product_id_foreign')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();

            $table->foreign('user_id', 'product_user_user_id_foreign')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->unique(
                ['product_id', 'user_id'],
                'product_user_product_user_unique'
            );
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->foreign('product_id', 'feedback_product_id_foreign')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();

            $table->foreign('user_id', 'feedback_user_id_foreign')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->unique(
                ['product_id', 'user_id'],
                'feedback_product_user_unique'
            );
        });

        Schema::table('product_analyses', function (Blueprint $table) {
            $table->foreign(
                'product_id',
                'product_analyses_product_id_foreign'
            )
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Drop new foreign keys and unique constraints
        |--------------------------------------------------------------------------
        */

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_user_id_foreign');
        });

        Schema::table('product_user', function (Blueprint $table) {
            $table->dropForeign('product_user_product_id_foreign');
            $table->dropForeign('product_user_user_id_foreign');

            $table->dropUnique('product_user_product_user_unique');
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->dropForeign('feedback_product_id_foreign');
            $table->dropForeign('feedback_user_id_foreign');

            $table->dropUnique('feedback_product_user_unique');
        });

        Schema::table('product_analyses', function (Blueprint $table) {
            $table->dropForeign(
                'product_analyses_product_id_foreign'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | 2. Restore original table names
        |--------------------------------------------------------------------------
        */

        Schema::rename('products', 'projects');
        Schema::rename('product_user', 'project_user');
        Schema::rename('product_analyses', 'project_analyses');

        /*
        |--------------------------------------------------------------------------
        | 3. Restore original column names
        |--------------------------------------------------------------------------
        */

        Schema::table('project_user', function (Blueprint $table) {
            $table->renameColumn('product_id', 'project_id');
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->renameColumn('product_id', 'project_id');
        });

        Schema::table('project_analyses', function (Blueprint $table) {
            $table->renameColumn('product_id', 'project_id');
        });

        /*
        |--------------------------------------------------------------------------
        | 4. Restore original foreign keys and unique constraints
        |--------------------------------------------------------------------------
        */

        Schema::table('projects', function (Blueprint $table) {
            $table->foreign('user_id', 'projects_user_id_foreign')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });

        Schema::table('project_user', function (Blueprint $table) {
            $table->foreign('project_id', 'project_user_project_id_foreign')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();

            $table->foreign('user_id', 'project_user_user_id_foreign')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->unique(
                ['project_id', 'user_id'],
                'project_user_project_id_user_id_unique'
            );
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->foreign('project_id', 'feedback_project_id_foreign')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();

            $table->foreign('user_id', 'feedback_user_id_foreign')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->unique(
                ['project_id', 'user_id'],
                'feedback_project_user_unique'
            );
        });

        Schema::table('project_analyses', function (Blueprint $table) {
            $table->foreign(
                'project_id',
                'project_analyses_project_id_foreign'
            )
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();
        });
    }
};
