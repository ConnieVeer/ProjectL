    @extends('layouts.app')

    @section('content')
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-10">
                    <form method="POST" action="{{ route('project.update', $project->id) }}">
                        @csrf
                        @method('PUT')
                        {{-- <input type="hidden" name="_method" value="PUT"> alternatief voor @method(put) --}}
                        <label for="project-name">Name:</label>
                        <input placeholder="Enter name" id="project-name" required name="name" spellcheck="false"
                            class="form-control" value="{{ $project->name }}" />
                        <br>
                        <textarea placeholder="Enter description" id="project-content" name="description" spellcheck="false" rows="5"
                            cols="10" class="form-control">{{ $project->description }}</textarea><br>
                        <input type="submit" value="submit" />
                    </form>
                </div>
            </div>
        </div>
    @endsection
