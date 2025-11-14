@extends('layouts.frontend')

@section('content')

<div class="container with-navbar col-sm-10">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h3 class="fw-bold mb-0">{{ $category->category_name }} ({{ ucfirst($category->category_slug) }})</h3>
    </div>
    <hr />

    <div class="row g-3 my-4">
        @forelse($books as $book)
        <div class="col-6 col-md-3">
            <div class="card h-100 book-card">
                <img src="{{ asset('storage/'.$book->book_img) }}"
                    class="card-img-top"
                    alt="{{ $book->book_title }}">
                <div class="card-body p-2 d-flex flex-column">
                    <h6 class="card-title fw-bold text-truncate">
                        {{ $book->book_title }}
                    </h6>
                    <p class="card-text small text-muted">
                        {{ $book->book_author }}
                    </p>
                    <button type="button"
                        class="btn btn-sm rounded-pill mt-auto add-to-cart"
                        data-id="{{ $book->id }}"
                        data-title="{{ $book->book_title }}"
                        data-price="{{ $book->book_price }}"
                        data-img="{{ asset('storage/' . $book->book_img) }}">
                        ฿ {{ number_format($book->book_price, 2) }}
                    </button>
                </div>
            </div>
        </div>
        @empty
        <p class=" text-muted">ยังไม่มีหนังสือในหมวดนี้</p>
        @endforelse
    </div>
</div>


@endsection