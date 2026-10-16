<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ContactSubmissionController as AdminContactSubmissionController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\QuoteRequestController as AdminQuoteRequestController;
use App\Http\Controllers\ContactSubmissionController;
use App\Http\Controllers\QuoteRequestController;
use App\Services\ContentStore;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

Route::get('/', function (): View {
    return view('welcome');
})->name('home');

Route::view('/solutions', 'solutions')->name('solutions');
Route::view('/services', 'services')->name('services');
Route::post('/services/quote-requests', [QuoteRequestController::class, 'store'])->middleware('throttle:10,1')->name('quote-requests.store');

Route::get('/admin/login', [AdminAuthController::class, 'create'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'store'])->middleware('throttle:10,1')->name('admin.login.store');
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/content', [ContentController::class, 'edit'])->name('content.edit');
    Route::post('/content/preview-draft', [ContentController::class, 'previewDraft'])->name('content.preview-draft');
    Route::put('/content', [ContentController::class, 'update'])->name('content.update');
    Route::get('/messages', [AdminContactSubmissionController::class, 'index'])->name('messages.index');
    Route::delete('/messages/{contactSubmission}', [AdminContactSubmissionController::class, 'destroy'])->name('messages.destroy');
    Route::get('/quotes', [AdminQuoteRequestController::class, 'index'])->name('quotes.index');
    Route::delete('/quotes/{quoteRequest}', [AdminQuoteRequestController::class, 'destroy'])->name('quotes.destroy');
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
});

$blogArticles = [
    'what-is-a-smart-home' => [
        'category' => 'Smart Home Guide',
        'title' => 'What is a Smart Home? A Complete Guide to Home Automation in 2026',
        'hero_title' => 'What is a Smart Home?',
        'hero_accent' => 'A Complete Guide to Home Automation in 2026',
        'description' => 'A smart home connects devices and systems to make everyday life more convenient, secure, and efficient.',
        'image' => 'images/blog/article-smart-home-guide.png',
        'alt' => 'Warm smart home living room with connected lighting and controls',
        'read_time' => '8 min read',
        'date' => 'Oct 24, 2024',
        'datetime' => '2024-10-24',
        'intro' => 'A smart home integrates intelligent devices, automation systems, and connected technologies to simplify everyday life. From lighting and climate control to advanced security and entertainment, every aspect of your home can be managed effortlessly through a mobile app or voice assistant. With seamless connectivity and intelligent automation, homeowners enjoy greater convenience, improved energy efficiency, enhanced security, and complete peace of mind.',
        'section_title' => 'Why Home Automation Matters',
        'section_text' => 'Home automation brings the controls you use every day into one connected experience. You can manage your home remotely, create schedules around your routine, and let devices respond automatically to the time of day or your preferences.',
        'benefits' => ['Greater Comfort', 'Advanced Home Security', 'Improved Energy Efficiency', 'Remote Access & Monitoring', 'Personalized Automation Scenes', 'Future-Ready Technology', 'Increased Property Value', 'Smart Security', 'Intelligent Lighting'],
        'how_title' => 'How Home Automation Works',
        'how_text' => 'Smart devices communicate through a secure automation hub connected to your mobile application or voice assistant. With a single tap or voice command, you can control multiple systems simultaneously, creating personalized experiences that match your daily routine.',
        'why_text' => 'At Smart Illam, we don’t just install smart devices—we create intelligent living experiences. Every solution is designed around your home, your routines, and the level of control you want, with support from consultation through installation.',
    ],
    'smart-lighting-transforms-your-home' => [
        'category' => 'Smart Lighting', 'title' => '7 Ways Smart Lighting Transforms Your Home',
        'description' => 'Create the perfect ambiance while improving comfort and reducing energy consumption.',
        'image' => 'images/blog/article-lighting.png', 'alt' => 'Warm layered lighting in a modern kitchen', 'read_time' => '5 min read', 'date' => 'Jul 12, 2026', 'datetime' => '2026-07-12',
        'intro' => 'Smart lighting makes it easy to shape the mood and function of every room. Adjust brightness, automate lights around your routine, and control your home from a switch, phone, or voice assistant. Thoughtful lighting scenes can make mornings easier, evenings more relaxing, and everyday spaces more comfortable.',
        'section_title' => 'Lighting That Fits Your Routine', 'section_text' => 'Start with the rooms you use most. Group lights by room, set schedules for the times you wake and return home, and create scenes for reading, entertaining, or winding down.',
        'benefits' => ['Set lighting scenes for each activity', 'Schedule lights around your day', 'Control lights remotely', 'Dim lights to reduce energy use', 'Use voice commands for hands-free control', 'Make arrival and departure routines automatic'],
        'how_title' => 'Plan a Smart Lighting Setup', 'how_text' => 'Choose compatible smart switches or lighting controls for your existing wiring, then group them by room or purpose. A well-planned setup keeps everyday controls simple while allowing you to add more rooms over time.',
        'why_text' => 'Smart Illam helps you choose lighting controls that work with your home and routines, then configures scenes and schedules so the system feels natural from day one.',
    ],
    'top-smart-home-trends-2026' => [
        'category' => 'Smart Home Basics', 'title' => 'Top Smart Home Trends in 2026',
        'description' => 'Explore the innovations shaping the next generation of connected living.',
        'image' => 'images/blog/article-home-theatre.png', 'alt' => 'Home theatre with integrated lighting and connected controls', 'read_time' => '5 min read', 'date' => 'Jul 12, 2026', 'datetime' => '2026-07-12',
        'intro' => 'Connected homes are becoming easier to use as lighting, entertainment, climate, and security systems work together. The most useful trend is not adding more screens; it is making everyday controls simpler, more responsive, and better suited to the people who live in the home.',
        'section_title' => 'A More Connected Home', 'section_text' => 'Homeowners are looking for systems that bring essential controls together, respond to simple routines, and remain flexible as their needs change.',
        'benefits' => ['Unified control across rooms', 'Personalized routines and scenes', 'Voice and app control', 'More responsive security alerts', 'Smarter energy management', 'Flexible systems that can grow'],
        'how_title' => 'Choose Trends That Solve Real Needs', 'how_text' => 'Begin with a daily frustration, such as managing multiple remotes or forgetting to switch off lights. Select compatible devices that solve that problem, then expand the system when you are ready.',
        'why_text' => 'Smart Illam designs practical automation around your priorities, balancing useful new features with controls that remain straightforward for the whole family.',
    ],
    'essential-smart-security-for-every-home' => [
        'category' => 'Home Security', 'title' => 'Essential Smart Security for Every Home',
        'description' => 'Discover how smart locks, CCTV, video door phones, and motion sensors work together to protect your family.',
        'image' => 'images/blog/article-security.png', 'alt' => 'Modern home exterior with smart security and entrance lighting', 'read_time' => '5 min read', 'date' => 'Jul 12, 2026', 'datetime' => '2026-07-12',
        'intro' => 'A thoughtful smart security system helps you see what is happening at home and respond quickly when something needs attention. Connected locks, cameras, video door phones, and sensors can work together while keeping everyday access convenient for your household.',
        'section_title' => 'Build Security in Layers', 'section_text' => 'Start with the entrances and areas that matter most. Combine visible monitoring with secure access controls and timely alerts, then make sure every household member understands how to use the system.',
        'benefits' => ['Check entrances remotely', 'Receive alerts when activity is detected', 'See and speak with visitors', 'Manage access for family and guests', 'Review camera footage when needed', 'Connect security with lighting routines'],
        'how_title' => 'Make Security Easy to Manage', 'how_text' => 'Connect compatible devices to a central app and configure alerts for meaningful events. Clear permissions and reliable network coverage help keep the system useful and dependable.',
        'why_text' => 'Smart Illam can help plan cameras, locks, sensors, and video door phones as one coordinated system, tailored to your property and daily routines.',
    ],
    'choosing-the-right-smart-home-system' => [
        'category' => 'Smart Home Basics', 'title' => 'Choosing the Right Smart Home System',
        'description' => 'Find the perfect automation solution that matches your lifestyle, home size, and future needs.',
        'image' => 'images/blog/article-smart-home-system.png', 'alt' => 'Calm bedroom with connected home controls', 'read_time' => '5 min read', 'date' => 'Jul 12, 2026', 'datetime' => '2026-07-12',
        'intro' => 'The right smart home system starts with the way you live. Whether you want easier lighting control, safer access, or a fully connected home, planning around your routines helps avoid unnecessary complexity and makes it easier to expand later.',
        'section_title' => 'Start With Your Priorities', 'section_text' => 'List the tasks you want to simplify, the rooms you use most, and the controls your family already prefers. Then check device compatibility, network coverage, and how the system can grow over time.',
        'benefits' => ['Choose controls that suit your family', 'Prioritize the rooms you use most', 'Check compatibility before buying', 'Plan for reliable network coverage', 'Add devices in stages', 'Keep manual controls easy to use'],
        'how_title' => 'Plan for Today and Later', 'how_text' => 'A good system can begin with a few high-value automations and expand as your needs change. A clear plan helps devices work together and keeps the experience consistent across rooms.',
        'why_text' => 'Smart Illam guides you through product selection and system planning, then installs and configures a solution matched to your home and priorities.',
    ],
    'voice-controlled-living-made-simple' => [
        'category' => 'Voice Assistants', 'title' => 'Voice-Controlled Living Made Simple',
        'description' => 'See how Google Assistant and Alexa make everyday tasks faster, easier, and hands-free.',
        'image' => 'images/blog/article-voice-control.png', 'alt' => 'Voice assistant in a connected bedroom', 'read_time' => '5 min read', 'date' => 'Jul 12, 2026', 'datetime' => '2026-07-12',
        'intro' => 'Voice control gives you a hands-free way to manage compatible lights, curtains, and other smart devices. With clear device names and a few useful routines, simple spoken commands can make everyday tasks more convenient for everyone at home.',
        'section_title' => 'Make Voice Commands Natural', 'section_text' => 'Use room names and familiar phrases, group devices into scenes, and keep commands short. Start with common tasks such as switching off lights or setting a comfortable evening scene.',
        'benefits' => ['Control devices without reaching for a phone', 'Manage several devices with one routine', 'Set scenes with natural phrases', 'Support accessibility and convenience', 'Use compatible voice assistant platforms', 'Keep app and switch controls available'],
        'how_title' => 'Connect Your Assistant', 'how_text' => 'Link compatible smart devices to your chosen assistant, organize them by room, and test the commands your household will use. Keep device names distinct so voice requests are understood correctly.',
        'why_text' => 'Smart Illam helps integrate compatible voice assistants with your automation system and configures scenes that are easy to remember and use.',
    ],
    'smart-homes-a-valuable-investment' => [
        'category' => 'Energy Efficiency', 'title' => 'Smart Homes: A Valuable Investment',
        'description' => 'Learn how intelligent automation improves lifestyle, enhances security, and increases property value.',
        'image' => 'images/blog/article-energy-efficiency.png', 'alt' => 'Comfortable living room with integrated lighting and energy control', 'read_time' => '5 min read', 'date' => 'Jul 12, 2026', 'datetime' => '2026-07-12',
        'intro' => 'Smart home technology can add lasting value when it solves practical problems. Automation can make daily routines smoother, help manage energy use, and bring lighting and security controls together in a home that is easier to operate.',
        'section_title' => 'Value Beyond Convenience', 'section_text' => 'The strongest return comes from choosing reliable systems that fit the property and are simple for residents to use. Consider ongoing support, compatibility, and the ability to expand when evaluating a smart home investment.',
        'benefits' => ['Improve day-to-day comfort', 'Manage lighting and energy schedules', 'Strengthen access and security', 'Simplify control for residents', 'Plan for future upgrades', 'Add useful features to the property'],
        'how_title' => 'Invest in a Practical Plan', 'how_text' => 'Identify the most useful improvements first, compare compatible solutions, and plan installation with future expansion in mind. A staged approach can make the investment manageable while delivering benefits early.',
        'why_text' => 'Smart Illam provides end-to-end automation planning and installation, helping homeowners choose useful features and build a dependable system over time.',
    ],
];

Route::get('/blog', function () use ($blogArticles): View {
    $content = app(ContentStore::class)->all();

    foreach ($blogArticles as $slug => &$article) {
        foreach (['category', 'title', 'hero_title', 'hero_accent', 'read_time', 'date', 'datetime', 'description', 'intro', 'section_title', 'section_text', 'how_title', 'how_text', 'why_text', 'image', 'alt'] as $field) {
            $contentKey = "blog.{$slug}.{$field}";

            if (array_key_exists($field, $article)) {
                $article[$field] = $content[$contentKey] ?? $article[$field];
            } elseif (isset($content[$contentKey])) {
                $article[$field] = $content[$contentKey];
            }
        }

        if (isset($content["blog.{$slug}.benefits"])) {
            $article['benefits'] = preg_split('/\\r\\n|\\r|\\n/', $content["blog.{$slug}.benefits"], -1, PREG_SPLIT_NO_EMPTY);
        }
    }

    return view('blog', ['blogArticles' => $blogArticles]);
})->name('blog');

Route::get('/blog/{slug}', function (string $slug) use ($blogArticles): View {
    abort_unless(isset($blogArticles[$slug]), 404);

    $article = $blogArticles[$slug];
    $content = app(ContentStore::class)->all();

    foreach (['category', 'title', 'hero_title', 'hero_accent', 'read_time', 'date', 'datetime', 'description', 'intro', 'section_title', 'section_text', 'how_title', 'how_text', 'why_text', 'image', 'alt'] as $field) {
        $contentKey = "blog.{$slug}.{$field}";

        if (array_key_exists($field, $article)) {
            $article[$field] = $content[$contentKey] ?? $article[$field];
        } elseif (isset($content[$contentKey])) {
            $article[$field] = $content[$contentKey];
        }
    }

    if (isset($content["blog.{$slug}.benefits"])) {
        $article['benefits'] = preg_split('/\\r\\n|\\r|\\n/', $content["blog.{$slug}.benefits"], -1, PREG_SPLIT_NO_EMPTY);
    }

    return view('blog-article', ['article' => $article, 'slug' => $slug]);
})->name('blog.show');

Route::get('/about', function (): View {
    return view('about');
})->name('about');

Route::get('/contact', function (): View {
    return view('contact');
})->name('contact');
Route::post('/contact/messages', [ContactSubmissionController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('contact.submissions.store');

$products = [
    'smart-touch-switches' => [
        'name' => 'Smart Touch Switches',
        'image' => 'images/touch-switch/solution-bedroom.png',
        'alt' => 'Smart touch switches in a modern bedroom',
    ],
    'smart-curtain-control' => [
        'name' => 'Smart Curtain Control',
        'image' => 'images/smart-curtain-control/living-room.png',
        'alt' => 'Automated curtains in a sunlit modern living room',
        'hero_title' => 'Technology That Disappears Into Your Home.',
        'hero_description' => 'Elevate your living experience with hardware designed to complement luxury interiors, where intelligence is felt rather than seen.',
    ],
    'smart-door-locks' => [
        'name' => 'Smart Door Locks',
        'image' => 'images/touch-switch/solution-door.jpg',
        'alt' => 'Smart door lock on a contemporary home entrance',
    ],
    'smart-security-systems' => [
        'name' => 'Smart Security Systems',
        'image' => 'images/touch-switch/solution-security.jpg',
        'alt' => 'Smart security controls for a modern home',
        'hero_title' => 'See. Speak. Secure.',
        'hero_description' => 'Experience complete control over your home’s entrance with our intelligent Video Door Phone system. See who’s at your door, communicate with visitors in real time, receive instant notifications, and unlock your door remotely—all from your smartphone.',
    ],
    'cctv-surveillance-system' => [
        'name' => 'CCTV Surveillance System',
        'image' => 'images/touch-switch/solution-cctv.png',
        'alt' => 'Connected CCTV surveillance system',
        'hero_title' => 'Protect What Matters Most, Every Second.',
        'hero_description' => 'Stay connected to your property with intelligent CCTV surveillance that delivers crystal-clear video, real-time monitoring, instant alerts, and remote access from anywhere in the world.',
    ],
    'voice-integrations' => [
        'name' => 'Voice Integrations',
        'image' => 'images/voice-integrations/voice-control.png',
        'alt' => 'Voice control for a connected smart home',
        'hero_title' => 'Your Home Listens. You Simply Speak.',
        'hero_description' => 'Transform everyday living with seamless voice control. Integrate your smart home with Amazon Alexa and Google Assistant to control lights, switches, curtains, locks, and more—using simple voice commands.',
    ],
    'retrofit-switches' => [
        'name' => 'Retrofit Switches',
        'image' => 'images/retrofit-switches/switch-intro.png',
        'alt' => 'Smart retrofit switch installed on a wall',
        'hero_image' => 'images/product-hero.png',
        'hero_title' => 'Make Every Existing Switch Smart Without Rewiring',
        'hero_description' => 'Upgrade your traditional electrical switches into intelligent smart devices without replacing your existing wiring or switch panels. The Smart Retrofit Module Switch brings automation, voice control, remote access, and scheduling to your current electrical infrastructure with minimal installation effort.',
    ],
    'water-level-controllers' => [
        'name' => 'Water Level Controllers',
        'image' => 'images/water-level-controllers/water-system.jpg',
        'alt' => 'Water pipes and level control equipment in a utility room',
        'hero_image' => 'images/product-hero.png',
        'hero_title' => 'Intelligent Water Management for Every Home',
        'hero_description' => 'Automate your water tank management with a smart controller that monitors water levels, prevents overflow, protects your motor from dry running, and ensures a reliable water supply—all without manual intervention.',
    ],
    'swing-gate-automation' => [
        'name' => 'Swing Gate Automation',
        'image' => 'images/gate-automation/swing-gate.png',
        'alt' => 'Automated swing gates at a residential entrance',
        'hero_image' => 'images/gate-automation/gate-hero.png',
        'hero_title' => 'Elegant Automation for Every Entrance',
        'hero_description' => 'Enhance the convenience, security, and sophistication of your property with our Smart Swing Gate Automation System. Designed for smooth and reliable operation, it delivers intelligent access control while complementing modern residential and commercial entrances.',
    ],
    'sliding-gate-automation' => [
        'name' => 'Sliding Gate Automation',
        'image' => 'images/gate-automation/sliding-gate.png',
        'alt' => 'Modern black sliding driveway gate',
        'hero_image' => 'images/gate-automation/gate-hero.png',
        'hero_title' => 'Intelligent Access. Enhanced Security.',
        'hero_description' => 'Upgrade your property’s entrance with advanced gate automation systems designed for convenience, security, and reliable performance. From residential driveways to commercial and industrial entrances, our smart gate solutions deliver effortless access control with smooth, automated operation.',
    ],
];

Route::get('/products', function () use ($products): View {
    $content = app(ContentStore::class)->all();

    foreach ($products as $productSlug => &$productDetails) {
        foreach (['name', 'image', 'alt', 'hero_title', 'hero_description'] as $field) {
            $productDetails[$field] = $content["products.{$productSlug}.{$field}"] ?? $productDetails[$field] ?? null;
        }
    }

    return view('products.index', ['products' => $products]);
})->name('products.index');

foreach (array_keys($products) as $slug) {
    Route::get('/products/'.$slug, function () use ($products, $slug): View {
        $content = app(ContentStore::class)->all();
        $genericHeroValues = [
            'hero_title' => 'Technology That Disappears Into Your Home.',
            'hero_description' => 'Elevate your living experience with hardware designed to complement luxury interiors, where intelligence is felt rather than seen.',
            'hero_image' => 'images/product-hero.png',
        ];

        foreach ($products as $productSlug => &$productDetails) {
            foreach (['name', 'image', 'alt', 'hero_title', 'hero_description', 'hero_image'] as $field) {
                $contentValue = $content["products.{$productSlug}.{$field}"] ?? null;

                if ($productSlug === 'sliding-gate-automation' && isset($genericHeroValues[$field]) && $contentValue === $genericHeroValues[$field]) {
                    continue;
                }

                $productDetails[$field] = $contentValue ?? $productDetails[$field] ?? null;
            }
        }

        $product = $products[$slug];

        return view('products.catalog', [
            'product' => $product,
            'products' => $products,
            'slug' => $slug,
        ]);
    })->name('products.'.$slug);
}
