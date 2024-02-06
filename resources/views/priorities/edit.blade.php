@extends('dashboard.index')
@section('category')
    <div class="container">
        <div class="row col-6 offset-3 mb-3">
            <h4>Priority Update Page</h4>
        </div>
        <div class="col-6 offset-1">
            @if (session('succcess'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('priorities.update', $priority) }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="Name" class="form-label">Name</label>
                    <input type="type"
                        class="form-control @error('name')
                    is-invalid
                @enderror"
                        name="name" value="{{ old('name', $priority->name) }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-outline-warning">Update</button>
            </form>
        </div>

    </div>
@stop
