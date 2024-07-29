<div class="panel panel-default">

    <div class="panel-heading mt-5">

        <h3 class="panel-title">

            <span class="bi bi-chat"></span>

            Recent comments

        </h3>

    </div>


    <div class="row mt-4">

        <div class="card col-md-8  p-4">

            <div class="panel-body">

                <ul class="media-list  list-unstyled">

                    @foreach ($comments as $comment)
                        <li class="media">

                            <div class="media-left">

                                <img src="http://placehold.it/60x60" class="img-circle" alt="">

                            </div>

                            <div class="media-body">

                                <h4 class="media-heading">

                                    {{ $comment->user->name }} <small>{{ $comment->user->email }}</small>

                                    <br />

                                    <small>

                                        Commented on {{ $comment->created_at->format('d-m-Y H:i:s') }}

                                    </small>

                                </h4>

                                <p>

                                    {{ $comment->body }}

                                </p>

                            </div>


                            <p class="card-text text-danger">

                                <a href="{{ $comment->url }}" target="_blank">{{ $comment->url }}</a>

                            </p>


                            <p class="pb-3 border-bottom">
                                @if(!empty($taskId))
                                <a class="btn btn-success" href="{{ route('task.show', $taskId) }}"
                                    role="button">View
                                    Task</a>
                                @endif  
                                @if(!empty($projectId))
                                <a class="btn btn-info" href="{{ route('project.show', $projectId) }}"
                                    role="button">View
                                    Project</a>
                                @endif    
                                @if( !empty($companyId))
                                <a class="btn btn-success float float-right"
                                    href="{{ route('company.show', $companyId) }}">

                                    View company

                                </a>
                                @endif

                            </p>

                        </li>
                    @endforeach

                </ul>

            </div>

        </div>

    </div>

</div>
