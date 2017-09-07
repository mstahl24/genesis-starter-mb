$(function () {
    // Check the initial Poistion of the Sticky Header
    var stickyHeaderTop = $('.sticky-header').offset().top;

    $(window).scroll(function () {
        if ($(window).scrollTop() > stickyHeaderTop) {
        	if($("body").hasClass("logged-in")) {
	            $('.sticky-header').css({
	                position: 'fixed',
	                top: $('#wpadminbar').height()
	            });
	            $('.site-inner').css('margin-top', $('.sticky-header').outerHeight(true) + $('#wpadminbar').height());
	        } else {
	        	$('.sticky-header').css({
	                position: 'fixed',
	                top: '0px'
	            });
	            $('.site-inner').css('margin-top', $('.sticky-header').outerHeight(true))
	        }
        } else {
            $('.sticky-header').css({
                position: 'relative',
                top: '0px'
            });
            $('.site-inner').css('margin-top', '0px');
        }

        if ( $( document ).scrollTop() > stickyHeaderTop ){
			$( '.sticky-header' ).addClass( 'scrolled' );
		} else {
			$( '.sticky-header' ).removeClass( 'scrolled' );
		}

    });
});




$(function() {
    
    var lastScrollTop = 0;
    $(window).scroll(function(event){
        var st = $(this).scrollTop();
        if (st < 208) {
            // top code
            $('.sticky-header').css({
                opacity: '1',
                transition: 'all .3s ease-in-out',
                visibility: 'visible'
            });

        } else if( (st > lastScrollTop) && $('.responsive-menu-icon').hasClass('nav-open') ) {

    		// upscroll code
            $('.sticky-header').css({
                opacity: '1',
                transition: 'all 0.3s ease-in-out',
                visibility: 'visible'
            });

	    } else if (st > lastScrollTop){

	        // downscroll code
            $('.sticky-header').css({
                opacity: '0',
                transition: 'all 0.1s ease-in-out',
                visibility: 'hidden'
	        });


        } else {
            // upscroll code
            $('.sticky-header').css({
                opacity: '1',
                transition: 'all 0.3s ease-in-out',
                visibility: 'visible'
            });
        }
        lastScrollTop = st;
    });



    
});