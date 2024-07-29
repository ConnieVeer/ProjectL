    @extends('layouts.app')

    @section('content')
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-10">
                    <form method="POST" action="{{ route('company.update', $company->id) }}">
                        @csrf
                        @method('PUT')
                        {{-- <input type="hidden" name="_method" value="PUT"> alternatief voor @method(put) --}}
                        <label for="company-name">Name:</label>
                        <input placeholder="Enter name" id="company-name" required name="name" spellcheck="false"
                            class="form-control" value="{{ $company->name }}" />
                        <br>
                        <textarea placeholder="Enter description" id="company-content" name="description" spellcheck="false" rows="5"
                            cols="10" class="form-control">{{ $company->description }}</textarea><br>
                        <input type="submit" value="submit" />
                    </form>
                </div>
            </div>
        </div>
    @endsection
