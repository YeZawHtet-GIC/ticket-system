@extends('dashboard.index')
@section('category')
    <div class="container">
        <div class="col-8 offset-1">
            {{-- Alert for Update Success --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            {{-- Edit Form Start --}}
            <form action="{{ route('tickets.update', $ticket) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="Title" class="form-label">Title</label>
                    <input type="type"
                        class="form-control @error('title')
                    is-invalid
                @enderror"
                        name="title" value="{{ old('title', $ticket->title) }}">
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
                        name="description" value="{{ old('description', $ticket->text_description) }}">
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="Image" class="form-label">Image</label>
                    <input type="file"
                        class="form-control @error('image')
                    is-invalid
                @enderror"
                        name="images[]" multiple>
                    @error('image')
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
                            <option value="{{ $priority->id }}"
                                {{ $ticket->priority_id == $priority->id ? 'selected' : '' }}>
                                {{ $priority->name }}</option>
                        @endforeach
                    </select>
                    @error('priority')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Assign Agent Options and Status ONLY for Admin Start --}}
                @if (Auth::User()->role == 0)
                    <div class="mb-3">
                        <label for="User" class="form-label">Select User to Assign</label>
                        <select name="user_id"
                            class="form-control @error('user_id')
                        is-invalid
                        @enderror">
                            <option value="">Choose User to Assign</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $ticket->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex col-8 ">
                        <b>Status <i class="fas fa-hand-point-right mx-3" aria-hidden="true"></i> </b>
                        <div class="form-check mx-3">
                            <input class="form-check-input" type="radio" name="status" value="1"
                                id="flexRadioDefault3" {{ $ticket->status == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexRadioDefault3">
                                Open
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="2"
                                id="flexRadioDefault1" {{ $ticket->status == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Close
                            </label>
                        </div>
                    </div>
                @endif
                {{-- Assign Agent Options and Status ONLY for Admin End --}}
                <div class="d-flex mb-3">
                    <b>Choose Category <i class="fas fa-hand-point-right mx-3" aria-hidden="true"></i></b>
                    @foreach ($categories as $category)
                        <div class="form-check mx-2">
                            <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}"
                                {{ in_array($category->id, $checkedCategories) ? 'checked' : '' }}
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
                                {{ in_array($label->id, $checkedLabels) ? 'checked' : '' }} id="{{ $label->name }}">
                            <label class="form-check-label" for="{{ $label->name }}">
                                {{ $label->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-outline-warning">Update</button>
            </form>
            {{-- Edit Form End --}}
        </div>
    </div>
@stop
