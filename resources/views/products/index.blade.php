@extends('layouts.app')

@section('title', 'Our Products | Smart Illam')
@section('body-class', 'products-index-page')

@section('content')
    <section class="products-index section-space" aria-labelledby="products-index-heading">
        <div class="container">
            <div class="products-index__heading">
                <p class="section-eyebrow">Smart Illam</p>
                <h1 id="products-index-heading">Explore Our Products</h1>
                <p>Discover smart home products designed to make everyday living more comfortable, secure, and connected.</p>
            </div>

            <div class="products-index__grid">
                @foreach ($products as $slug => $product)
                    @php
                        $productImage = $product['image'] ?? 'images/product-hero.png';
                        $productImageUrl = \Illuminate\Support\Str::startsWith($productImage, ['http://', 'https://', 'data:']) ? $productImage : asset($productImage);
                    @endphp
                    <a class="products-index__card" href="{{ route('products.'.$slug) }}">
                        <div class="products-index__image-wrap">
                            <img src="{{ $productImageUrl }}" alt="{{ $product['alt'] ?? $product['name'] }}" loading="lazy">
                        </div>
                        <div class="products-index__card-content">
                            <h2>{{ $product['name'] }}</h2>
                            <p>{{ $product['hero_description'] ?? 'Explore product details and discover a smarter way to live.' }}</p>
                            <span>Explore product <span aria-hidden="true">↗</span></span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    @include('partials.site-footer')
@endsection
