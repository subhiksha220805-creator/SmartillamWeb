<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /** @var list<string> */
    private array $buttonKeys = [
        'home.nav_consultation',
        'products.smart-touch-switches.hero_primary_button',
        'products.smart-touch-switches.consultation_primary_button',
        'solutions.hero_primary_button',
        'solutions.cta_primary_button',
        'services.hero_primary_button',
        'services.final_cta_primary_button',
        'blog.hero_consultation_button',
        'blog.article_cta_primary_button',
        'about.hero_consultation_button',
        'contact.hero_primary_button',
    ];

    public function up(): void
    {
        DB::table('site_contents')
            ->whereIn('content_key', $this->buttonKeys)
            ->where('value', 'Contact Us')
            ->update(['value' => 'Book Consultation']);

        DB::table('site_contents')
            ->where('content_key', 'like', 'products.%.hero_primary_button')
            ->where('value', 'Contact Us')
            ->update(['value' => 'Book Consultation']);

        DB::table('site_contents')
            ->where('content_key', 'like', 'products.%.consultation_primary_button')
            ->where('value', 'Contact Us')
            ->update(['value' => 'Book Consultation']);
    }

    public function down(): void
    {
        // Keep the updated labels; reverting could overwrite admin edits made later.
    }
};
