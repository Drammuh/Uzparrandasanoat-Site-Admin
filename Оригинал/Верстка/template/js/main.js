jQuery(function($) {'use strict',

		
 
    // Offset for Main Navigation
    $('nav.navbar').affix({
        offset: {
            top: 350
        }
    });
		$('.no-index nav.navbar').affix({
        offset: {
            top: 10
        }
    });
		$('.gal_slider').slick({
      slidesToShow: 6,
      slidesToScroll: 1,
      infinite: true,
			arrows:true,
      speed: 500,
      autoplay: true,
      autoplaySpeed: 2000,
			responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }]
    });
		$('.c_list').slick({
      slidesToShow: 6,
      slidesToScroll: 1,
      infinite: true,
			arrows:true,
      speed: 500,
      autoplay: true,
      autoplaySpeed: 2000,
			responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      }]
		});
		$('.links').slick({
      slidesToShow: 9,
      slidesToScroll: 1,
      infinite: true,
			arrows:true,
      speed: 500,
      autoplay: true,
      autoplaySpeed: 2000,
			responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      }]
		});
										
    $('.open_search').click(function(){
			 $(this).toggleClass('open');
			 $('.search_box form').toggleClass('active');
   	});   
});