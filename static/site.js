
$(document).ready(function ($) {

  // Your JavaScript goes here

  $('.mycarousel').slick({
    infinite: true,
    slidesToShow: 2,
    slidesToScroll: 1,
    arrows: true,
    dots: true,
    autoplay: true,
    autoplaySpeed: 2000,
    responsive: [
      {
        breakpoint: 1100,
        settings: {
          arrows: false
        }
      },
      {
        breakpoint: 950,
        settings: {
          slidesToShow: 1,
          arrows: false
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ]
  });

  $('.imageslider').slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    autoplay: true,
    autoplaySpeed: 2000,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 850,
        settings: {
          slidesToShow: 1,          
        }
      }
    ]
  });


  $('.dropdown-field').click(function () {
    $(this).find('.drop-text').slideToggle();
    //var result = $(this).parents()[1];
    //var result2 = $(result).find('.drop-text');
    //$(result2).slideToggle();
  }
  );


});

