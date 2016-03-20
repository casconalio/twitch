<html>
  <head>
    <script language="javascript" type="text/javascript" src="jquery.js"></script>
  </head>
  <body>

  <div id="output">this element will be accessed by jquery and this text replaced</div>
  <script id="source" language="javascript" type="text/javascript">


  //$("ul").empty();
  //$("ul").append("<li>message: "+data+"</li><br />");
  //$.each(data.result, function(){
  //  $("ul").append("<li>message: "+data['message']+"</li><br />");
  //});


  var a;
  var channel = window.localStorage.getItem("Chans");

  function done() {
  	  setTimeout( function() {
  	  getAjax();
  	  done();
  	  }, 200);
  }

  function getAjax() {
    $.ajax({
      url: 'getComments.php?c='+channel,                  //the script to call to get data
      //data: "",                        //you can insert url argumnets here to pass to api.php
      dataType: 'HTML',                //data format
      success: function(data)          //on recieve of reply
      {
          $("#output").html(data);
      }
    });
  }

  $(document).ready(function() {
      done();
  });

  </script>
  </body>
</html>
