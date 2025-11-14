@extends('layouts.frontend')

@section('content')

<div class="container mt-4 with-navbar">
    <h3 class="fw-bold mb-3 text-capitalize">
        ผลการค้นหา: <span class="text-success">"{{ $keyword }}"</span>
    </h3>
    <hr />

    <div class="row g-3 my-4">
        @forelse($book as $books)
        <div class="col-6 col-md-3">
            <div class="card h-100 book-card">
                <img src="{{ asset('storage/'.$books->book_img) }}"
                    class="card-img-top"
                    alt="{{ $books->book_title }}">
                <div class="card-body p-2 d-flex flex-column">
                    <h6 class="card-title fw-bold text-truncate">
                        {{ $books->book_title }}
                    </h6>
                    <p class="card-text small text-muted">
                        {{ $books->book_author }}
                    </p>
                    <button type="button"
                        class="btn btn-sm rounded-pill mt-auto add-to-cart"
                        data-id="{{ $books->id }}"
                        data-title="{{ $books->book_title }}"
                        data-price="{{ $books->book_price }}"
                        data-img="{{ asset('storage/' . $books->book_img) }}">
                        ฿ {{ number_format($books->book_price, 2) }}
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-muted">ไม่พบหนังสือที่เกี่ยวข้องกับคำค้นหา</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $book->appends(['keyword' => $keyword])->links() }}
    </div>
</div>

@endsection