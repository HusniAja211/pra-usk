@extends('app')

@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h4 class="text-muted">Edit Book</h4>
        </div>

        <div class="card-body">

            {{-- eror message --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>There were some problems with your input:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('admin.book.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Title --}}
                    <div class="col-md-6">
                        <label class="form-label">Book Name</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}">
                    </div>

                    {{-- Category --}}
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $book->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- Author --}}
                    <div class="col-md-6">
                        <label class="form-label">Author</label>
                        <input type="text" name="author" class="form-control"
                            value="{{ old('author', $book->author) }}">
                    </div>

                    {{-- Price --}}
                    <div class="col-md-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $book->price) }}">
                    </div>

                    {{-- Stock --}}
                    <div class="col-md-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', $book->stock) }}">
                    </div>

                    {{-- Description --}}
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $book->description) }}</textarea>
                    </div>

                    {{-- Image --}}
                    <div class="col-12">
                        <label class="form-label">Book Cover</label>
                        <input type="file" name="image" class="form-control">

                        @if ($book->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $book->image) }}" width="120">
                            </div>
                        @endif
                    </div>

                    {{-- Buttons --}}
                    <div class="col-12">
                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('admin.book.index') }}" class="btn btn-secondary btn-sm">
                                Back
                            </a>

                            <button type="submit" class="btn btn-success btn-sm">
                                Update Book
                            </button>
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>
@endsection
