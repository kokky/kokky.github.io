$(function () {
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
