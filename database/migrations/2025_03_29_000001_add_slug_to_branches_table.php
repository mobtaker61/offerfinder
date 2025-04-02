<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
        });

        // Generate slugs for existing branches
        $usedSlugs = [];
        \App\Models\Branch::with('market')->get()->each(function ($branch) use (&$usedSlugs) {
            $marketSlug = $branch->market ? \Illuminate\Support\Str::slug($branch->market->name) : '';
            $baseSlug = $marketSlug ? $marketSlug . '-' . \Illuminate\Support\Str::slug($branch->name) : \Illuminate\Support\Str::slug($branch->name);
            $slug = $baseSlug;
            $counter = 1;

            // If slug already exists, append a number
            while (in_array($slug, $usedSlugs)) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $usedSlugs[] = $slug;
            $branch->slug = $slug;
            $branch->save();
        });

        // Make slug unique and not nullable
        Schema::table('branches', function (Blueprint $table) {
            $table->string('slug')->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}; 