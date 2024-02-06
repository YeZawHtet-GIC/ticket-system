@extends('dashboard.index')
@section('category')
    <div class="container">
        <div class="row col-6 offset-3 mb-3">
            <h4>Priorty List Page</h4>
        </div>
        <div class="col-6 offset-1">
              @if (session('delete'))
            <div class="alert alert-danger">{{ session('delete') }}</div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($priorities as $priority)
                    <tr>
                        <th scope="row">{{ $priority->id }}</th>
                        <td>{{ $priority->name }}</td>
                        <td class="d-flex">
                            <a class="btn btn-outline-warning  mr-2" href="{{ route('priorities.edit', $priority) }}"><i
                                    class="fas fa-pen"></i></a>

                            <form action="{{ route('priorities.destroy', $priority) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-outline-danger" type="submit"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>

    </div>
@stop
