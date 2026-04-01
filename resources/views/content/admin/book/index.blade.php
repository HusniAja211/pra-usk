@extends('app')
@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h3 class="text-muted">Books</h3>
        </div>
        <div class="card-body table-responsive">
            <a href="{{route('admin.book.create')}}" class="btn btn-primary btn-sm my-2">Create</a>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Modal</th>
                        <th>Price</th>
                        <th>Margin</th>
                        <th>Profit</th>
                        <th>Stock</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$book->title}}</td>
                            <td>{{$book->category->name ?? 'No Category'}}</td>
                            <td>{{$book->author}}</td>
                            <td>{{$book->publisher}}</td>
                            <td>Rp {{ number_format($book->modal, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($book->price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($book->margin, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($book->profit, 0, ',', '.') }}</td>
                            <td>{{$book->stock}}</td>
                            <td>{{$book->description}}</td>
                            <td>
                                <a href="{{route('admin.book.edit', $book->id)}}" class="btn btn-success btn-sm">Edit</a>
                                <form action="{{route('admin.book.destroy', $book->id)}}" onclick="return confirm('Yakin ingin didelete?')" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
