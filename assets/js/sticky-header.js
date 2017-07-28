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
                position: 'static',
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