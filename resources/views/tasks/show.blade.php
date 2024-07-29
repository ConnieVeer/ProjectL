@extends('layouts.app')
@section('content')
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-3">{!! $task->name !!}</h1>
            <p>{!! $task->description !!}</p>
            <p>{!! $task->hours !!}</p>
           <ul>
    @foreach($task->users as $user)
    <li>{{ $user->name }}</li>
    @endforeach
</ul>
            {{-- <p>  {!! $task->user->name !!} </p> --}}
        </div>
    </div>
    <div class="row">
        <div class="card col-md-8 p-0">
            <div class="card-header bg-info">New comment</div>
            <div class="card-body">
                @include('partials.comment-form', [
                    'commentable_type' => 'App\Models\Task',
                    'commentable_id' => $task->id,
                ])
            </div>
        </div>
        @if ($task->comments->count() > 0)
            @include('partials.comments', [
                'comments' => $task->comments,
                'taskId' => $task->id,
                'projectId'=> $task->project->id
            ])
        @endif
    </div>
                         
                           
    {{-- <div class="container">
        <div class="row">
            @foreach ($project->tasks as $task)
                <div class="col-sm-4 mt-1">
                    <div class="card h-100">
                        <div class="card-header bg-info">
                            <h4 class="card-title">{{ $task->name }}</h4>
                        </div>
                        <div class="card-body">

                            <p class="card-text">{{ substr_replace($task->description, '...', 50) }}</p>
                            <a class="btn btn-primary card-link stretched-link"
                                href="{{ URL('/task/' . $task->id) }}">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div> --}}
@endsection
@section('subnav')
    <ul class="mt-3 list-group">
        {{-- <li class="list-group-item"><a class="btn btn-small btn-success" href="{{ URL('/task/create') }}"> Nieuw task</a>
        </li> --}}

        <li class="list-group-item"><a class="btn btn-warning btn-sm" href="{{ URL('/task/' . $task->id . '/edit') }}">Wijzigen
                Taak</a></li>

        {{-- <li class="list-group-item"><a class="btn btn-info btn-sm" href="{{ URL('/task') }}"></i> Alle tasks</a></li> --}}

        {{-- <li class="list-group-item"> <a href="/task/create/{{ $ya = task->id }}" class="btn btn-small btn-success"> Nieuw
                task</a> </li> --}}
        @if ($task->user_id == Auth::user()->id)
            <li class="list-group-item">
                <a class="btn btn-small btn-danger" href="#"
                    onclick="
                 var result= confirm('weet je het zeker verwijderen van taak');
                 if( result ) {
                   event.preventDefault();
                   document.getElementById('deletetask-form').submit();
                 }
                 "><i
                        class="fa fa-trash mr-1" aria-hidden="true"></i>
                    Verwijder Taak
                </a>

                <form id="deletetask-form" action="{{ route('task.destroy', [$task->id]) }}" method="POST"
                    style="display: none;">
                    @csrf
                    <input type="hidden" name="_method" value="delete">
                </form>
            </li>
        @endif
    </ul>
    <div class="card mt-3">
        <div class="card-header bg-info">
            <h5>Task users</h5>
        </div>

        <div class="card-body">
            <ul style="margin: 0; padding: 0 0 0 1em;">
                <li>
                    <a href="{{ route('user.show', ['user' => $task->owner()]) }}">
                        {{ Str::upper($task->owner()->name) }}
                    </a>
                </li>
                @foreach ($task->users as $taskUser)
                    @continue($taskUser->id === $task->owner()->id)
                    <li>
                        <a href="{{ route('user.show', ['user' => $taskUser]) }}">
                            {{ $taskUser->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <small><em>Owner is in capitals</em></small>
    <h4 class="mt-4 bg-light">Add User</h4>
    @if (Auth::id() === $task->user_id)
        <form id="add-user" action="{{ route('task.adduser') }}" method="POST">
            @csrf
            <div class="input-group">
                <input type="hidden" value="{{ $task->id }}" name="task_id">

                <select name="user_id" class="form-control">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>

                <span class="input-group-btn">
                    <button type="submit" class="btn btn-warning">Add!</button>
                </span>
            </div>
        </form>
    @else
        Users can only be added by the owner of this task: {{ $task->owner()->name }}.
    @endif

@endsection
