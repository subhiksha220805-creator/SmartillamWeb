<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentStore;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route as RouteDefinition;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function previewDraft(Request $request): JsonResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $fields = collect(config('cms.pages'))->flatMap(
            fn (array $page): array => collect($page['groups'])->flatMap(fn (array $group): array => $group['fields'])->all(),
        )->values();
        $rules = [
            'page' => ['required', 'string', 'in:'.implode(',', array_keys(config('cms.pages')))],
            'content' => ['nullable', 'array'],
            'clear' => ['nullable', 'array'],
            'clear.*' => ['nullable', 'boolean'],
            'image_urls' => ['nullable', 'array'],
            'image_urls.*' => ['nullable', 'url:http,https', 'max:2048'],
            'image_data' => ['nullable', 'array'],
            'image_data.*' => ['nullable', 'string', 'max:7000000'],
            'clear_images' => ['nullable', 'array'],
            'clear_images.*' => ['nullable', 'boolean'],
            'reset_images' => ['nullable', 'array'],
            'reset_images.*' => ['nullable', 'boolean'],
        ];

        foreach ($fields as $index => $field) {
            $rules["content.{$index}"] = $field['type'] === 'icon_repeater'
                ? ['nullable', 'json', 'max:20000000']
                : ['nullable', 'string', 'max:20000'];
        }

        $validated = $request->validate($rules);
        $draft = $request->session()->get('cms-preview-draft', []);

        foreach ($validated['content'] ?? [] as $index => $value) {
            $field = $fields->get((int) $index);

            if ($field !== null && $field['type'] !== 'image') {
                $draft[$field['key']] = isset($validated['clear'][$index]) ? '' : $value;
            }
        }

        foreach ($validated['clear'] ?? [] as $index => $shouldClear) {
            $field = $fields->get((int) $index);

            if ($shouldClear && $field !== null && $field['type'] !== 'image') {
                $draft[$field['key']] = '';
            }
        }

        foreach ($validated['image_urls'] ?? [] as $index => $imageUrl) {
            $field = $fields->get((int) $index);

            if ($imageUrl !== null && $field !== null && $field['type'] === 'image') {
                $draft[$field['key']] = $imageUrl;
            }
        }

        foreach ($validated['image_data'] ?? [] as $index => $imageData) {
            $field = $fields->get((int) $index);

            if ($field !== null && $field['type'] === 'image' && preg_match('/^data:image\/(?:png|jpeg|webp);base64,/', $imageData) === 1) {
                $draft[$field['key']] = $imageData;
            }
        }

        foreach ($validated['clear_images'] ?? [] as $index => $shouldClear) {
            $field = $fields->get((int) $index);

            if ($shouldClear && $field !== null && $field['type'] === 'image') {
                $draft[$field['key']] = null;
            }
        }

        foreach ($validated['reset_images'] ?? [] as $index => $shouldReset) {
            $field = $fields->get((int) $index);

            if ($shouldReset && $field !== null && $field['type'] === 'image') {
                unset($draft[$field['key']]);
            }
        }

        $request->session()->put('cms-preview-draft', $draft);

        return response()->json(['updated' => true]);
    }

    public function edit(Request $request, ContentStore $contentStore): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $pages = config('cms.pages');
        $requestedPage = $request->query('page');
        $selectedPage = is_string($requestedPage) && array_key_exists($requestedPage, $pages)
            ? $requestedPage
            : array_key_first($pages);
        $content = $contentStore->all();
        $defaults = config('cms.defaults', []);
        $router = app('router');
        $productRoute = $router->getRoutes()->getByName('products.smart-touch-switches');
        $productAction = $productRoute instanceof RouteDefinition ? $productRoute->getAction('uses') : null;

        if ($productAction instanceof \Closure) {
            $productViewData = $productAction()->getData();

            foreach ($productViewData['products'] ?? [] as $slug => $product) {
                foreach ($product as $key => $value) {
                    if (is_scalar($value)) {
                        $defaults["products.{$slug}.{$key}"] = (string) $value;
                    }
                }

                $defaults["products.{$slug}.hero_title"] ??= 'Technology That Disappears Into Your Home.';
                $defaults["products.{$slug}.hero_description"] ??= 'Elevate your living experience with hardware designed to complement luxury interiors, where intelligence is felt rather than seen.';
                $defaults["products.{$slug}.hero_image"] ??= 'images/product-hero.png';
            }
        }

        $savedFeatureNames = preg_split(
            '/\r\n|\r|\n/',
            $content['products.smart-touch-switches.feature_names'] ?? $defaults['products.smart-touch-switches.feature_names'] ?? '',
            -1,
            PREG_SPLIT_NO_EMPTY,
        );

        foreach ($savedFeatureNames as $index => $featureName) {
            $fieldKey = 'products.smart-touch-switches.feature_name_'.($index + 1);

            if (! isset($content[$fieldKey])) {
                $defaults[$fieldKey] = $featureName;
            }
        }

        foreach ([
            'smart-door-locks' => ['list' => 'methods', 'field' => 'method_name_'],
            'smart-security-systems' => ['list' => 'feature_names', 'field' => 'feature_name_'],
            'retrofit-switches' => ['list' => 'feature_names', 'field' => 'feature_name_'],
            'sliding-gate-automation' => ['list' => 'feature_names', 'field' => 'feature_name_'],
            'swing-gate-automation' => ['list' => 'feature_names', 'field' => 'feature_name_'],
        ] as $slug => $mapping) {
            $legacyList = preg_split(
                '/\r\n|\r|\n/',
                $content["products.{$slug}.{$mapping['list']}"] ?? $defaults["products.{$slug}.{$mapping['list']}"] ?? '',
                -1,
                PREG_SPLIT_NO_EMPTY,
            );

            foreach ($legacyList as $index => $itemName) {
                $fieldKey = "products.{$slug}.{$mapping['field']}".($index + 1);

                if (! isset($content[$fieldKey])) {
                    $defaults[$fieldKey] = $itemName;
                }

                if ($slug === 'smart-door-locks') {
                    $imageFieldKey = "products.{$slug}.method_image_".($index + 1);

                    if (! isset($content[$imageFieldKey]) && isset($content["products.{$slug}.methods_image"])) {
                        $defaults[$imageFieldKey] = $content["products.{$slug}.methods_image"];
                    }
                }
            }
        }

        $blogRoute = $router->getRoutes()->getByName('blog');
        $blogAction = $blogRoute instanceof RouteDefinition ? $blogRoute->getAction('uses') : null;

        if ($blogAction instanceof \Closure) {
            $blogViewData = $blogAction()->getData();

            foreach ($blogViewData['blogArticles'] ?? [] as $slug => $article) {
                foreach ($article as $key => $value) {
                    if (is_array($value)) {
                        $value = implode("\n", $value);
                    }

                    if (is_scalar($value)) {
                        $defaults["blog.{$slug}.{$key}"] = (string) $value;
                    }
                }

                $defaults["blog.{$slug}.hero_title"] ??= $article['title'] ?? '';
            }

            $featuredArticle = $blogViewData['blogArticles']['what-is-a-smart-home'] ?? [];
            $defaults['blog.featured_title'] = $featuredArticle['title'] ?? $defaults['blog.featured_title'] ?? '';
            $defaults['blog.featured_description'] = $featuredArticle['description'] ?? $defaults['blog.featured_description'] ?? '';
        }

        $index = 0;

        foreach ($pages as &$page) {
            foreach ($page['groups'] as &$group) {
                foreach ($group['fields'] as &$field) {
                    $field['index'] = $index++;
                    $field['value'] = $content[$field['key']] ?? $defaults[$field['key']] ?? '';
                }
            }
        }

        unset($field, $group, $page);

        $previewChoices = [
            'home' => [['label' => 'Home page', 'url' => route('home')]],
            'solutions' => [['label' => 'Solutions page', 'url' => route('solutions')]],
            'services' => [['label' => 'Services page', 'url' => route('services')]],
            'products' => [],
            'blog' => [['label' => 'Blog landing page', 'url' => route('blog')]],
            'about' => [['label' => 'About page', 'url' => route('about')]],
            'contact' => [['label' => 'Contact page', 'url' => route('contact')]],
        ];

        foreach ($pages['products']['groups'] as $group) {
            $slug = explode('.', $group['fields'][0]['key'])[1];
            $previewChoices['products'][] = ['label' => $group['label'], 'url' => route('products.'.$slug)];
        }

        foreach (array_slice($pages['blog']['groups'], 1) as $group) {
            $slug = explode('.', $group['fields'][0]['key'])[1];
            $previewChoices['blog'][] = ['label' => $group['label'], 'url' => route('blog.show', ['slug' => $slug])];
        }

        return view('admin.content', [
            'pages' => $pages,
            'content' => $content,
            'selectedPage' => $selectedPage,
            'previewChoices' => $previewChoices,
        ]);
    }

    public function update(Request $request, ContentStore $contentStore): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $fields = collect(config('cms.pages'))->flatMap(
            fn (array $page): array => collect($page['groups'])->flatMap(fn (array $group): array => $group['fields'])->all(),
        )->values();
        $rules = [
            'page' => ['required', 'string', 'in:'.implode(',', array_keys(config('cms.pages')))],
            'content' => ['nullable', 'array'],
            'clear' => ['nullable', 'array'],
            'images' => ['nullable', 'array'],
            'image_urls' => ['nullable', 'array'],
            'clear_images' => ['nullable', 'array'],
            'icon_uploads' => ['nullable', 'array'],
            'icon_uploads.*' => ['nullable', 'array'],
            'icon_uploads.*.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:200'],
            'icon_urls' => ['nullable', 'array'],
            'icon_urls.*' => ['nullable', 'array'],
            'icon_urls.*.*' => ['nullable', 'url:http,https', 'max:2048'],
        ];

        foreach ($fields as $index => $field) {
            if ($field['type'] === 'image') {
                $rules["images.{$index}"] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'];
                $rules["image_urls.{$index}"] = ['nullable', 'string', 'url:http,https', 'max:2048'];
                $rules["clear_images.{$index}"] = ['sometimes', 'accepted'];
            } else {
                $rules["clear.{$index}"] = ['sometimes', 'accepted'];
                $rules["content.{$index}"] = match ($field['type']) {
                    'email' => ['nullable', 'email', 'max:255'],
                    'url' => ['nullable', 'url:https', 'max:2048'],
                    'icon_repeater' => ['nullable', 'json', 'max:20000000'],
                    default => ['nullable', 'string', 'max:20000'],
                };
            }
        }

        $validated = $request->validate($rules);
        $changes = [];
        $imageUrls = $validated['image_urls'] ?? [];
        $imagesToClear = $validated['clear_images'] ?? [];
        $iconUrls = $validated['icon_urls'] ?? [];

        foreach ($fields as $index => $field) {
            if ($field['type'] === 'image') {
                if ($request->hasFile("images.{$index}")) {
                    $uploadedImage = $request->file("images.{$index}");
                    $imageDirectory = public_path('images/cms');
                    $storedName = $uploadedImage->hashName();

                    File::ensureDirectoryExists($imageDirectory);
                    $uploadedImage->move($imageDirectory, $storedName);
                    $changes[$field['key']] = 'images/cms/'.$storedName;
                } elseif (isset($imagesToClear[$index])) {
                    $changes[$field['key']] = null;
                } elseif (! empty($imageUrls[$index])) {
                    $changes[$field['key']] = $imageUrls[$index];
                }

                continue;
            }

            $value = $validated['content'][$index] ?? null;

            if ($field['type'] === 'icon_repeater' && isset($validated['clear'][$index])) {
                $changes[$field['key']] = null;

                continue;
            }

            if ($field['type'] === 'icon_repeater' && is_string($value) && $value !== '') {
                $iconItems = json_decode($value, true);

                if (! is_array($iconItems) || ! array_is_list($iconItems)) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        "content.{$index}" => 'Pillar icons must be a list of named icons.',
                    ]);
                }

                if (count($iconItems) > 24) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        "content.{$index}" => 'You can add up to 24 pillar icons.',
                    ]);
                }

                $normalizedItems = [];

                foreach ($iconItems as $itemIndex => $iconItem) {
                    $nameKey = $field['name_key'] ?? 'name';
                    if (! is_array($iconItem) || ! is_string($iconItem[$nameKey] ?? null) || ! is_string($iconItem['image'] ?? null)) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            "content.{$index}" => 'Each pillar icon needs a name and an image.',
                        ]);
                    }

                    $name = trim($iconItem[$nameKey]);
                    $image = trim($iconUrls[$index][$itemIndex] ?? $iconItem['image']);

                    if ($name === '' || mb_strlen($name) > 120) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            "content.{$index}" => 'Each pillar icon needs a name up to 120 characters.',
                        ]);
                    }

                    if ($request->hasFile("icon_uploads.{$index}.{$itemIndex}")) {
                        $uploadedIcon = $request->file("icon_uploads.{$index}.{$itemIndex}");
                        $iconDirectory = public_path('images/cms');
                        $storedName = $uploadedIcon->hashName();

                        File::ensureDirectoryExists($iconDirectory);
                        $uploadedIcon->move($iconDirectory, $storedName);
                        $image = 'images/cms/'.$storedName;
                    } elseif (str_starts_with($image, 'data:image/')) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            "content.{$index}" => 'Please upload the selected pillar icon again before saving.',
                        ]);
                    }

                    if ($image !== '' && ! str_starts_with($image, 'images/') && filter_var($image, FILTER_VALIDATE_URL) === false) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            "content.{$index}" => 'Pillar icons must use a valid image URL or an uploaded image.',
                        ]);
                    }

                    $normalizedItem = [$nameKey => $name, 'image' => $image];
                    if (isset($field['description_key'])) {
                        $descriptionValue = $iconItem[$field['description_key']] ?? '';
                        if (! is_string($descriptionValue)) {
                            throw \Illuminate\Validation\ValidationException::withMessages([
                                "content.{$index}" => 'Each card description must be text.',
                            ]);
                        }
                        $description = trim($descriptionValue);
                        if (mb_strlen($description) > 500) {
                            throw \Illuminate\Validation\ValidationException::withMessages([
                                "content.{$index}" => 'Descriptions must be 500 characters or fewer.',
                            ]);
                        }
                        $normalizedItem[$field['description_key']] = $description;
                    }
                    $normalizedItems[] = $normalizedItem;
                }

                $changes[$field['key']] = json_encode($normalizedItems, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);

                continue;
            }

            if (isset($validated['clear'][$index])) {
                $changes[$field['key']] = null;
            } elseif (is_string($value) && $value !== '') {
                $changes[$field['key']] = $value;
            }
        }

        $contentStore->save($changes);
        $request->session()->forget('cms-preview-draft');

        return redirect()->route('admin.content.edit', ['page' => $validated['page']])->with('status', 'Website content saved successfully.');
    }
}
