@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <div class="container">
                Nieuwe Project invoeren
            </div>
        </div>
    </div>
    <div class="container">
        <!-- Example row of columns -->
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="{{ route('project.store') }}">
                    {{ csrf_field() }}
                    {{-- <input type = "hidden" name= "company_id" value="{{ $company_id }} "/> --}}
                    <label for="project-name">Name:</label>
                    <input placeholder="Enter name" id="project-name" required name="name" spellcheck="false"
                        class="form-control" /><br>
                    <textarea placeholder="Enter description" required id="project-content" name="description" spellcheck="false"
                        rows="5" cols="10" class="form-control"></textarea><br>

                    @if ($companies == null)
                        <input class ="" type="hidden" name= "campony_id" value ="{{ company_id }}" />
                    @endif

                    @if ($companies !== null)
                        <div class="form-group">
                            <label for="company-conent">Select Company </label>
                            <select name ="company_id" class ="form-control">
                                @foreach ($companies as $company)
                                    <option value ="{{ $company->id }}">{{ $company->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    @endif


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
