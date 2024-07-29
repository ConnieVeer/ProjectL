@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <div class="container">
                Nieuwe task invoeren
            </div>
        </div>
    </div>
    <div class="container">
        <!-- Example row of columns -->
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="{{ route('task.store') }}">
                    {{ csrf_field() }}
                    <input type = "hidden" name= "project_id" value="{{ $project_id }} " />
                    <label for="task-name">Name:</label>
                    <input placeholder="Enter name" id="task-name" required name="name" spellcheck="false"
                        class="form-control" /><br>
                    <textarea placeholder="Enter description" required id="task-content" name="description" spellcheck="false"
                        rows="5" cols="10" class="form-control"></textarea><br>
                    <input type="number" placeholder="Enter hours" id="hours" name="hours"
                        class="form-control" /><br>
                    <input type="submit" value="submit" />
            </div>
        </div>
        </form>
    </div>
@endsection
