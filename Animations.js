$( document ).ready(function() {
    $("#promoTitle").hide();
    $("#promoTitle").fadeIn(2000);
    $("#promoSubTitle").hide();
    $("#promoSubTitle").fadeIn(3000);

    $(window).scroll(function() {
      if($(this).scrollTop() > 200){
        $("#promoText").animate({'padding-top': '15rem'}, 300);
        $("#reg").animate({'margin-top': 0}, 400);
      }
    });

  });
