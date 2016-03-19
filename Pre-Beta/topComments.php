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
  <ul>
  </ul>
  <script id="source" language="javascript" type="text/javascript">


  //$("ul").empty();
  //$("ul").append("<li>message: "+data+"</li><br />");
  //$.each(data.result, function(){
  //  $("ul").append("<li>message: "+data['message']+"</li><br />");
  //});


  var a;


  function done() {
  	  setTimeout( function() {
  	  getAjax();
  	  done();
  	  }, 200);
  }


  function getAjax() {
    $.ajax({
      url: 'getComments.php?c=xianheroolz',                  //the script to call to get data
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
