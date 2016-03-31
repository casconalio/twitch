

<html>
  <head>
    <script language="javascript" type="text/javascript" src="jquery.js"></script>
  </head>
  <body>

  <!-------------------------------------------------------------------------
  1) Create some html content that can be accessed by jquery
  -------------------------------------------------------------------------->
  <h2> Client example </h2>
  <h3>Output: </h3>
  <div id="output">this element will be accessed by jquery and this text replaced</div>

  <script id="source" language="javascript" type="text/javascript">
  $(document).ready(function() {

    $.getJSON("http://35.9.22.102/beta/twitch/getComments.php?c=xianheroolz", function(data) {
      $("ul").empty();


      $.each(data.result, function() {

        $("ul").append("<li>Message: "+this['message']+"</li><br />")

      });
    });


  });




  </script>
  </body>
</html>
