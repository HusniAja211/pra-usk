@extends('app')
@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h4 class="text-muted">Edit Category</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.category.update', $category->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-6">
                        <label for="" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{$category->name}}">
                    </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-6 d-flex align-items-end">
                        <a href="javascript:history.back()" class="btn btn-info btn-sm">Back</a>
                        <button type="submit" class="btn btn-success btn-sm ms-2">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
