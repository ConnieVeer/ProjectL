@extends('layouts.app')


@section('content')

    <div class="container mt-4">

        <div class="panel panel-warning panel-table">

            <div class="panel-heading mb-3">

                <div class="row mt-3">

                    <div class="col col-xs-6">

                        <h3 class="panel-title">Projects for {{ Auth::user()->name }}</h3>

                    </div>


                    <div class="col col-xs-6 text-right">

                        <a class="btn btn-small btn-success float-end" href="{{ route('project.create') }}">

                            New project

                        </a>

                    </div>

                </div>

            </div>


            <div class="panel-body mb-3">

                <table class="table table-striped  table-hover">

                    <thead>

                    <tr>

                        <th scope="col">{{ Str::upper(__('project')) }}</th>

                        <th scope="col">{{ Str::upper(__('company')) }}</th>

                    </tr>

                    </thead>

                    <tbody>

                    @foreach ($projects as $project)

                        <tr>

                            <td>

                                <a class="nav-link" href="{{ route('project.show', $project->id) }}">

                                    {{ $project->name }}

                                </a>

                            </td>

                            <td>

                                @if($project->user_id == Auth::user()->id)

                                    <a class="nav-link" href="{{ route('company.show', $project->company->id) }}">

                                        {{ $project->name }}

                                    </a>

                                @else

                                    <em>{{ $project->company->name }}</em>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>


                <div class="mt-3">

                    {!! $projects->links() !!}

                </div>

            </div>

        </div>

    </div>

@endsection