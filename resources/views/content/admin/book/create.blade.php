@extends('app')

@section('content')
<div class="card">

    <div class="card-header text-center">
        <h4 class="text-muted">Create Book</h4>
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

        <form action="{{ route('admin.book.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">

                {{-- Title --}}
                <div class="col-md-6">
                    <label class="form-label">Book Name</label>

                    <input type="text"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}"
                        placeholder="Enter book name">

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Category --}}
                <div class="col-md-6">
                    <label class="form-label">Category</label>

                    <select name="category_id"
                        class="form-select @error('category_id') is-invalid @enderror">

                        <option value="">Select Category</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>

                    @error('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Author --}}
                <div class="col-md-6">
                    <label class="form-label">Author</label>

                    <input type="text"
                        name="author"
                        class="form-control @error('author') is-invalid @enderror"
                        value="{{ old('author') }}"
                        placeholder="Enter author name">

                    @error('author')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Price --}}
                <div class="col-md-3">
                    <label class="form-label">Price</label>

                    <input type="number"
                        name="price"
                        class="form-control @error('price') is-invalid @enderror"
                        value="{{ old('price') }}"
                        placeholder="Enter price">

                    @error('price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Stock --}}
                <div class="col-md-3">
                    <label class="form-label">Stock</label>

                    <input type="number"
                        name="stock"
                        class="form-control @error('stock') is-invalid @enderror"
                        value="{{ old('stock') }}"
                        placeholder="Enter stock">

                    @error('stock')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="col-12">
                    <label class="form-label">Description</label>

                    <textarea name="description"
                        class="form-control @error('description') is-invalid @enderror"
                        rows="4"
                        placeholder="Enter book description">{{ old('description') }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Image --}}
                <div class="col-12">
                    <label class="form-label">Book Cover</label>

                    <input type="file"
                        name="image"
                        class="form-control @error('image') is-invalid @enderror">

                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="col-12">
                    <div class="d-flex gap-2 mt-3">

                        <a href="{{ route('admin.book.index') }}"
                            class="btn btn-secondary btn-sm">
                            Back
                        </a>

                        <button type="submit"
                            class="btn btn-success btn-sm">
                            Create Book
                        </button>

                    </div>
                </div>

            </div>

        </form>
    </div>
</div>
@endsection