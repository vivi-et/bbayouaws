@extends('layouts.master')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
</script>
 
@section('content')

<main role="main">
    <section class="jumbotron text-center">
        <div class="container">
            <h2>기프티콘</h2>
            <p class="lead text-muted">다른 사람들이랑 거래해보세요</p>
            {{-- <p>
                <a href="#" class="btn btn-primary my-2">Main call to action</a>
                <a href="#" class="btn btn-secondary my-2">Secondary action</a>
            </p> --}}
        </div>
    </section>

    @if(count($giftcons))
    @include('layouts.card')
    @else
    <div style="text-align: center;">

        <h4>현재 거래중인 기프티콘이 없습니다.</h4>
    </div>
@endif



</main>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>


<script>
    function makeImage(x) {
      

        $.ajax({
            type: "PUT",
            url: "/giftcon/" + x,
            cache: false,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            data: {
                'text1': '1',
                'text2': '2',
                'text3': '3',
            },
            processData: false,
            success: function (data) {
            let base64image = data.barcode;
            let ajaxbarcodeno = data.barcodeno;
            let downloadAs = data.downloadAs;

            // alert(data.barcode);
            let theDiv = document.getElementById('theBarcode' + x);
            let theBarcodeno = document.getElementById('theBarcodeno' + x);
            let htmloutput = '<img src="data:image/png;base64,' +base64image+'">';
    
                
                theDiv.innerHTML += htmloutput;
                theBarcodeno.innerHTML +=  ajaxbarcodeno;

                let thisGiftcon = document.getElementById('giftcon' + x);

                html2canvas([thisGiftcon], {
                    onrendered: function (canvas) {
                        var data = canvas.toDataURL('image/jpeg');


                        var link = document.createElement('a');
                        link.download = downloadAs;
                        link.href = data;
                        link.click();

                    }

                });
            }
        });

    };

</script>
<style>
    .one-third:hover,
    .one-third:focus {
        background: rgb(141, 87, 21);
        cursor: pointer;
    }
</style>

@endsection