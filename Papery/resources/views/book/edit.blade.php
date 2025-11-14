@extends('home')

@section('css_before')
<style>
    /* Card style */
    .card-custom {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: none;
        background: #fff;
    }

    .card-header {
        background: #574f44; /* น้ำตาลเข้มตามธีม */
        color: #fff;
        font-size: 18px;
        font-weight: 600;
        padding: 15px 20px;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .form-label {
        font-weight: 500;
        color: #574f44;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #8dba98;
    }

    .form-control:focus {
        border-color: #498259;
        box-shadow: 0 0 0 0.2rem rgba(141, 186, 152, 0.4);
    }

    .btn-primary {
        background: #498259;
        border: none;
        color: #fff;
        transition: 0.3s;
    }
    .btn-primary:hover {
        background: #8dba98;
        color: #fff;
    }

    .btn-secondary {
        background: #f7f4ed;
        border: 1px solid #574f44;
        color: #574f44;
        transition: 0.3s;
    }
    .btn-secondary:hover {
        background: #574f44;
        color: #fff;
    }

    .text-danger {
        font-size: 14px;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <div class="card card-custom">
                <div class="card-header">
                    Update Book
                </div>
                <div class="card-body">
                    <form action="/book/{{ $id }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        {{-- Title --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Title</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="book_title" required placeholder="Enter title" minlength="3" value="{{ old('book_title', $book_title) }}">
                                @error('book_title')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Author --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Author</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="book_author" required placeholder="Enter author" value="{{ old('book_author', $book_author) }}">
                                @error('book_author')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Price --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Price</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" name="book_price" required placeholder="Enter price" value="{{ old('book_price', $book_price) }}">
                                @error('book_price')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- QTY --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">QTY</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" name="book_stock_qty" required placeholder="Enter qty" value="{{ old('book_stock_qty', $book_stock_qty) }}">
                                @error('book_stock_qty')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Category --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Category</label>
                            <div class="col-sm-7">
                                <select name="category_id" class="form-control" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach($categoryList as $cat)
                                    <option value="{{ $cat->id }}" {{ (old('category_id', $category_id) == $cat->id) ? 'selected' : '' }}>
                                        {{ $cat->category_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Pic --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Pic</label>
                            <div class="col-sm-7">
                                @if($book_img)
                                <img src="{{ asset('storage/' . $book_img) }}" alt="Book Image" class="book-img mb-3"><br>
                                @endif
                                <input type="file" class="form-control" name="book_img" accept="image/*">
                                @error('book_img')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="row">
                            <div class="offset-sm-3 col-sm-7">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="/book" class="btn btn-secondary">✖ Cancel</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
