$(document).ready(function() {

    //Smooth Scroll
    $(function() {
        $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });


    // Main Menu
    /*$('#main-nav').affix({
    	offset: {
    		top: $('header').height()
    	}
    });*/


    // Top Search
    $("#ss").click(function(e) {
        e.preventDefault();
        $(this).toggleClass('current');
        $(".search-form").toggleClass('visible');
    });


    //Slider
    $('.flexslider').flexslider({
        animation: "fade",
        directionNav: false,
        pauseOnAction: false,
    });

    var containerPosition = $('.container').offset();
    var positionPad = containerPosition.left + 15;

    $('#slider').find('.caption').css({
        left: positionPad + 'px',
        marginTop: '-' + $('.caption').height() / 2 + 'px'
    });


    // number effect
    $('.about-bg-heading').one('inview', function(event, visible) {
        if (visible == true) {
            $('.count').each(function() {
                $(this).prop('Counter', 0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 5000,
                    easing: 'swing',
                    step: function(now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });
        }
    });


    //Google Map
    var map;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: -34.397, lng: 150.644 },
            zoom: 8
        });
    }

});