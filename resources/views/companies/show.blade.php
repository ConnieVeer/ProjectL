@extends('layouts.app')
@section('content')
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-3">{!! $company->name !!}</h1>
            <p>{!! $company->description !!}</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @foreach ($company->projects as $project)
                <div class="col-sm-4 mt-1">
                    <div class="card h-100">
                        <div class="card-header bg-info">
                            <h4 class="card-title">{{ $project->name }}</h4>
                        </div>
                        <div class="card-body">

                            <p class="card-text">{{ substr_replace($project->description, '...', 50) }}</p>
                            <a class="btn btn-primary card-link stretched-link"
                                href="{{ URL('/project/' . $project->id) }}">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    @endsection
    @section('subnav')
    <ul class="mt-3 list-group">
      @if($company->user_id ==  Auth::user()->id) 
      <li class="list-group-item">
       <a class="btn btn-small btn-danger" href="#"
       onclick="
       var result= confirm('weet je het zeker verwijderen van company');
       if( result ) {
         event.preventDefault();
         document.getElementById('deletecomp-form').submit();
       }
       "><i class="fa fa-trash mr-1" aria-hidden="true"></i> 
       Verwijder Company
     </a>

     <form id="deletecomp-form" action="{{ route('company.destroy', [$company->id]) }}" method="POST" style="display: none;">
      @csrf
      <input type="hidden" name="_method" value="delete">
    </form>
    </li>
  @endif
  <li class="list-group-item"><a class="btn btn-small btn-success" href="{{ URL('/company/create') }}"> Nieuw Company</a></li>
    
  <li class="list-group-item"><a class="btn btn-warning btn-sm" href="{{ URL('/company/'.$company->id.'/edit') }}">Wijzigen Company</a></li>
      
  <li class="list-group-item"><a class="btn btn-info btn-sm" href="{{ URL('/company') }}"></i> Alle companies</a></li>
  
  <li class="list-group-item">   <a href="/project/create/{{$company->id }}" class="btn btn-small btn-success"> Nieuw project</a> </li>
 </ul>
      @endsection

