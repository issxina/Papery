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
                    Update Category
                </div>
                <div class="card-body">
                    <form action="/category/{{ $id }}" method="post">
                        @csrf
                        @method('put')

                        {{-- Category Name --}}
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label text-end">Category Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="category_name" required placeholder="Name" value="{{ old('category_name', $category_name) }}">
                                @error('category_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Category Slug --}}
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label text-end">Category Name (Eng)</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="category_slug" required placeholder="Name Eng" value="{{ old('category_slug', $category_slug) }}">
                                @error('category_slug')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="row">
                            <div class="offset-sm-4 col-sm-6">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="/category" class="btn btn-secondary">✖ Cancel</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

