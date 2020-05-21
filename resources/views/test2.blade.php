<!doctype html>
<html>

<head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <title>Jcrop &raquo; Tutorials &raquo; Event Handler</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://jcrop-cdn.tapmodo.com/v2.0.0-RC1/js/Jcrop.js"></script>
    <link rel="stylesheet" href="http://jcrop-cdn.tapmodo.com/v2.0.0-RC1/css/Jcrop.css" type="text/css">
    
</head>

<body>
    <div id="outer">
        <div class="jcExample">
            <div class="article">

                <h1>Jcrop - Event Handlers</h1>

                <!-- This is the image we're attaching Jcrop to -->
                <img src="/storage/temp_images/1587974964455-4_1588712682.png" id="cropbox" />

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
        </div>
    </div>
</body>

<script type="text/javascript">

console.log('asdfasdf');

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

</script>

</html>