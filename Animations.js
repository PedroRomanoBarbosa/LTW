
$( document ).ready(function() {
    $("#promoTitle").hide();
    $("#promoTitle").fadeIn(2000);
    $("#promoSubTitle").hide();
    $("#promoSubTitle").fadeIn(2000);

    $(window).scroll(function() {
      if($(this).scrollTop() > 300){
        $("#promoText").animate({'padding-top': '20rem'}, 300);
        $("#reg").animate({'margin-top': 0}, 400);
      }
    });

  });
