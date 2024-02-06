@extends('dashboard.index')
@section('category')


    <div class="container">
        @if (session('login'))
            <div class="alert alert-danger">
                {{ session('login') }}
            </div>
        @endif
        <div class="col-8 offset-1">
            @foreach ($tickets as $ticket)
                <div class="card">
                    <div class="card-title text-center">
                        <span>{{ $ticket->title }}</span>
                    </div>
                    <div class="card-body">
                        <p>{{ $ticket->text_description }}</p>
                        <div class="badge badge-warning">{{ $ticket->priority_id }}</div>
                        {{-- retrieve image as single --}}
                        @if ($ticket->file_path_data)
                            @php
                                $filePaths = explode(',', $ticket->file_path_data);
                            @endphp
                            @foreach ($filePaths as $filePath)
                            {{ $fileName = basename($filePath) }}
                                <img src="{{ asset('storage/gallery/' . $fileName) }}" alt="Image">
                            @endforeach
                        @endif

                    </div>
                    <div class="card-footer">
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-primary">Detail</a>
                        <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-outline-primary">Edit</a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@stop
