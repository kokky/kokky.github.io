$(window).load(function () {
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