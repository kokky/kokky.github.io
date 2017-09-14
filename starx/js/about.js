$(function () {
    var hash = util.Hash.get();
    var offset = util.isSP() ? { service: -110, culture: -55 } : { service: -120, culture: -80 };
    if (hash && hash.length) {
        var $con = $('section.' + hash);
        if ($con.length) {
            $con.velocity('scroll', { duration: 0, offset: offset[hash]});
        }
    }
    $('.page_anchor a').on('click', function () {
        var sel = $(this).attr('href').substring(1);
        var $con = $('section.' + sel);
        if ($con.length) {
            $con.velocity('scroll', { duration: 600, offset: offset[sel], easing: Ease.OutExpo });
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
