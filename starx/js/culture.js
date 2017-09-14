$(function () {
    var hash = util.Hash.get();
    $('#wrap').imagesLoaded( function() {
        if (hash && hash.length) {
            var $con = $('section.' + hash);
            if ($con.length) {
                if(util.isSP()) {
                    $con.velocity('scroll', { duration: 0, offset: -58 });
                } else {
                    $con.velocity('scroll', { duration: 0, offset: -80 });
                }
            }
        }
    });
    $('.pictures').bxSlider(util.isSP() ? {
        auto: true,
        speed: 300,
        moveSlides: 1,
        slideMargin: 40,
        pager: false,
        useCSS: false,
        infiniteLoop: true,
        prevText: '',
        nextText: ''
    } : {
        auto: true,
        speed: 300,
        minSlides: 3,
        maxSlides: 4,
        moveSlides: 1,
        slideWidth: 300,
        slideMargin: 40,
        pager: false,
        useCSS: false,
        infiniteLoop: true,
        prevText: '',
        nextText: ''
    });
});
