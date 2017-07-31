'use strict';

var $ = require('jquery-slim');

// require('gsap');
require('gsap/CSSPlugin');
require('gsap/ScrollToPlugin');
var TweenLite = require('gsap/TweenLite');


$(function(){

    window.requestAnimFrame = require('./requestAnimFrame.js');
    var throttle = require('./throttle.js');

    var body = $('body');
    // window.outerWidth returns the window width including the scroll, but it's not working with $(window).outerWidth
    var windowWidth = window.outerWidth, windowHeight = $(window).height();
    var scrollTop;



    // isMobile.any ? body.addClass('is-mobile') : body.addClass('is-desktop');

    function resizeHandler(){
        windowWidth = window.outerWidth;
        windowHeight = $(window).height();
    }


    $('#formSearch').on('submit', function(e){
        
        e.preventDefault();

        if( !$(this).hasClass('on') ){
            
            $(this).children('input').focus();
            $('.js-form-off').addClass('off');
            $(this).addClass('on');
        
        }else if( $(this).children('input').val() !== '' ){
            
            $(this)[0].submit();
        
        }

    }).on('focusout', 'input', function(){
        
        $('.js-form-off').removeClass('off');
        $(this).parent().removeClass('on');

    });

    body.on('click', '#burger', function(e){
        e.preventDefault();

        scrollTop = $(document).scrollTop();

        if( $('#mainNav').hasClass('on') ){
            $('#mainNav').removeClass('on');
            $('#main').removeClass('menu-open');
        }else{
            if( scrollTop === 0 ){
                $('#mainNav').addClass('on');
                $('#main').addClass('menu-open');
            }else{
                TweenLite.to(window, 0.5, {scrollTo: 0, onComplete: function(){
                    $('#mainNav').addClass('on');
                    $('#main').addClass('menu-open');
                }});
            }
        }

        $(this).toggleClass('on');
    }).on('click', '#main.menu-open', function(){
        
        $('#mainNav').removeClass('on');
        $('#main').removeClass('menu-open');
        
    });

    body.on('click', '.js-btn-menu', function(e){
        e.preventDefault();

        if( $(this).hasClass('on') ) return;

        $(this).index() === 0 ? $('#menus').removeClass('swiped') : $('#menus').addClass('swiped');

        $(this).addClass('on').siblings().removeClass('on');
    });


    $(window).on('resize', throttle(function(){
        requestAnimFrame(resizeHandler);
    }, 60)).on('load', function(){

    });


    $(document).on('scroll', throttle(function(){
        scrollTop = $(document).scrollTop();
        
        scrollTop > 100 ? $('.header').addClass('on') : $('.header').removeClass('on');

    }, 60));

});
