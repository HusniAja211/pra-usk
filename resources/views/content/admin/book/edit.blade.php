@extends('app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0 text-center text-muted">Edit Book: {{ $book->title }}</h4>
        </div>

        <div class="card-body">

            {{-- Error Message --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terdapat kesalahan input:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <form action="{{ route('admin.book.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Title --}}
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Book Name</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}" placeholder="Masukkan judul buku">
                    </div>

                    {{-- Category --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Author --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Author</label>
                        <input type="text" name="author" class="form-control" value="{{ old('author', $book->author) }}" placeholder="Nama penulis">
                    </div>

                    {{-- Publisher --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Publisher</label>
                        <input type="text" name="publisher" class="form-control" value="{{ old('publisher', $book->publisher) }}" placeholder="Nama penerbit">
                    </div>

                    <hr class="my-4 text-muted">

                    {{-- Keuangan Row 1 --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Modal (Harga Beli)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="modal" class="form-control" value="{{ old('modal', $book->modal) }}" step="0.01">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Price (Harga Jual)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="price" class="form-control" value="{{ old('price', $book->price) }}" step="0.01">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Stock</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', $book->stock) }}">
                    </div>

                    {{-- Info Kalkulasi (Read Only) --}}
                    <div class="col-md-6">
                        <label class="form-label text-muted">Margin per Unit (Otomatis)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted">Rp</span>
                            <input type="text" class="form-control bg-light" value="{{ number_format($book->margin, 0, ',', '.') }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-muted">Total Potensi Keuntungan (Otomatis)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted">Rp</span>
                            <input type="text" class="form-control bg-light" value="{{ number_format($book->profit, 0, ',', '.') }}" readonly>
                        </div>
                    </div>

                    <hr class="my-4 text-muted">

                    {{-- Description --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Tulis sinopsis atau deskripsi buku...">{{ old('description', $book->description) }}</textarea>
                    </div>

                    {{-- Image --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">Book Cover</label>
                        <input type="file" name="image" class="form-control mb-2">
                        
                        @if ($book->image)
                            <div class="p-2 border rounded d-inline-block bg-light">
                                <p class="small text-muted mb-1">Cover Saat Ini:</p>
                                <img src="{{ asset('storage/' . $book->image) }}" alt="Cover" class="img-thumbnail" style="height: 150px;">
                            </div>
                        @else
                            <span class="badge bg-secondary">No Cover Uploaded</span>
                        @endif
                    </div>

                    {{-- Action Buttons --}}
                    <div class="col-12 border-top pt-4 mt-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.book.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Update Book Data
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection