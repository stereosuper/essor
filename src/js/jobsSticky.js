var $ = require('jquery');

window.requestAnimFrame = require('./requestAnimFrame.js');
var throttle = require('./throttle.js');

var init = function (body, header, blockSticky, dropdownsSticky, minimumWidth) {
    if (!blockSticky.length) return;
    
    
    var scrollTop, windowWidth = window.outerWidth;
    var belowWidth = minimumWidth && windowWidth <= minimumWidth ? true : false;
    var dropdownsTop = dropdownsSticky.offset().top;
    var posTop = windowWidth > 1200 ? dropdownsTop - 72 : dropdownsTop - 57;
    var wrapperSticky = blockSticky.closest('.wrapper-sticky');
    
    function headerStuck() {
        scrollTop >= posTop ? header.addClass('off').css({ 'top': posTop }) : header.removeClass('off').css({ 'top': '' });
    }

    function stickyInterval() {

        if (scrollTop >= blockSticky.data('initialPos') - 95) {
            if (scrollTop > posTop) {
                if (scrollTop > posTop + 70) {
                    if (scrollTop + blockSticky.data('height') + 25 >= blockSticky.data('offsetBottom')) {
                        blockSticky.css({ 'position': 'absolute', 'top': 'auto', 'bottom': '0' });
                    } else {
                        blockSticky.css({ 'position': 'fixed', 'top': '25px', 'margin-top': '', 'bottom': 'auto' });
                    }
                } else {
                    blockSticky.css({ 'position': '', 'top': '', 'margin-top': '109px' });
                }
            } else {
                blockSticky.css({ 'position': 'fixed', 'top': '95px', 'margin-top': '' });
            }
        }
        
        if (scrollTop < blockSticky.data('initialPos') - 85 || belowWidth) {
            blockSticky.css({ 'position': '', 'top': '', 'margin-top': '' });
        }
    }

    function resizeHandler() {
        windowWidth = window.outerWidth;
        belowWidth = minimumWidth && windowWidth <= minimumWidth ? true : false;
        posTop = windowWidth > 1200 ? dropdownsTop - 72 : dropdownsTop - 57;

        blockSticky.data({'offsetBottom': wrapperSticky.offset().top + wrapperSticky.outerHeight(), 'height': blockSticky.outerHeight() });
    }

    function scrollHandler() {
        scrollTop = $(document).scrollTop();
        headerStuck();
        stickyInterval();
    }


    blockSticky.data({ 'initialPos': blockSticky.offset().top, 'offsetBottom': wrapperSticky.offset().top + wrapperSticky.outerHeight(), 'height': blockSticky.outerHeight() });


    $(document).on('scroll', throttle(function () {
        
        requestAnimFrame(scrollHandler);

    }, 10));

    $(window).on('resize', throttle(function () {
        
        requestAnimFrame(resizeHandler);

    }, 10));
};

var update = function( blockSticky ){
    if (!blockSticky.length) return;

    var wrapperSticky = blockSticky.closest('.wrapper-sticky');

    blockSticky.data({'offsetBottom': wrapperSticky.offset().top + wrapperSticky.outerHeight(), 'height': blockSticky.outerHeight() });
};

module.exports = {
    init: init,
    update : update
};
