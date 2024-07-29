@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="card card-body bg-light text-info">
                    <h1 class="text-center">Companies </h1>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        @foreach ($companies as $company)
                            <li class="list-group-item">
                                <a href="{{ URL('/company/' . $company->id) }}"> {{ $company->name }}</a>
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

            <li class="list-group-item"><a class="btn btn-success btn-sm " href="{{ URL('/company/create') }}">Nieuw
                    Company</a></li>

        </ul>
    </div>
@endsection
