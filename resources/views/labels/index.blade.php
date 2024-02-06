@extends('dashboard.index')
@section('category')
    <div class="container">
        <div class="col-6 offset-1">
            @if (session('delete'))
                <div class="alert alert-danger">{{ session('delete') }}</div>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($labels as $label)
                        <tr>
                            <th scope="row">{{ $label->id }}</th>
                            <td>{{ $label->name }}</td>
                            <td class="d-flex">
                                <a class="btn btn-outline-warning mr-2" href="{{ route('labels.edit', $label) }}"><i
                                        class="fas fa-pen"></i></a>

                                <form action="{{ route('labels.destroy', $label) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-outline-danger" type="submit"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@stop
