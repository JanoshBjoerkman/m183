$(document).ready(function () {

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

  $(".comment-btn").click(function() {
    hideAllCommentAreas();
    $(this).parents(".comment-btn-area").prev().show();
    $(this).parents(".comment-btn-area").hide();
  })

  $(document).scrollTop($(".ap").offset().top);

});


function hideAllCommentAreas() {
  $(".comment-area").each(function () {
    $(this).hide();
  });

  $(".comment-btn-area").each(function () {
    $(this).show();
  });
}


