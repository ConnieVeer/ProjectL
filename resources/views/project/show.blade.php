@extends('layouts.app')
{{-- @section('content')
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-3">{!! $project->name !!}</h1>
            <p>{!! $project->description !!}</p>
        </div>
    </div>
    <div class="container">
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
    </div>
    
    @endsection --}}
{{-- @section('subnav')
    <ul class="mt-3 list-group">
      @if ($project->user_id == Auth::user()->id) 
      <li class="list-group-item">
       <a class="btn btn-small btn-danger" href="#"
       onclick="
       var result= confirm('weet je het zeker verwijderen van project');
       if( result ) {
         event.preventDefault();
         document.getElementById('deletecomp-form').submit();
       }
       "><i class="fa fa-trash mr-1" aria-hidden="true"></i> 
       Verwijder project
     </a>

     <form id="deletecomp-form" action="{{ route('project.destroy', [$project->id]) }}" method="POST" style="display: none;">
      @csrf
      <input type="hidden" name="_method" value="delete">
    </form>
    </li>
  @endif
  <li class="list-group-item"><a class="btn btn-small btn-success" href="{{ URL('/project/create') }}"> Nieuw project</a></li>
    
  <li class="list-group-item"><a class="btn btn-warning btn-sm" href="{{ URL('/project/'.$project->id.'/edit') }}">Wijzigen project</a></li>
      
  <li class="list-group-item"><a class="btn btn-info btn-sm" href="{{ URL('/project') }}"></i> Alle projecten</a></li>
  
  <li class="list-group-item">   <a href="/task/create/{{ $project->id }}" class="btn btn-small btn-success"> Nieuwe taak</a> </li>
 </ul>
      @endsection --}}

@section('subnav')
    <ul class="mt-3 list-group">
        @if ($project->user_id == Auth::user()->id)
            <li class="list-group-item">
                <a class="btn btn-small btn-danger" href="#"
                    onclick="
                     var result=confirm('Weet je zeker dat je dit project wil verwijderen?');
                     if(result) {
                         event.preventDefault();
                         document.getElementById('deleteproj-form').submit();
                     }
                     ">Delete
                    project</a>
                <form id="deleteproj-form" action="{{ route('project.destroy', $project->id) }}" method="POST"
                    style="display: none">
                    @csrf
                    @method('DELETE')
                </form>
            </li>
        @endif
        <li class="list-group-item">
            <a class="btn btn-small btn-warning" href="{{ route('project.edit', $project->id) }}">
                Edit project
            </a>
        </li>
        <li class="list-group-item">
            <a class="btn btn-info btn-info" href="{{ route('project.index') }}">
                All projects
            </a>
        </li>
        <li class="list-group-item">
        <li class="list-group-item"> <a href="/task/create/{{ $project->id }}" class="btn btn-small btn-success"> Create
                Task</a> </li>

        </a>
        </li>
    </ul>


    <div class="card  mt-3">
        <div class="card-header bg-info">
            <h4 class="card-title">Tasktime</h4>
        </div>

        <div class="card-body">
            <p class="card-text">{{ $project->tasks()
                ->whereNotNull('hours')
                ->sum('hours') }} hours</p>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header bg-info">
            <h5>Project users</h5>
        </div>

        <div class="card-body">
            <ul style="margin: 0; padding: 0 0 0 1em;">
                <li>
                    <a href="{{ route('user.show', ['user' => $project->owner()]) }}">
                        {{ Str::upper($project->owner()->name) }}
                    </a>
                </li>
                @foreach ($project->users as $projectUser)
                    @continue($projectUser->id === $project->owner()->id)
                    <li>
                        <a href="{{ route('user.show', ['user' => $projectUser]) }}">
                            {{ $projectUser->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <small><em>Owner is in capitals</em></small>

    <h4 class="mt-4 bg-light">Add member</h4>
    @if (Auth::id() === $project->user_id)
        <form id="add-user" action="{{ route('project.adduser') }}" method="POST">
            @csrf
            <div class="input-group">
                <input type="hidden" value="{{ $project->id }}" name="project_id">

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
        Members can only be added by the owner of this project: {{ $project->owner()->name }}.
    @endif

@endsection

@section('content')
    <div class="card card-body bg-light text-info">
        <h3 class="text-center">Project</h3>
        <h4 class="text-lg-start">
            Company: <strong><a
                    href="{{ route('company.show', ['company' => $project->company]) }}">{{ $project->company->name }}</a></strong><br />
        </h4>
    </div>

    <div class="jumbotron mt-4">
        <h1>{{ $project->name }}</h1>
        <p>{{ $project->description }}</p>
    </div>

    <div class="card card-body bg-light text-info mt-5">
        <h3 class="text-center">Tasks</h3>

        @if ($project->tasks->count() > 0)
        
            <table class="table table-striped  table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="col-md-6">Task</th>
                        <th scope="col" class="col-md-4">Creator</th>
                        <th scope="col" class="col-md-1">Hours</th>
                        <th scope="col" class="col-md-1">Days</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($project->tasks as $task)
                        <tr>
                            <td>
                                <a class="nav-link" href="{{ route('task.show', $task->id) }}">
                                    {{ Str::words($task->name, 10, '...') }}
                                </a>
                            </td>
                          
                            <td>{{ $task->users[0]->name }}</td>
                          
                            <td>
                                {{ $task->hours}}
                            </td>
                            <td>
                                {{ $task->days }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No tasks found for this project</p>
        @endif
    </div>

    <hr />

    <div class="row">
        <div class="card col-md-8 p-0">
            <div class="card-header bg-info">New comment</div>
            <div class="card-body">
                @include('partials.comment-form', [
                    'commentable_type' => 'App\Models\Project',
                    'commentable_id' => $project->id,
                ])
            </div>
        </div>
        @if ($project->comments->count() > 0)
            @include('partials.comments', [
                'comments' => $project->comments,
                'projectId' => $project->id,
                'companyId' => $project->company->id,
            ])
        @endif
    </div>


@endsection
