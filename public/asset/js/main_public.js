var win = $(window);

// for dekstop
if(win.width() >= 812){
    var initNavbar = 168;
    win.scroll(function () {
        if (win.scrollTop() >= initNavbar) {
            $( "#navigasi" ).addClass( "scroll" );
        }
        else if (win.scrollTop() <= initNavbar) {
            $( "#navigasi" ).removeClass( "scroll" );
        }
    });
}
// end for dekstop

// for mobile
if(win.width() <= 812){
    // $('#kopin_banner #burger').click(function(){
    //     $('#kopin_banner').toggleClass("active");
    //     $('#navigasi').toggleClass("active");
    // });
    // var initNavbar = 68;
    // win.scroll(function () {
    //     if (win.scrollTop() >= initNavbar) {
    //         $( "#nav" ).addClass( "scroll_mobile" );
    //     }
    //     else if (win.scrollTop() <= initNavbar) {
    //         $( "#nav" ).removeClass( "scroll_mobile" );
    //     }
    // });
}
// for mobile

// animate scrool to
    $(function() {
        $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 150
                        }, 1500);
                    return false;
                }
            }
        });
    });
// animate scrool to