var $ = require('jquery');

require('gsap/CSSPlugin');
var TweenLite = require('gsap/TweenLite');

var throttle = require('./throttle.js');
window.requestAnimFrame = require('./requestAnimFrame.js');


module.exports = function(header){

    var hover = $('#hover'), widthHover = hover.width();
    var menu = $('#menuSecondary');
    var current = menu.find('.current-menu-item');
    current = current.length ? current : menu.find('.current_page_parent');
    var menuLeft = header.find('.menu-secondary').offset().left;
    var currentX = current.length ? current.offset().left - menuLeft + (current.outerWidth() - widthHover)/2 : 0;
    var logoIn = header.find('.logo-in');

    var scrollTop, windowWidth = window.outerWidth;

    
    header.on('click', '.btn-menu-main', function(){

        $(this).toggleClass('on');

    }).on('mousemove', '#menuSecondary', function(e){

        if( windowWidth > 1200 ){
            $(this).find('a').each(function(){
                var thisLink = $(this);
                
                if( e.pageX >= thisLink.offset().left && e.pageX <= thisLink.offset().left + thisLink.outerWidth() ){
                    TweenLite.to(hover, 0.05, {scaleX: 1, rotation: 0, onComplete: function(){
                        TweenLite.to(hover, 0.3, {x: thisLink.offset().left - menuLeft + (thisLink.outerWidth() - widthHover)/2, ease: Power4.easeOut});
                    }});
                }
            });
        }

    }).on('mouseenter', '#menuSecondary', function(){

        if( windowWidth > 1200 ){
            TweenLite.to($('#hover'), 0.1, {opacity: 1});
        }

    }).on('mouseleave', '#menuSecondary', function(){

        if( windowWidth > 1200 ){
            if( currentX > 0 ){
                TweenLite.to(hover, 0.2, {x: currentX, ease: Power4.easeOut, delay: 0.2, onComplete: function(){
                    TweenLite.to(hover, 0.2, {scaleX: 0.6, rotation: 90});
                }});
            }else{
                TweenLite.to(hover, 0.1, {opacity: 0});
            }
        }

    }).on('click', '#menuSecondary', function(){

        if( windowWidth > 1200 ){
            TweenLite.to(hover, 0.3, {scaleX: 0.6, rotation: 90});
            header.off('mousemove').off('mouseleave').off('mouseenter');
        }

    });


    if( currentX > 0  && windowWidth > 1200 ){
        TweenLite.set(hover, {opacity: 1, scaleX: 0.6, rotation: 90, x: currentX});
    }

    $(window).on('resize', throttle(function(){
        requestAnimFrame(function(){
            windowWidth = window.outerWidth;

            menuLeft = header.find('.menu-secondary').offset().left;
            currentX = current.length ? current.offset().left - menuLeft + (current.outerWidth() - widthHover)/2 : 0;
        });
    }, 60));

    $(document).on('scroll', throttle(function(){
        scrollTop = $(document).scrollTop();

        // Add a class to header when page is scrolled
        if( windowWidth > 780 ){
            if( scrollTop > 100 ){
                header.addClass('on');
                TweenLite.to(logoIn, 0.3, {x: '-85px'});
             }else{
                 header.removeClass('on');
                 TweenLite.to(logoIn, 0.3, {x: 0});
             }
        }else if( header.hasClass('on') ){
            header.removeClass('on');
            TweenLite.set(logoIn, {x: 0});
        }
    }, 60));
}