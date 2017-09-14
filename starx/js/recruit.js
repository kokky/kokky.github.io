$(function () {
    var hash = util.Hash.get();
    var offset = util.isSP() ? { 'flow': -90, 'recruiting-info': -55 } : { 'flow': -120, 'recruiting-info': -80 };
    if (hash && hash.length) {
        var $con = $('section.' + hash);
        if ($con.length) {
            $con.velocity('scroll', { duration: 0, offset: offset[hash] || 0 });
        }
    }
});
