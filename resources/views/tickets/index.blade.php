@extends('dashboard.index')
@section('category')


    <div class="container">
        @if (session('login'))
            <div class="alert alert-danger">
                {{ session('login') }}
            </div>
        @endif
        <div class="col-md-12">
            <table class="table">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Image</th>
                        <th scope="col">Created By</th>
                        <th scope="col">Priority</th>
                        <th scope="col">Assigned User</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ $ticket->title }}</td>
                            <td>{{ $ticket->text_description }}</td>
                            <td> {{-- retrieve image as single path --}}
                                @if ($ticket->file_path_data)
                                    @php
                                        // remove path from image path data
                                        $filePaths = explode(',', $ticket->file_path_data);
                                    @endphp
                                    @foreach ($filePaths as $filePath)
                                        @php $fileName = basename($filePath) @endphp
                                        <img width="100px" height="70px" class="mx-2"
                                            src="{{ asset('storage/gallery/' . $fileName) }}" alt="Image">
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $ticket->createdBy->name }}</td>
                            <td
                                class="badge badge-dark
                            @if ($ticket->priority->name == 'Low') text-danger 
                           @elseif ($ticket->priority->name == 'Medium') 
                               text-warning 
                           @else
                               text-success @endif">
                                {{ $ticket->priority->name }}
                            </td>
                            
                            @if (!empty($ticket->users->name))
                                <td>{{$ticket->users->name }}</td>
                            @else
                                <td>No Agent For this Ticket</td>
                            @endif
                            <td class="d-flex">
                                <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-primary mx-2"><i
                                        class="fas fa-info"></i></a>
                                @if (Auth::User()->role == 0 || Auth::User()->role == 1)
                                    <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-outline-warning mx-2"><i
                                            class="fas fa-pen"></i></a>
                                    <form action="{{ route('tickets.destroy', $ticket) }}" method="post" class="mx-2">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger" type="submit"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @if (Auth::user()->role == 1)
                    @foreach ($createdTickets as $ticket)
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ $ticket->title }}</td>
                            <td>{{ $ticket->text_description }}</td>
                            <td> {{-- retrieve image as single path --}}
                                @if ($ticket->file_path_data)
                                    @php
                                        // remove path from image path data
                                        $filePaths = explode(',', $ticket->file_path_data);
                                    @endphp
                                    @foreach ($filePaths as $filePath)
                                        @php $fileName = basename($filePath) @endphp
                                        <img width="100px" height="70px" class="mx-2"
                                            src="{{ asset('storage/gallery/' . $fileName) }}" alt="Image">
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $ticket->createdBy->name }}</td>
                            <td
                                class="badge badge-dark
                            @if ($ticket->priority->name == 'Low') text-danger 
                           @elseif ($ticket->priority->name == 'Medium') 
                               text-warning 
                           @else
                               text-success @endif">
                                {{ $ticket->priority->name }}
                            </td>
                            
                            @if (!empty($ticket->users->name))
                                <td>{{$ticket->users->name }}</td>
                            @else
                                <td>No Agent For this Ticket</td>
                            @endif
                            <td class="d-flex">
                                <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-primary mx-2"><i
                                        class="fas fa-info"></i></a>
                                @if (Auth::User()->role == 0 || Auth::User()->role == 1)
                                    <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-outline-warning mx-2"><i
                                            class="fas fa-pen"></i></a>
                                    <form action="{{ route('tickets.destroy', $ticket) }}" method="post" class="mx-2">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger" type="submit"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop
