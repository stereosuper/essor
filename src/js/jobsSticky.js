var $ = require('jquery');

window.requestAnimFrame = require('./requestAnimFrame.js');
var throttle = require('./throttle.js');


module.exports = function(body, header, posTop, bodyClass, blockSticky, minimumWidth){
    if (!body.hasClass(bodyClass)) return;
    
    var scrollTop, belowWidth;
    var windowWidth = window.outerWidth; 

    function headerStuck() {
        if (scrollTop >= posTop) {
            header.css({ 'position': 'absolute', 'top': posTop });
        } else {
            header.css({'position': '', 'top': ''});
        }
    }

    function stickyInterval() {
        if (scrollTop >= blockSticky.data('initialPos') - 95) {
            if (scrollTop > posTop) {
                if (scrollTop > posTop + 70) {
                    blockSticky.css({ 'position': 'fixed', 'top': '25px', 'margin-top': '' });
                } else {
                    blockSticky.css({ 'position': '', 'top': '', 'margin-top': blockSticky.height() - 46+'px' });
                }
            } else {
                blockSticky.css({ 'position': 'fixed', 'top': '95px', 'margin-top': '' });
            }
        } else if(scrollTop < blockSticky.data('initialPos') - 85){
            blockSticky.css({ 'position': '', 'top': '', 'margin-top': '' });
        }
        if (belowWidth) {
            blockSticky.css({ 'position': '', 'top': '', 'margin-top': '' });
        }
    }

    function scrollHandler() {
        scrollTop = $(document).scrollTop();
        headerStuck();
        stickyInterval();
    }

    function resizeHandler(){
        windowWidth = window.outerWidth;
        minimumWidth && windowWidth <= minimumWidth ? belowWidth = true : belowWidth = false;
        scrollHandler();  
    }

    blockSticky.data({
        'initialPos': blockSticky.offset().top,
    });


    $(document).on('scroll', throttle(function(){
        requestAnimFrame(scrollHandler);
    }, 10));

    $(window).on('resize', throttle(function(){
        requestAnimFrame(resizeHandler);
    }, 10));
}
