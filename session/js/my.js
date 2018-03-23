$(document).ready(function () 
{
  setInterval(function(){
    var request = $.ajax({
      url: "index.php?",
      type: 'POST',
      data: {op:"refresh"}
    });

    request.done(function(){
      console.log('session refreshed');
    });
  }, 30000);

  var bodyNavtag = $("body").data("navtag");
  //loop over all navitems and set them active or inactive by comparing navtag
  //of bodyNavtag
  $(".navitem").each(function () {

    var navtag = $(this).data("navtag");

    if (bodyNavtag.localeCompare(navtag) == 0) {
      $(this).removeClass("inactive");
      $(this).addClass("active");
    } else {
      $(this).removeClass("active");
      $(this).addClass("inactive");
    }
  });
});

$(document).idle({
  onIdle: function()
  {
    window.location = 'index.php?op=logout';
  },
  idle: 60000
});
