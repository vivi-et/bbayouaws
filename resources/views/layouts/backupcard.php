<div class="album py-5 bg-light">
    <div class="container">


        <div class="row">

            @foreach($posts as $post)

            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    @if($post->cover_image == "noimage.jpg")
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="225"
                        xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false"
                        role="img" aria-label="Placeholder: Thumbnail">

                        <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef"
                            dy=".3em">No Image</text>
                    </svg>
                    @else

                    <img class="bd-placeholder-img card-img-top" width="100%" height="225"
                        src="/storage/cover_images/{{ $post->cover_image }}">
                    @endif
                    <div class="card-body">
                        <p class="card-text">
                            <a href="/post/{{$post->id}}">
                                {{$post->title}}
                            </a>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                            </div>
                            <small class="text-muted"> {{ $post -> user -> name }} </small>
                            <small class="text-muted"> {{ $post -> created_at->toFormattedDateString() }} </small>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach



        </div>
    </div>
</div>