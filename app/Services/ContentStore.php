<?php

namespace App\Services;

use App\Models\SiteContent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class ContentStore
{
    /** @return array<string, string|null> */
    public function all(): array
    {
        if (! Schema::hasTable('site_contents')) {
            return [];
        }

        $content = Cache::remember('site-content-map', now()->addMinutes(5), function (): array {
            return SiteContent::query()->pluck('value', 'content_key')->all();
        });

        if (request()->boolean('cms_preview') && auth()->user()?->is_admin) {
            return array_replace($content, request()->session()->get('cms-preview-draft', []));
        }

        return $content;
    }

    public function get(string $key, ?string $default = null): ?string
    {
        return $this->all()[$key] ?? $default;
    }

    /** @param array<string, string|null> $values */
    public function save(array $values): void
    {
        if (! Schema::hasTable('site_contents')) {
            return;
        }

        foreach ($values as $key => $value) {
            SiteContent::query()->updateOrCreate(['content_key' => $key], ['value' => $value]);
        }

        Cache::forget('site-content-map');
    }
}
