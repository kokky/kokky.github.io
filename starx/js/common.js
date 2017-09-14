var util;
(function (util) {
    var _UA = navigator.userAgent.toLocaleLowerCase();
    util.UA = _UA;
    util.device = {
        iphone: /iphone/.test(_UA),
        ipad: /ipad/.test(_UA),
        android: /android/.test(_UA),
        mobile: /mobile/.test(_UA),
        windowsPhone: /windows phone/.test(_UA)
    };
    util.isPC = function () {
        return !(util.device.iphone || util.device.ipad || util.device.android || util.device.windowsPhone);
    };
    util.isSP = function () {
        return (util.device.iphone || (util.device.android && util.device.mobile) || util.device.windowsPhone);
    };
    util.isMobile = function () {
        return util.isSP() || (util.device.ipad || util.device.android);
    };
    util.isLegacyIE = function () {
        return !('addEventListener' in window);
    };
    var Hash = (function () {
        function Hash() {
        }
        Hash.get = function (idx) {
            if (!Hash._hash) {
                Hash._hash = location.hash.replace('#', '').split('/');
            }
            return Hash._hash[idx || 0] || null;
        };
        return Hash;
    })();
    util.Hash = Hash;
})(util || (util = {}));
var Ease = {
    OutExpo: [0.19, 1, 0.22, 1]
};
var starxrecruit;
(function (starxrecruit) {
    var $win = $(window);
    var eventClick = util.isPC() ? 'click' : 'touchend';
    var ContentsHeader = (function () {
        function ContentsHeader() {
            this._initView();
            this._initEvent();
        }
        ContentsHeader.prototype._initView = function () {
            this.$toggle = $('#nav_toggle');
            this.$nav = $('#global_nav');
            this.$in = this.$nav.find('> *');
        };
        ContentsHeader.prototype._initEvent = function () {
            var _this = this;
            var width = 350;
            if (util.isSP()) {
                width = $win.width();
                this.$nav.css({
                    'width': width,
                    'right': -width
                });
            }
            this.$toggle.on('click', function () {
                if (_this.isOpen) {
                    _this.isOpen = false;
                    _this.$toggle.removeClass('open');
                    _this.$nav.velocity({ right: -width }, { duration: 300, easing: Ease.OutExpo });
                    _this.$in.velocity({ translateX: 100, opacity: 0 }, { duration: 250, easing: Ease.OutExpo });
                }
                else {
                    _this.isOpen = true;
                    _this.$toggle.addClass('open');
                    _this.$in.velocity({ translateX: 100, opacity: 0 }, { duration: 0 }).velocity({ translateX: 0, opacity: 1 }, { duration: 400, delay: 60, easing: Ease.OutExpo });
                    _this.$nav.velocity({ right: 0 }, { duration: 400, easing: Ease.OutExpo });
                }
                return false;
            });
            if (!util.isSP()) {
                this.$nav.niceScroll({
                    autohidemode: false,
                    cursorcolor: '#666',
                    cursorborder: false,
                    smoothscroll: false
                });
                this.$nav.getNiceScroll().hide();
            }
        };
        return ContentsHeader;
    })();
    var Common = (function () {
        function Common() {
            this._initPagetop();
            this._initFBPlugin();
        }
        Common.prototype._initPagetop = function () {
            var pos = util.isSP() ? 100 : 400;
            var visible = false;
            var $top = $('#pagetop').on('click', function () {
                $('html').velocity('scroll', { duration: 600, easing: Ease.OutExpo });
                return false;
            });
            $win.scroll(function () {
                if ($win.scrollTop() > pos) {
                    if (!visible) {
                        visible = true;
                        $top.velocity('fadeIn', 200);
                    }
                }
                else {
                    if (visible) {
                        visible = false;
                        $top.velocity('fadeOut', 200);
                    }
                }
            });
        };
        Common.prototype._initFBPlugin = function () {
            var $wrap = $('.fb_plugin');
            var html = $wrap.html();
            html = html.replace('data-width="400"', 'data-width="' + $wrap.width() + '"');
            $wrap.empty().html(html);
        };
        return Common;
    })();
    starxrecruit.common = function () {
        var ww = $win.width();
        if ((ww > 780 && util.device.android && !util.device.mobile) || util.device.ipad) {
            $('html, body').css('zoom', ww / 980);
        }
        $(function () {
            new ContentsHeader();
            new Common();
        });
        $win.load(function () {
            var feed = new Instafeed({
                get: 'user',
                userId: '2691838658',
                links: true,
                limit: 5,
                resolution: 'low_resolution',
                template: '<li><a href="{{link}}" target="_blank"><img src="{{image}}" target="_blank" width="225" height="225" /></a></li>',
                clientId: '8bab027f836a42a18a518346436913f1',
                accessToken: '2691838658.8bab027.730be8ed507c47149907a50a80dd719b'
            });
            feed.run();
        });
    };
})(starxrecruit || (starxrecruit = {}));
starxrecruit.common();

//copyright
$(function () {
    var element = document.getElementsByClassName("copyright")[0];
    var year = new Date().getFullYear();
    var copyright = "Copyright&copy; " + year + " StarX Inc. All Rights Reserved.";
    element.textContent = $("<div/>").html(copyright).text();
});