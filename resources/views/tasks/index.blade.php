@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="card card-body bg-light text-info">
                    <h1 class="text-center">Tasks </h1>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        @foreach ($tasks as $task)
                            <li class="list-group-item">
                                <a href="{{ URL('/task/' . $task->id) }}"> {{ $task->id }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('subnav')
    <div class="container mt-4">
        <ul class="mt-3 list-group">

            <li class="list-group-item"><a class="btn btn-success btn-sm " href="{{ URL('/task/create') }}">Nieuw
                    Task</a></li>

        </ul>
    </div>
@endsection
