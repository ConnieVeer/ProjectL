<form method="POST" action="{{ route('comment.store') }}">

    @csrf

    <input type="hidden" name="commentable_type" value="{{ $commentable_type }}">

    <input type="hidden" name="commentable_id" value="{{ $commentable_id }}">


    <div class="form-group mb-3">

        <label for="comment-content">Comment</label>

        <textarea id="comment-content" name="body" spellcheck="false" rows="5" class="form-control autosize-target"></textarea>


    </div>


    <div class="form-group mb-3">

        <label for="comment-screenshot">Screenshot work (URL)</label>

        <textarea placeholder="Enter screenshot URL" id="comment-screenshot" name="url" spellcheck="false" rows="3"
            class="form-control autosize-target"></textarea>

    </div>


    <div class="form-group">

        <input type="submit" class="btn btn-primary" value="submit" />

    </div>

</form>
