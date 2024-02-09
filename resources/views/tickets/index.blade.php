@extends('dashboard.index')
@section('category')
    <div class="container-fluid">
        <div class="col-md-12">
            {{-- Pagination links --}}
            {{ $tickets->links() }}
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Image</th>
                        <th scope="col">Created By</th>
                        <th scope="col">Priority</th>
                        <th scope="col">Status</th>
                        <th scope="col">Assigned User</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                {{-- Data from Ticket Table start --}}
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr class="text-center">
                            <th scope="row">{{ $loop->iteration }}</th>
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
                                        <img width="100px" height="70px" class="m-2"
                                            src="{{ asset('storage/gallery/' . $fileName) }}"
                                            class="img-fluid img-thumbnail" alt="Image">
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
                            <td
                                class="
                        @if ($ticket->status == 2) text-danger 
                       @else
                           text-success @endif">
                                <b>
                                    @if ($ticket->status == 2)
                                        Close
                                    @else
                                        Open
                                    @endif
                                </b>
                            </td>
                            @if (!empty($ticket->users->name))
                                <td><b class="text-success">{{ $ticket->users->name }}</b></td>
                            @else
                                <td><b class="text-danger">Unassign Ticket</b></td>
                            @endif
                            <td class="d-flex">
                                <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-primary mx-2"><i
                                        class="fas fa-info"></i></a>
                                {{-- EDIT & DELETE ONLY for Admin & Agent  start --}}
                                @if (Auth::User()->role == 0 || Auth::User()->role == 1)
                                    <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-outline-warning mx-2"><i
                                            class="fas fa-pen"></i></a>
                                    <form action="{{ route('tickets.destroy', $ticket) }}" method="post" class="mx-2">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete?')" type="submit"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                                {{-- EDIT & DELETE ONLY for Admin & Agent end --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                {{-- Data from Ticket Table end --}}
            </table>
        </div>
    </div>
@stop
