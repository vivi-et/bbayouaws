@extends('layouts.master')
@section('content')

<main>

@foreach ($othercommentGiftcons as $othercommentGiftcon)
{{ $othercommentGiftcon->giftcons }}
<br>
@foreach($othercommentGiftcon->giftcons as $giftcon)
{{-- {{ $giftcon->expire_date }} --}}
<br>
@endforeach
<br>
<br>
@endforeach
<br>
    
</main>
@endsection