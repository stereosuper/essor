var $ = require('jquery');

require('gsap/CSSPlugin');
require('gsap/ScrollToPlugin');
var TweenLite = require('gsap/TweenLite');

//var Hammer = require('hammerjs');


module.exports = function(body, nav, menus, pageWrapper){
    if( !nav.length ) return;

    var scrollTop;
    //var btnMenus = $('.js-btn-menu');

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

        // if( $('#secondMenu').find('.current-menu-item').length || $('#secondMenu').find('.current_page_parent').length ){
        //     menus.delay(300).queue(function(){ $(this).addClass('swiped').dequeue(); });
        //     btnMenus.eq(1).addClass('on');
        // }else{
        //     btnMenus.eq(0).addClass('on');
        // }

        $(this).toggleClass('on');

    }).on('click', '#main.menu-open', function(){

        nav.removeClass('on');
        $('#burger').removeClass('on');
        pageWrapper.removeClass('menu-open');

    })/*.on('click', '.js-btn-menu', function(e){

        e.preventDefault();

        if( $(this).hasClass('on') ) return;

        $(this).index() === 0 ? menus.removeClass('swiped') : menus.addClass('swiped');
        $(this).addClass('on').siblings().removeClass('on');

    })*/;

    // var hammertime = new Hammer(nav.get(0));
    // hammertime.on('swipe', function(e){
    //     if( menus.hasClass('swiped') ){
    //         if( e.direction === 4 ){
    //             menus.removeClass('swiped');
    //             $('.js-btn-menu').eq(0).addClass('on').siblings().removeClass('on');
    //         }
    //     }else{
    //         if( e.direction === 2 ){
    //             menus.addClass('swiped');
    //             $('.js-btn-menu').eq(1).addClass('on').siblings().removeClass('on');
    //         }
    //     }
    // });
}
