(function() {
    var u = navigator.userAgent.toLowerCase(),
    is = function(t) { 
        return (u.indexOf(t) != -1)
    };

    document.getElementsByTagName("html")[0].className += ([
        (!(/opera|webtv/i.test(u)) && /msie (\d)/.test(u)) ? (' ie ie' + RegExp.$1)
        :is('firefox/2')?' gecko ff2'
        :is('firefox/3')?' gecko ff3'
        :is('gecko/')?' gecko'
        :is('opera/9')?' opera opera9':/opera (\d)/.test(u)?' opera opera'+RegExp.$1
        :is('konqueror')?' konqueror'
        :is('chrome/')?' webkit chrome'
        :is('applewebkit/')?' webkit safari'
        :is('mozilla/')?' gecko':'',
        (is('x11')||is('linux'))?' linux'
        :is('mac')?' mac'
        :is('win')?' win':''
    ].join(''));
})();   
