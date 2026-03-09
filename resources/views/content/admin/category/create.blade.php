@extends('app')
@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h4 class="text-muted">Create Category</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.category.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <label for="" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 d-flex align-items-end">
                        <a href="javascript:history.back()" class="btn btn-info btn-sm">Back</a>
                        <button type="submit" class="btn btn-success btn-sm ms-2">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
