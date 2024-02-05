@extends('dashboard.index')
@section('category')
    <div class="container">
        @if (session('delete'))
            <div class="alert alert-danger">{{ session('delete') }}</div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->role == 0)
                                Admin
                            @elseif ('$user->role==1')
                                Agent
                            @else
                                Regular
                            @endif
                        </td>
                        <td class="d-flex justify-content-around">
                            <a class="btn btn-outline-warning" href="{{ route('user.edit', $user) }}"><i
                                    class="fas fa-pen"></i></a>

                            <form action="{{ route('user.destroy', $user) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-outline-danger" type="submit"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
