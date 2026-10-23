<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_contents')
            ->where('content_key', 'home.nav_consultation')
            ->where('value', 'Contact Us')
            ->update(['value' => 'Book Consultation']);
    }

    public function down(): void
    {
        // Keep the updated label; reverting could overwrite later admin edits.
    }
};
