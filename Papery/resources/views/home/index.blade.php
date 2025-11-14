@extends('frontend')

@section('content')
{{-- Hero Section (เฉพาะหน้า Home) --}}
<section class="hero">
  <video autoplay muted loop playsinline class="hero-video">
    <source src="{{ asset('videos/book-bg.mp4') }}" type="video/mp4">
  </video>
  <div class="hero-overlay">
    <div class="container">
      <h1 class="display-4 fw-bold">ค้นพบหนังสือเล่มโปรดของคุณ</h1>
      <p class="lead">Papery ร้านหนังสือออนไลน์สำหรับคนรักการอ่าน</p>

    </div>
  </div>
</section>

<div class="container">
  <div class="row">
    <div class="col mt-4 mt-md-5"></div>
  </div>

  <!--โปรโมชั่น-->
  <div class="container mt-4" id="promotions">
    <x-book-section title="โปรโมชั่น" :books="$promotions" />
  </div>

  <!--ขายดี-->
  <div class="container mt-4" id="bestseller">
    <x-book-section title="ขายดี" :books="$bestsellers" />
  </div>

  <!--มาใหม่-->
  <div class="container mt-4" id="new">
    <x-book-section title="มาใหม่" :books="$newBooks" />
  </div>

  <!--แนะนำ-->
  <div class="container mt-4" id="recommended">
    <x-book-section title="แนะนำ" :books="$recommended" />
  </div>
</div>
@endsection

@section('showProduct')


@endsection