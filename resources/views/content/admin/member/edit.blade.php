@extends('app')
@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h4 class="text-muted">Edit Member</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('member.update', $member->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-6">
                        <label for="" class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="">--Pilih Role--</option>
                            <option value="admin"{{ $member->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user"{{ $member->role == 'user' ? 'selected' : ''}}>User</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{$member->name}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{$member->email}}" >
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 d-flex align-items-end">
                        <a href="javascript:history.back()" class="btn btn-info btn-sm">Back</a>
                        <button type="submit" class="btn btn-success btn-sm ms-2">Edit</button>
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
