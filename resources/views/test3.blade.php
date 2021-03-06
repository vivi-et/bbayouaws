@extends('layouts.master')

@push('headertest')

@endpush

@push('temp')

<script type="text/javascript">
    console.log('asdfasd');
    $(document).on('show.bs.modal','#myModal', function () {
        console.log('modalmodal');
      


    jQuery(document).ready(function(){

jQuery('#cropbox').Jcrop({
    onChange: showCoords,
    onSelect: showCoords
});

});

// Simple event handler, called from onChange and onSelect
// event handlers, as per the Jcrop invocation above
function showCoords(c)
{
jQuery('#x1').val(c.x);
jQuery('#y1').val(c.y);
jQuery('#x2').val(c.x2);
jQuery('#y2').val(c.y2);
jQuery('#w').val(c.w);
jQuery('#h').val(c.h);
};


});
</script>

@endpush
@section('content')
<!-- Button trigger modal -->
<button id="btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="storage/cover_images/1588022438127-5_1588691179.jpg" id="cropbox">
                <!-- This is the image we're attaching Jcrop to -->

                <!-- This is the form that our event handler fills -->
                <form onsubmit="return false;" class="coords">
                    <label>X1 <input type="text" size="4" id="x1" name="x1" /></label>
                    <label>Y1 <input type="text" size="4" id="y1" name="y1" /></label>
                    <label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
                    <label>Y2 <input type="text" size="4" id="y2" name="y2" /></label>
                    <label>W <input type="text" size="4" id="w" name="w" /></label>
                    <label>H <input type="text" size="4" id="h" name="h" /></label>
                </form>

                <p>
                    <b>An example with a basic event handler.</b> Here we've tied
                    several form values together with a simple event handler invocation.
                    The result is that the form values are updated in real-time as
                    the selection is changed, thanks to Jcrop's <em>onChange</em> event handler.
                </p>

                <p>
                    That's how easily Jcrop can be integrated into a traditional web form!
                </p>

                <div id="dl_links">
                    <a href="http://deepliquid.com/content/Jcrop.html">Jcrop Home</a> |
                    <a href="http://deepliquid.com/content/Jcrop_Manual.html">Manual (Docs)</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>



@endsection