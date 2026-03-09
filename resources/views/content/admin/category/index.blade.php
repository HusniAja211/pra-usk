@extends('app')
@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h3 class="text-muted">Categories</h3>
        </div>
        <div class="card-body table-responsive">
            <a href="{{route('admin.category.create')}}" class="btn btn-primary btn-sm my-2">Create</a>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$category->name}}</td>
                            <td>
                                <a href="{{route('admin.category.edit', $category->id)}}" class="btn btn-success btn-sm">Edit</a>
                                <form action="{{route('admin.category.destroy', $category->id)}}" onclick="return confirm('Yakin ingin didelete?')" method="post" class="d-inline">
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
