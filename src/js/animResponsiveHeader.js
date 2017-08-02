var $ = require('jquery-slim');

require('gsap/CSSPlugin');
require('gsap/ScrollToPlugin');
var TweenLite = require('gsap/TweenLite');


module.exports = function(body, nav, menus, pageWrapper){
    if( !nav.length ) return;

    var scrollTop;

    body.on('click', '#burger', function(e){

        e.preventDefault();

        scrollTop = $(document).scrollTop();

        if( nav.hasClass('on') ){
            nav.removeClass('on');
            pageWrapper.removeClass('menu-open');
        }else{
            if( scrollTop === 0 ){
                nav.addClass('on');
                pageWrapper.addClass('menu-open');
            }else{
                TweenLite.to(window, 0.5, {scrollTo: 0, onComplete: function(){
                    nav.addClass('on');
                    pageWrapper.addClass('menu-open');
                }});
            }
        }

        $(this).toggleClass('on');

    }).on('click', '#main.menu-open', function(){

        nav.removeClass('on');
        pageWrapper.removeClass('menu-open');

    }).on('click', '.js-btn-menu', function(e){

        e.preventDefault();

        if( $(this).hasClass('on') ) return;

        $(this).index() === 0 ? menus.removeClass('swiped') : menus.addClass('swiped');
        $(this).addClass('on').siblings().removeClass('on');

    });
}
