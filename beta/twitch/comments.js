$(document).ready( function() {
 done();
});

function done() {
    setTimeout( function() {
    updates();
    done();
    }, 200);
}

function updates() {
   $.getJSON("getComments.php?c=xianheroolz", function(data) {
       $("ul").empty();
     $.each(data.result, function(){
      $("ul").append("<li>Name: "+this['message']+"</li><br />");
     });
 });
}
