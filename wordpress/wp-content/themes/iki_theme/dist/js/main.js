// $(document).ready(function(){
//     $('.slideshow_img').slick();
//   });

(function($) {
	
	// $ Works! You can test it with next line if you like
	$(document).ready(function(){
        $('.slideshow_img').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear'
        });

      var container = document.querySelector('#ms-container');
      var msnry = new Masonry( container, {
        itemSelector: '.ms-item',
        columnWidth: '.ms-item',                
      });  
        
      });
	
})( jQuery );

if (typeof slick !== "undefined") { 
    // safe to use the function
}