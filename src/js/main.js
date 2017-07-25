'use strict';

var $ = require('jquery-slim');

// require('gsap');
require('gsap/CSSPlugin');
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


    $(window).on('resize', throttle(function(){
        requestAnimFrame(resizeHandler);
    }, 60)).on('load', function(){

    });


    $(document).on('scroll', throttle(function(){
        scrollTop = $(document).scrollTop();
        
        scrollTop > 100 ? $('.header').addClass('on') : $('.header').removeClass('on');

    }, 60));

});
