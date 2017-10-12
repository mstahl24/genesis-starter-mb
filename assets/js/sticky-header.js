$(function () {
    // Check the initial Poistion of the Sticky Header
    var stickyHeaderTop = $('.sticky-header').offset().top;


    var header = $('.sticky-header');
    var inner = $('.site-inner');

    $(window).scroll(function () {
        if ($(window).scrollTop() > stickyHeaderTop) {
            if($("body").hasClass("logged-in")) {
                header.css({
                    position: 'fixed',
                    top: $('#wpadminbar').height()
                });
                inner.css('margin-top', header.outerHeight(true) + $('#wpadminbar').height());
            } else {
                header.css({
                    position: 'fixed',
                    top: '0px'
                });
                inner.css('margin-top', header.outerHeight(true));
            }
        } else {
            header.css({
                position: 'relative',
                top: '0px'
            });
            inner.css('margin-top', '0px');
        }

        if ( $( document ).scrollTop() > stickyHeaderTop ){
            header.addClass( 'scrolled' );
        } else {
            header.removeClass( 'scrolled' );
        }

    });
});




$(function() {

    //caches a jQuery object containing the header element
    var header = $('.sticky-header');

    var timer;
    
    var lastScrollTop = 0;
    $(window).scroll(function(event){

        var scroll = $(window).scrollTop();

        if (scroll >= 1) {
            header.addClass("scrolled");
        } else {
            header.removeClass("scrolled");
        }

        if(timer) {
          window.clearTimeout(timer);
        }

        timer = window.setTimeout(function() {

            var st = $(this).scrollTop();
            if (st < 160) {
                // top code
                header.css({
                    opacity: '1',
                    transition: 'opacity .3s ease-in-out',
                    visibility: 'visible'
                });

            } else if( (st > lastScrollTop) && $('.responsive-menu-icon').hasClass('nav-open') ) {

                // upscroll code
                header.css({
                    opacity: '1',
                    transition: 'opacity 0.3s ease-in-out',
                    visibility: 'visible'
                });

            } else if (st > lastScrollTop){

                // downscroll code
                header.css({
                    opacity: '0',
                    transition: 'opacity 0.1s ease-in-out',
                    visibility: 'hidden'
                });


            } else {
                // upscroll code
                header.css({
                    opacity: '1',
                    transition: 'opacity 0.3s ease-in-out',
                    visibility: 'visible'
                });
            }
            lastScrollTop = st;

        }, 100);
        
    });



    
});