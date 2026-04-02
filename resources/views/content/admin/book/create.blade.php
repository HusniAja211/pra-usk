@extends('app')

@section('content')
<div class="card">

    <div class="card-header text-center">
        <h4 class="text-muted">Create Book</h4>
    </div>

    <div class="card-body">

        {{-- error message --}}
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
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}" placeholder="Enter book name">
                </div>

                {{-- Category --}}
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Author --}}
                <div class="col-md-6">
                    <label class="form-label">Author</label>
                    <input type="text" name="author" class="form-control"
                        value="{{ old('author') }}" placeholder="Enter author name">
                </div>

                {{-- Publisher --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Publisher</label>
                    <input type="text" name="publisher" class="form-control"
                        value="{{ old('publisher') }}" placeholder="Nama penerbit">
                </div>

                <hr class="my-4 text-muted">

                {{-- Modal --}}
                <div class="col-md-4">
                    <label class="form-label fw-bold">Modal (Harga Beli)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="modal" class="form-control"
                            value="{{ old('modal') }}" step="0.01">
                    </div>
                </div>

                {{-- Price --}}
                <div class="col-md-4">
                    <label class="form-label fw-bold">Price (Harga Jual)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="price" class="form-control"
                            value="{{ old('price') }}" step="0.01">
                    </div>
                </div>

                {{-- Stock --}}
                <div class="col-md-4">
                    <label class="form-label fw-bold">Stock</label>
                    <input type="number" name="stock" class="form-control"
                        value="{{ old('stock') }}">
                </div>

                {{-- Margin --}}
                <div class="col-md-6">
                    <label class="form-label text-muted">Margin per Unit (Otomatis)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted">Rp</span>
                        <input type="text" class="form-control bg-light"
                            value="0" readonly>
                    </div>
                </div>

                {{-- Profit --}}
                <div class="col-md-6">
                    <label class="form-label text-muted">Total Potensi Keuntungan (Otomatis)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted">Rp</span>
                        <input type="text" class="form-control bg-light"
                            value="0" readonly>
                    </div>
                </div>

                {{-- Description --}}
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4"
                        placeholder="Enter book description">{{ old('description') }}</textarea>
                </div>

                {{-- Image --}}
                <div class="col-12">
                    <label class="form-label">Book Cover</label>
                    <input type="file" name="image" class="form-control">
                </div>

                {{-- Buttons --}}
                <div class="col-12">
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('admin.book.index') }}" class="btn btn-secondary btn-sm">
                            Back
                        </a>
                        <button type="submit" class="btn btn-success btn-sm">
                            Create Book
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection