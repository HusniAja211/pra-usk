@extends('app')
@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h4 class="text-muted">Create Member</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('member.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <label for="" class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="">--Pilih Role--</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 d-flex align-items-end">
                        <a href="javascript:history.back()" class="btn btn-info btn-sm">Back</a>
                        <button type="submit" class="btn btn-success btn-sm ms-2">Create</button>
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" required>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
