@extends('layouts.app')

@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow">{{ $products->title }}</a>
                <span></span> {{ $products->category->category_name }}
                <span></span> {{ $products->slug }}
            </div>
        </div>
    </div>
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-detail accordion-detail">
                        <div class="row mb-50">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-gallery">
                                    <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                    <!-- MAIN SLIDES -->
                                    <div class="product-image-slider">
                                        <figure class="border-radius-10">
                                            <img src="/{{ $products->image }}" alt="{{ $products->title }}">
                                        </figure>
                                        <figure class="border-radius-10">
                                            <img src="/{{ $products->image }}" alt="{{ $products->title }}">
                                        </figure>
                                        <figure class="border-radius-10">
                                            <img src="/{{ $products->image }}" alt="{{ $products->title }}">
                                        </figure>
                                        <figure class="border-radius-10">
                                            <img src="/{{ $products->image }}" alt="{{ $products->title }}">
                                        </figure>
                                        <figure class="border-radius-10">
                                            <img src="/{{ $products->image }}" alt="{{ $products->title }}">
                                        </figure>
                                        <figure class="border-radius-10">
                                            <img src="/{{ $products->image }}" alt="{{ $products->title }}">
                                        </figure>
                                        <figure class="border-radius-10">
                                            <img src="/{{ $products->image }}" alt="{{ $products->title }}">
                                        </figure>
                                    </div>
                                    <!-- THUMBNAILS -->
                                    <div class="slider-nav-thumbnails pl-15 pr-15">
                                        <div><img src="/{{ $products->image }}" alt="product image"></div>
                                        <div><img src="/{{ $products->image }}" alt="product image"></div>
                                        <div><img src="/{{ $products->image }}" alt="product image"></div>
                                        <div><img src="/{{ $products->image }}" alt="product image"></div>
                                        <div><img src="/{{ $products->image }}" alt="product image"></div>
                                        <div><img src="/{{ $products->image }}" alt="product image"></div>
                                        <div><img src="/{{ $products->image }}" alt="product image"></div>
                                    </div>
                                </div>
                                <!-- End Gallery -->
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-info">
                                    <h2 class="title-detail">{{ $products->title }}</h2>
                                    <div class="product-detail-rating">
                                        <div class="pro-details-brand">
                                            <span> Brands: <a href="shop-grid-right.html">-</a></span>
                                        </div>
                                        <div class="product-rate-cover text-end">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width:90%">
                                                </div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (25 reviews)</span>
                                        </div>
                                    </div>
                                    <div class="clearfix product-price-cover">
                                        <div class="product-price primary-color float-left">
                                            <ins><span class="text-brand">{{ env('CURRENCY') }}
                                                    {{ $products->price }}</span></ins>
                                            <ins><span class="old-price font-md ml-15">{{ env('CURRENCY') }}
                                                    {{ $products->discount_price }}</span></ins>
                                            <span class="save-price  font-md color3 ml-15">25% Off</span>
                                        </div>
                                    </div>
                                    <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                                    <div class="short-desc mb-30">
                                        <p>{{ $products->short_description }}</p>
                                    </div>
                                    <div class="product_sort_info font-xs mb-30">
                                        <ul>
                                            <li class="mb-10"><i class="fi-rs-crown mr-5"></i> 1 Year AL Jazeera Brand
                                                Warranty</li>
                                            <li class="mb-10"><i class="fi-rs-refresh mr-5"></i> 30 Day Return Policy</li>
                                            <li><i class="fi-rs-credit-card mr-5"></i> Cash on Delivery available</li>
                                        </ul>
                                    </div>
                                    <div class="attr-detail attr-color mb-15">
                                        <strong class="mr-10">Color</strong>
                                        <ul class="list-filter color-filter">
                                            <li><a href="#" data-color="Red"><span
                                                        class="product-color-red"></span></a></li>
                                            <li><a href="#" data-color="Yellow"><span
                                                        class="product-color-yellow"></span></a></li>
                                            <li class="active"><a href="#" data-color="White"><span
                                                        class="product-color-white"></span></a></li>
                                            <li><a href="#" data-color="Orange"><span
                                                        class="product-color-orange"></span></a></li>
                                            <li><a href="#" data-color="Cyan"><span
                                                        class="product-color-cyan"></span></a></li>
                                            <li><a href="#" data-color="Green"><span
                                                        class="product-color-green"></span></a></li>
                                            <li><a href="#" data-color="Purple"><span
                                                        class="product-color-purple"></span></a></li>
                                        </ul>
                                    </div>
                                    <div class="attr-detail attr-size">
                                        <strong class="mr-10">Size</strong>
                                        <ul class="list-filter size-filter font-small">
                                            <li><a href="#">S</a></li>
                                            <li class="active"><a href="#">M</a></li>
                                            <li><a href="#">L</a></li>
                                            <li><a href="#">XL</a></li>
                                            <li><a href="#">XXL</a></li>
                                        </ul>
                                    </div>
                                    <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                    <div class="detail-extralink">
                                        <div class="detail-qty border radius">
                                            <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                            <span class="qty-val">1</span>
                                            <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                        </div>
                                        <?php if ($products->stock>=1) { ?>
                                        <div class="product-extra-link2">
                                            <button type="submit" class="button button-add-to-cart">Add to cart</button>
                                            <a aria-label="Add To Wishlist" class="action-btn hover-up" href="#"><i
                                                    class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn hover-up" href="#"><i
                                                    class="fi-rs-shuffle"></i></a>
                                        </div>
                                        <?php }else{ ?>
                                        <div class="product-extra-link2">
                                            <button type="submit" class="button button-out-of-stock bg-danger">Out Of
                                                Stock</button>

                                        </div>
                                        <?php } ?>
                                        <?php
                                        if(Auth::user()){?>
                                        {{-- {{route('category.show',$product->category->category_slug)}} --}}
                                        <a href="{{ route('buy_as_subscription',$products->id)}}"
                                            class="button button-buy-as-subs">Buy As Subscription</a>

                                        <?php } ?>
                                    </div>
                                    <ul class="product-meta font-xs color-grey mt-50">
                                        <li class="mb-5">SKU: <a href="#">FWM15VKT</a></li>
                                        <li class="mb-5">Tags: <a href="#" rel="tag">Cloth</a>, <a
                                                href="#" rel="tag">Women</a>, <a href="#"
                                                rel="tag">Dress</a> </li>
                                        <li>Availability:<span
                                                class="in-stock text-success ml-5">{{ $products->stock }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Detail Info -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10 m-auto entry-main-content">
                                <h2 class="section-title style-1 mb-30">Description</h2>
                                <div class="description mb-50">
                                    <p>{{ $products->long_description }}</p>

                                </div>

                                <div class="social-icons single-share">
                                    <ul class="text-grey-5 d-inline-block">
                                        <li><strong class="mr-10">Share this:</strong></li>
                                        <li class="social-facebook"><a href="#"><img
                                                    src="{{ asset('frontend-assets/imgs/theme/icons/icon-facebook.svg') }}"
                                                    alt=""></a>
                                        </li>
                                        <li class="social-twitter"> <a href="#"><img
                                                    src="assets/imgs/theme/icons/icon-twitter.svg" alt=""></a>
                                        </li>
                                        <li class="social-instagram"><a href="#"><img
                                                    src="{{ asset('frontend-assets/imgs/theme/icons/icon-instagram.svg') }}"
                                                    alt=""></a>
                                        </li>
                                        <li class="social-linkedin"><a href="#"><img
                                                    src="{{ asset('frontend-assets/imgs/theme/icons/icon-pinterest.svg') }}"
                                                    alt=""></a>
                                        </li>
                                    </ul>
                                </div>
                                {{-- comments area if required --}}
                            </div>
                        </div>
                        <div class="row mt-60">
                            <div class="col-12">
                                <h3 class="section-title style-1 mb-30">Related products</h3>
                            </div>
                            <div class="col-12">
                                <div class="row related-products">
                                    <?php
                                    foreach ($latest as $key => $latest_pro) { ?>
                                    <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                        <div class="product-cart-wrap small hover-up">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="shop-product-right.html" tabindex="0">
                                                        <img class="default-img" src="/{{ $latest_pro->image }}"
                                                            alt="">
                                                        <img class="hover-img" src="/{{ $latest_pro->image }}"
                                                            alt="">
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Quick view" class="action-btn small hover-up"
                                                        data-bs-toggle="modal" data-bs-target="#quickViewModal"><i
                                                            class="fi-rs-search"></i></a>
                                                    <a aria-label="Add To Wishlist" class="action-btn small hover-up"
                                                        href="#" tabindex="0"><i class="fi-rs-heart"></i></a>
                                                    <a aria-label="Compare" class="action-btn small hover-up"
                                                        href="#" tabindex="0"><i class="fi-rs-shuffle"></i></a>
                                                </div>
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="hot">{{ $latest_pro->product_sale_tag }}</span>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <h2><a href="shop-product-right.html"
                                                        tabindex="0">{{ $latest_pro->title }}</a></h2>
                                                <div class="rating-result" title="90%">
                                                    <span>
                                                    </span>
                                                </div>
                                                <div class="product-price">
                                                    <span>{{ env('CURRENCY ') }} {{ $latest_pro->price }} </span>
                                                    <span class="old-price">{{ env('CURRENCY ') }}
                                                        {{ $latest_pro->discount_price }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="banner-img banner-big wow fadeIn f-none animated mt-50">
                            <img class="border-radius-10" src="{{ asset('frontend-assets/imgs/banner/banner-4.png') }}"
                                alt="">
                            <div class="banner-text">
                                <h4 class="mb-15 mt-40">Repair Services</h4>
                                <h2 class="fw-600 mb-20">We're an Apple <br>Authorised Service Provider</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
