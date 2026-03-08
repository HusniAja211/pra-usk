@extends('app')
@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h3 class="text-muted">Members</h3>
        </div>
        <div class="card-body table-responsive">
            <a href="{{route('member.create')}}" class="btn btn-primary btn-sm my-2">Create</a>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $v)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$v->name}}</td>
                            <td>{{$v->role}}</td>
                            <td>{{$v->email}}</td>
                            <td>
                                <a href="{{route('member.edit', $v->id)}}" class="btn btn-success btn-sm">Edit</a>
                                <form action="{{route('member.destroy', $v->id)}}" onclick="return confirm('Yakin ingin didelete?')" method="post" class="d-inline">
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
