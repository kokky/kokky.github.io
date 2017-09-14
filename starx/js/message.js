$(function () {
    var $win = $(window);
    var $yt = $('#movieplayer'), $wrap = $yt.find('>div');
    var iframe = '<iframe width="853" height="480" src="//www.youtube.com/embed/[id]?rel=0" frameborder="0" allowfullscreen></iframe>';
    $('a.youtube').click(function () {
        if (util.isSP()) {
            var height = $win.width() * 0.56;
            $wrap.css({
                height: height,
                marginTop: ($win.height() - height) / 2
            });
        }
        var id = $(this).attr('href').split('=')[1];
        $yt.velocity('fadeIn', 300).promise().done(function () {
            $wrap.html(iframe.replace('[id]', id));
        });
        return false;
    });
    $yt.click(function () {
        $wrap.empty();
        $yt.velocity('fadeOut', 300);
        return;
    });
});
