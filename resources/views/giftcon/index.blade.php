@extends('layouts.master')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
</script>
 
@section('content')

<main role="main">
    <section class="jumbotron text-center">
        <div class="container">
            <h2>기프티콘</h2>
            <p class="lead text-muted">등록한 기프티콘을 다른 사람들이랑 거래해보세요</p>
            {{-- <p>
                <a href="#" class="btn btn-primary my-2">Main call to action</a>
                <a href="#" class="btn btn-secondary my-2">Secondary action</a>
            </p> --}}
        </div>
        <br>
        <div style="text-align: center;">
            <div class="aa-input-container" id="aa-input-container">
              <form onsubmit="window.location = '/giftcon/search/' + search.value; return false;">
                @csrf
                @method('POST')
                <input type="search" id="aa-search-input" class="aa-input-search" placeholder="검색" name="search"
                  autocomplete="on" />
                <svg class="aa-input-icon" viewBox="654 -372 1664 1664">
                  <path
                    d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z" />
                </svg>
                <button type="submit" hidden></button>
              </form>
            </div>
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

@endsection


@push('script')
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


@endpush

@push('style')
<style>
    mark {
        background: orange;
        color: black;
        opacity: 0.5;
    }
</style>

@endpush