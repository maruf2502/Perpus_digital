@extends('layouts.main')

@include('layouts.header')

@section('main-banner')

    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="caption header-text">
                    <h6>Welcome In</h6>
                    <h2>LIBRARY!</h2>
                    @auth
                        <p>Halo, <strong>{{ Auth::user()->name }}</strong>! Anda login sebagai
                            <strong>{{ ucfirst(Auth::user()->role) }}</strong>.</p>
                    @endauth
                    <p>Selamat datang di Perpustakaan Online kami — pusat referensi digital yang dirancang untuk memudahkan Anda dalam mencari, membaca, dan meminjam berbagai koleksi buku secara praktis. Dengan sistem yang cepat dan user-friendly, kami hadir untuk mendukung kebutuhan literasi Anda di era digital.
                     Jelajahi ribuan judul buku, kelola peminjaman dengan mudah, dan nikmati kemudahan belajar di mana saja, kapan saja.</p>
                    <div class="search-input">
                        <form id="search" action="#">
                            <input type="text" placeholder="Type Something" id='searchText' name="searchKeyword"
                                onkeypress="handle" />
                            <button role="button">Search Now</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-2">
                <div class="right-image">
                    <img src={{"template/images/perpus.jpg"  }} alt="">
                    <span class="price"></span>
                    <span class="offer">-</span>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('features')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <a href="#">
                    <div class="item">
                        <div class="image">
                            <img src={{"template/images/featured-01.png" }} alt="" style="max-width: 44px;">
                        </div>
                        <h4>Free Storage</h4>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="#">
                    <div class="item">
                        <div class="image">
                            <img src={{"template/images/featured-02.png" }} alt="" style="max-width: 44px;">
                        </div>
                        <h4>User More</h4>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="#">
                    <div class="item">
                        <div class="image">
                            <img src={{"template/images/featured-03.png" }} alt="" style="max-width: 44px;">
                        </div>
                        <h4>Reply Ready</h4>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="#">
                    <div class="item">
                        <div class="image">
                            <img src={{"template/images/featured-04.png"  }} alt="" style="max-width: 44px;">
                        </div>
                        <h4>Easy Layout</h4>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('section-trending')
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-heading">
                    <h6>Trending</h6>
                    <h2>Trending Buku</h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="main-button">
                    <a href="shop.html">View All</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="item">
                    <div class="thumb">
                        <a href="product-details.html"><img src={{"template/images/trending-01.jpg"  }} alt=""></a>
                        <span class="price"><em>$28</em>$20</span>
                    </div>
                    <div class="down-content">
                        <span class="category">Action</span>
                        <h4>Assasin Creed</h4>
                        <a href="product-details.html"><i class="fa fa-shopping-bag"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="item">
                    <div class="thumb">
                        <a href="product-details.html"><img src={{"template/images/trending-02.jpg"  }} alt=""></a>
                        <span class="price">$44</span>
                    </div>
                    <div class="down-content">
                        <span class="category">Action</span>
                        <h4>Assasin Creed</h4>
                        <a href="product-details.html"><i class="fa fa-shopping-bag"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="item">
                    <div class="thumb">
                        <a href="product-details.html"><img src={{"template/images/trending-03.jpg" }} alt=""></a>
                        <span class="price"><em>$64</em>$44</span>
                    </div>
                    <div class="down-content">
                        <span class="category">Action</span>
                        <h4>Assasin Creed</h4>
                        <a href="product-details.html"><i class="fa fa-shopping-bag"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="item">
                    <div class="thumb">
                        <a href="product-details.html"><img src={{"template/images/trending-04.jpg"  }} alt=""></a>
                        <span class="price">$32</span>
                    </div>
                    <div class="down-content">
                        <span class="category">Action</span>
                        <h4>Assasin Creed</h4>
                        <a href="product-details.html"><i class="fa fa-shopping-bag"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('section-most-played')
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-heading">
                    <h6>TOP GAMES</h6>
                    <h2>Most Played</h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="main-button">
                    <a href="shop.html">View All</a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="item">
                    <div class="thumb">
                        <a href="product-details.html"><img src={{"template/images/top-game-01.jpg" }} alt=""></a>
                    </div>
                    <div class="down-content">
                        <span class="category">Adventure</span>
                        <h4>Assasin Creed</h4>
                        <a href="product-details.html">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="item">
                    <div class="thumb">
                        <a href="product-details.html"><img src={{"template/images/top-game-02.jpg" }} alt=""></a>
                    </div>
                    <div class="down-content">
                        <span class="category">Adventure</span>
                        <h4>Assasin Creed</h4>
                        <a href="product-details.html">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="item">
                    <div class="thumb">
                        <a href="product-details.html"><img src={{"template/images/top-game-03.jpg" }} alt=""></a>
                    </div>
                    <div class="down-content">
                        <span class="category">Adventure</span>
                        <h4>Assasin Creed</h4>
                        <a href="product-details.html">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="item">
                    <div class="thumb">
                        <a href="product-details.html"><img src={{"template/images/top-game-04.jpg"  }} alt=""></a>
                    </div>
                    <div class="down-content">
                        <span class="category">Adventure</span>
                        <h4>Assasin Creed</h4>
                        <a href="product-details.html">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="item">
                    <div class="thumb">
                        <a href="product-details.html"><img src={{"template/images/top-game-05.jpg" }} alt=""></a>
                    </div>
                    <div class="down-content">
                        <span class="category">Adventure</span>
                        <h4>Assasin Creed</h4>
                        <a href="product-details.html">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="item">
                    <div class="thumb">
                        <a href="product-details.html"><img src={{"template/images/top-game-06.jpg"  }} alt=""></a>
                    </div>
                    <div class="down-content">
                        <span class="category">Adventure</span>
                        <h4>Assasin Creed</h4>
                        <a href="product-details.html">Explore</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('section-categoris')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-heading">
                    <h6>Categories</h6>
                    <h2>Top Categories</h2>
                </div>
            </div>
            <div class="col-lg col-sm-6 col-xs-12">
                <div class="item">
                    <h4>Action</h4>
                    <div class="thumb">
                        <a href="product-details.html"><img src={{"template/images/categories-01.jpg" }} alt=""></a>
                    </div>
                </div>
            </div>
            <div class="col-lg col-sm-6 col-xs-12">
                <div class="item">
                    <h4>Action</h4>
                    <div class="thumb">
                        <a href="product-details.html"><img src={{"template/images/categories-05.jpg"  }} alt=""></a>
                    </div>
                </div>
            </div>
            <div class="col-lg col-sm-6 col-xs-12">
                <div class="item">
                    <h4>Action</h4>
                    <div class="thumb">
                        <a href="product-details.html"><img src={{"template/images/categories-03.jpg"  }} alt=""></a>
                    </div>
                </div>
            </div>
            <div class="col-lg col-sm-6 col-xs-12">
                <div class="item">
                    <h4>Action</h4>
                    <div class="thumb">
                        <a href="product-details.html"><img src={{"template/images/categories-04.jpg"  }} alt=""></a>
                    </div>
                </div>
            </div>
            <div class="col-lg col-sm-6 col-xs-12">
                <div class="item">
                    <h4>Action</h4>
                    <div class="thumb">
                        <a href="product-details.html"><img src={{"template/images/categories-05.jpg"  }} alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('section-cta')
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="shop">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-heading">
                                <h6>Our Shop</h6>
                                <h2>Go Pre-Order Buy & Get Best <em>Prices</em> For You!</h2>
                            </div>
                            <p>Lorem ipsum dolor consectetur adipiscing, sed do eiusmod tempor incididunt.</p>
                            <div class="main-button">
                                <a href="shop.html">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-2 align-self-end">
                <div class="subscribe">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-heading">
                                <h6>NEWSLETTER</h6>
                                <h2>Get Up To $100 Off Just Buy <em>Subscribe</em> Newsletter!</h2>
                            </div>
                            <div class="search-input">
                                <form id="subscribe" action="#">
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" placeholder="Your email...">
                                    <button type="submit">Subscribe Now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
