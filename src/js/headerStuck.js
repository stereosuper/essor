var $ = require('jquery');

window.requestAnimFrame = require('./requestAnimFrame.js');
var throttle = require('./throttle.js');


module.exports = function(body, header, posTop, bodyClass){
    if (!body.hasClass(bodyClass)) return;
    
    var scrollTop;

    function scrollHandler() {
        scrollTop = $(document).scrollTop();
        if (scrollTop >= posTop) {
            header.css({'position': 'absolute', 'top': posTop});
        } else {
            header.css({'position': '', 'top': ''});
        }
    }


    $(document).on('scroll', throttle(function(){
        requestAnimFrame(scrollHandler);
    }, 10));

    $(window).on('resize', throttle(function(){
        requestAnimFrame(resizeHandler);
    }, 10));
}
