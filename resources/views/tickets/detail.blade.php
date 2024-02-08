@extends('dashboard.index')

@section('category')
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header row row-cols-2 row-cols-md-2 row-cols-lg-4" style="background-color: #687EFF">
                    <div class="col"><b class="badge badge-dark badge-pill p-2 m-2" style="color: #687EFF; ">Title :
                            {{ $ticket->title }}</b></div>
                    <div class="col">
                        <div class="badge badge-dark badge-pill p-2 m-2" style="color: #687EFF; ">Created By :
                            {{ $ticket->createdBy->name }}
                        </div>
                    </div>
                    <div class="col">
                        <div class="badge badge-dark badge-pill p-2 m-2" style="color: #687EFF; ">Created :
                            {{ $ticket->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="col">
                        <div class="badge badge-dark badge-pill p-2 m-2">
                            <span style="color:#687EFF">Priority :
                                <span
                                    class="@if ($ticket->priority->name == 'Low') text-danger 
                            @elseif ($ticket->priority->name == 'Medium') 
                                text-warning 
                            @else
                                text-success @endif">{{ $ticket->priority->name }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body shadow">
                    <div class="row">
                        <div class="col-md-6">
                            <p>{{ $ticket->text_description }}</p>
                        </div>
                        <div class="col-md-6" style="border-left: 1px solid">
                            <div class="row m-3">
                                {{-- retrieve image as single --}}
                                @if ($ticket->file_path_data)
                                    @php
                                        $filePaths = explode(',', $ticket->file_path_data);
                                    @endphp
                                    @foreach ($filePaths as $filePath)
                                        @php $fileName = basename($filePath) @endphp
                                        <div class="col-md-6">
                                            <img width="200px" height="200px" class="img-fluid img-thumbnail"
                                                src="{{ asset('storage/gallery/' . $fileName) }}" alt="Image">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    @if (count($labels) > 0 && count($categories) > 0)
                        <div class="row rounded">
                            <div class="label-group col-md-6">
                                <b>Labels <i class="fas fa-hand-point-right mx-2"></i></b>
                                @foreach ($labels as $label)
                                    <span class="badge badge-info my-2">{{ $label->name }}</span>
                                @endforeach
                            </div>
                            <div class="category-group col-md-6" style="border-left:1px solid">
                                <b>Categories <i class="fas fa-hand-point-right mx-2"></i></b>
                                @foreach ($categories as $category)
                                    <span class="badge badge-info my-2">{{ $category->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer shadow bg-light">
                    <b>All Comments ({{ count($ticket->comments) }})</b>
                    <ul class="list-group rounded">
                        @foreach ($ticket->comments as $comment)
                            <li class="list-group-item rounded d-flex justify-content-between bg-dark my-2">
                                <div class="name-profile d-flex">
                                    <span class="badge badge-info text-dark mx-2 p-2">
                                        @if (Auth::user()->name == $comment->user->name)
                                            You
                                        @else
                                            {{ $comment->user->name }}
                                        @endif
                                    </span>
                                    <span class="d-inline">{{ $comment->content }}</span>
                                </div>
                                @if (Auth::user()->id == $comment->user->id || Auth::user()->role == 0 || Auth::user()->role == 1)
                                    <div class="btn-group">
                                        <a href="{{ route('comments.edit', $comment) }}"
                                            class="btn btn-sm btn-outline-warning mx-3"><i class="fas fa-pen"></i></a>
                                        <form action="{{ route('comments.destroy', $comment) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    @auth
                        @if (session('update'))
                            <b class="text-success">{{ session('update') }}</b>
                        @elseif (session('delete'))
                            <b class="text-danger">{{ session('delete') }}</b>
                        @else
                            <b class="text-success">{{ session('success') }}</b>
                        @endif
                        @if (session('comment'))
                            <form action="{{ route('comments.update', $comment) }}" method="post">
                                @csrf
                                @method('put')
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <textarea name="content" class="form-control my-2 @error('content') is-invalid @enderror" placeholder="New Comment">{{ session('comment.content') }}</textarea>
                                @error('content')
                                    <div class="text-danger">{{ $message }}</div>
                                    {{ session('comment') }}
                                @enderror
                                <input type="submit" value="Update Comment" class="btn btn-outline-warning my-2">
                            </form>
                        @else
                            <form action="{{ route('comments.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <textarea name="content" class="form-control my-2 @error('content') is-invalid @enderror" placeholder="New Comment"></textarea>
                                @error('content')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <input type="submit" value="Add Comment" class="btn btn-outline-primary my-2">
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
    </div>
@stop
