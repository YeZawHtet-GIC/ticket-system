@extends('dashboard.index')
@section('category')
    <div class="container">
        <div class="col-8 offset-1">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('tickets.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="Title" class="form-label">Title</label>
                    <input type="type"
                        class="form-control @error('title')
                    is-invalid
                @enderror"
                        name="title" value="{{ old('title') }}">
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="Description" class="form-label">Description</label>
                    <input type="text"
                        class="form-control @error('description')
                    is-invalid
                @enderror"
                        name="description" value="{{ old('description') }}">
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="Image" class="form-label">Image</label>
                    <input type="file"
                        class="form-control @error('image[]')
                    is-invalid
                @enderror"
                        name="images[]" multiple>
                    @error('image[]')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="Priority" class="form-label">Priority</label>
                    <select name="priority"
                        class="form-control @error('priority')
                    is-invalid
                @enderror">
                        <option value="">Choose Priority</option>
                        @foreach ($priorities as $priority)
                            <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                        @endforeach

                    </select>
                    @error('priority')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="d-flex mb-3">
                    <b>Choose Category <i class="fas fa-hand-point-right mx-3" aria-hidden="true"></i></b>
                    @foreach ($categories as $category)
                        <div class="form-check mx-2">
                            <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}"
                                id="{{ $category->name }}">
                            <label class="form-check-label" for="{{ $category->name }}">
                                {{ $category->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex mb-3">
                    <b>Choose Label <i class="fas fa-hand-point-right mx-3" aria-hidden="true"></i></b>
                    @foreach ($labels as $label)
                        <div class="form-check mx-3">
                            <input class="form-check-input" type="checkbox" name="labels[]" value="{{ $label->id }}"
                                id="{{ $label->name }}">
                            <label class="form-check-label" for="{{ $label->name }}">
                                {{ $label->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-outline-primary">Sumit</button>
            </form>
        </div>

    </div>
@stop
