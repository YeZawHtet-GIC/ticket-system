@extends('dashboard.index')
@section('category')
    <div class="container">
        <div class="col-8 offset-1">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('users.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="Name" class="form-label">Name</label>
                    <input type="type"
                        class="form-control @error('name')
                    is-invalid
                @enderror"
                        name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="Email" class="form-label">Email</label>
                    <input type="email"
                        class="form-control @error('email')
                    is-invalid
                @enderror"
                        name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="Password" class="form-label">Password</label>
                    <input type="password"
                        class="form-control @error('password')
                    is-invalid
                @enderror"
                        name="password" value="{{ old('password') }}">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between col-6">
                    <span>Choose Role <i class="fas fa-hand-point-right mx-3" aria-hidden="true"></i>
                    </span>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="role" value="1" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Agent
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="role" value="2" id="flexRadioDefault2"
                            checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Regular User
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary">Create</button>
            </form>
        </div>
    </div>
@stop
