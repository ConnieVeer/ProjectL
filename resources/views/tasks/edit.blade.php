    @extends('layouts.app')

    @section('content')
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-10">
                    <form method="POST" action="{{ route('task.update', $task->id) }}">
                        @csrf
                        @method('PUT')
                        {{-- <input type="hidden" name="_method" value="PUT"> alternatief voor @method(put) --}}
                        <label for="task-name">Name:</label>
                        <input placeholder="Enter name" id="task-name" required name="name" spellcheck="false"
                            class="form-control" value="{{ $task->name }}" />
                        <br>
                        <textarea placeholder="Enter description" id="task-content" name="description" spellcheck="false" rows="5"
                            cols="10" class="form-control">{{ $task->description }}</textarea><br>
                        <input type="number" placeholder="Enter hours" id="hours" name="hours"
                            class="form-control" /><br>
                        <input type="submit" value="submit" />
                    </form>
                </div>
            </div>
        </div>
    @endsection
