<div class="row">

    @foreach ($giftcons as $giftcon)
    <div class="col-md-4">

        @if($giftcon->traded)

        <div class="card mb-4 shadow-sm" style="background-color:silver; opacity:0.5;">
            @else
            <div class="card mb-4 shadow-sm">
                @endif

                @if($giftcon->cover_image == "noimage.jpg")
                <svg class="bd-placeholder-img card-img-top" width="100%" height="225"
                    xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img"
                    aria-label="Placeholder: Thumbnail">

                    <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">No
                        Image</text>
                </svg>
                @else


                <img class="bd-placeholder-img card-img-top"  width="100%" height="225"
                    src="/storage/giftcon_images/{{ $giftcon->imagepath }}" >
                @endif
                <div class="card-body" >
                    <p class="card-text">
                        <a href="/giftcon/trade/{{$giftcon->id}}">
                            {{$giftcon->title}}
                        </a>
                        <br>
                        <div style="margin-top: 5px;">
                            {{  $giftcon->place }}, {{ $giftcon->expire_date }} 까지
                        </div>
                        <div style="clear: both;"></div>
                    </p>
                    <div style="float: right;">
                        <div class="btn-group">
                            {{-- <button type="button" class="btn btn-sm btn-outline-secondary">View</button> --}}
                            {{-- <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button> --}}
                        </div>
                        <small class="text-muted">{{ $giftcon->user->name }}</small>
                        <small class="text-muted"> {{ $giftcon -> created_at->toFormattedDateString() }} </small>
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>