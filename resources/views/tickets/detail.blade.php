@extends('dashboard.index')
@section('category')
    <div class="container">
        <div class="col-md-12">
            @if (session('delete'))
                <div class="alert alert-danger">{{ session('delete') }}</div>
            @endif
            <div class="card">
                <div class="card-title d-flex justify-content-between p-3 bg-warning">
                    <span>{{ $ticket->title }}</span>
                    <div class="badge badge-dark p-2"><span class="text-danger">{{ $ticket->priority->name }}</span>
                    </div>
                </div>
                <div class="card-body bg-dark">
                    <div class="row">
                        <div class="col-md-8">
                            <p>{{ $ticket->text_description }}</p>
                            {{-- retrieve image as single --}}
                            @if ($ticket->file_path_data)
                                @php
                                    $filePaths = explode(',', $ticket->file_path_data);
                                @endphp
                                @foreach ($filePaths as $filePath)
                                    @php $fileName = basename($filePath) @endphp
                                    <img width="100px" height="70px" class="mx-2"
                                        src="{{ asset('storage/gallery/' . $fileName) }}" alt="Image">
                                @endforeach
                            @endif
                        </div>
                        @if (count($labels) > 0 && count($categories) > 0)
                            <div class="col-md-4 rounded p-3">
                                <div class="label-group d-flex flex-column">
                                    <b>Labels <i class="fas fa-hand-point-down mx-2"></i></b>
                                    @foreach ($labels as $label)
                                        <div class="badge badge-info my-2">{{ $label->name }}</div>
                                    @endforeach
                                </div>
                                <div class="category-group d-flex flex-column">
                                    <b>categories <i class="fas fa-hand-point-down mx-2"></i></b>
                                    @foreach ($categories as $category)
                                        <div class="badge badge-info my-2">{{ $category->name }}</div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <ul class="list-group p-3 rounded">
                        <li class="list-group-item active">
                            <b>Total Comments ({{ count($ticket->comments) }})</b>
                        </li>

                        @foreach ($ticket->comments as $comment)
                            <li class="list-group-item rounded d-flex justify-content-between bg-dark my-2">
                                <div class="name-profile d-flex">
                                    <span class="badge badge-info mx-3 px-3 py-2">{{ $comment->user->name }}</span>
                                    <span class="d-inline">{{ $comment->content }}</span>
                                </div>
                                @if (Auth::user()->id == $comment->user->id)
                                    <span class="d-inline">
                                        <form action="{{ route('comments.destroy', $comment) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </span>
                                @elseif (Auth::user()->role == 0 || Auth::user()->role == 1)
                                    <span class="d-inline">
                                        <form action="{{ route('comments.destroy', $comment) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </span>
                                @endif

                            </li>
                        @endforeach
                    </ul>
                    @auth
                        <form action="{{ route('comments.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <textarea name="content"
                                class="form-control my-2 @error('content')
                            is-invalid
                        @enderror"
                                placeholder="New Comment"></textarea>
                            @error('content')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <input type="submit" value="Add Comment" class="btn btn-primary my-2">
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@stop
