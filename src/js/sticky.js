var $ = require('jquery');

window.requestAnimFrame = require('./requestAnimFrame.js');
var throttle = require('./throttle.js');   


var stick = function (stickyElt, givenPosition, {
    unit = 'px',
    updateHeightOnScroll = false,
    wrapper = true,
    minimumWidth = false
} = {}) {

    if (!stickyElt.length) return;

    var position, posTop, belowWidth;
    var windowHeight = $(window).height(), windowWidth = window.outerWidth;
    var scrollTop = $(document).scrollTop();

    var wrapperSticky = stickyElt.closest('.wrapper-sticky');


    function checkWindowHeight() {
        windowHeight = $(window).height();
        
        position = unit === 'vh' ? windowHeight / 100 / givenPosition - stickyElt.outerHeight() / 2 : givenPosition;
    }
    
    function scrollHandler() {
        scrollTop = $(document).scrollTop();

        if (updateHeightOnScroll && stickyElt.hasClass('sticky')) {
            stickyElt.data('height', stickyElt.outerHeight());
        }

        posTop = stickyElt.data('initialPos') === 'auto' ? 0 : parseFloat(stickyElt.data('initialPos'), 10);
         
        if (scrollTop >= stickyElt.data('offsetTop') - position + posTop) {
            stickyElt.addClass('sticky').css('top', position + 'px');
            if (scrollTop + position + stickyElt.data('height') >= stickyElt.data('offsetBottom')) {
                stickyElt.removeClass('sticky').addClass('sticky-stuck').css({ 'top': 'auto', 'bottom': '0' });
            } else {
                stickyElt.addClass('sticky').removeClass('sticky-stuck').css({ 'top': position + 'px', 'bottom': '' });
            }
        } else {
            stickyElt.removeClass('sticky').css('top', stickyElt.data('initialPos'));
        }

        if (minimumWidth && belowWidth) {
            stickyElt.removeClass('sticky sticky-stuck').css({ 'top': stickyElt.data('initialPos'), 'bottom': '' });
        }
    }

    function init() {
        minimumWidth && windowWidth <= minimumWidth ? belowWidth = true : belowWidth = false;

        if (wrapper) {
            stickyElt.data({ 'offsetTop': wrapperSticky.offset().top });
        } else {
            stickyElt.data({ 'offsetTop': stickyElt.offset().top });
        }

        stickyElt.data({
            'offsetBottom': wrapperSticky.offset().top + wrapperSticky.outerHeight(),
            'height': stickyElt.outerHeight()
        });
    }

    function resizeHandler() {
        checkWindowHeight();
        windowWidth = window.outerWidth;
        init();
        scrollHandler();
    }


    checkWindowHeight();
    
    init();
    stickyElt.data({ 'initialPos': stickyElt.css('top') });
    

    $(document).on('scroll', throttle(function () {

        requestAnimFrame(scrollHandler);

    }, 10));
    
    $(window).on('resize', throttle(function () {

        requestAnimFrame(resizeHandler);

    }, 10));
};

var update = function (stickyElt, wrapper = true) {

    var wrapperSticky = stickyElt.closest('.wrapper-sticky');

    if (wrapper) {
        stickyElt.data({ 'offsetTop': wrapperSticky.offset().top });
    } else {
        stickyElt.data({ 'offsetTop': stickyElt.offset().top });
    }

    stickyElt.data({
        'offsetBottom': wrapperSticky.offset().top + wrapperSticky.outerHeight(),
        'height': stickyElt.outerHeight()
    });
    console.log('yo');
};

module.exports = {
    stick: stick,
    update : update
};
