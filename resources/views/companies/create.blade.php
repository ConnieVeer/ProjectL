@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <div class="container">
                Nieuwe company invoeren
            </div>
        </div>
    </div>
    <div class="container">
        <!-- Example row of columns -->
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="{{ route('company.store') }}">
                    {{ csrf_field() }}
                    <label for="company-name">Name:</label>
                    <input placeholder="Enter name" id="company-name" required name="name" spellcheck="false"
                        class="form-control" /><br>
                    <textarea placeholder="Enter description" required id="company-content" name="description" spellcheck="false" rows="5"
                        cols="10" class="form-control"></textarea><br>
                    <input type="submit" value="submit" />
            </div>
        </div>
        </form>
    </div>
@endsection
@section('subnav')
    <ul class="mt-3 list-group">

        <li class="list-group-item"><a class="btn btn-info btn-sm" href="{{ URL('/company') }}"></i> Alle companies</a></li>

    </ul>
@endsection
