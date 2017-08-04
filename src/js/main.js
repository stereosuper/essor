'use strict';

var $ = require('jquery');

// require('gsap');
// require('gsap/CSSPlugin');
// require('gsap/ScrollToPlugin');
// var TweenLite = require('gsap/TweenLite');


$(function(){

    window.requestAnimFrame = require('./requestAnimFrame.js');
    var throttle = require('./throttle.js');

    var animSearchform = require('./animSearchform.js');
    var animResponsiveHeader = require('./animResponsiveHeader.js');
    var customDropdown = require('./dropdown.js');
    var loadMorePosts = require('./loadMorePosts.js');

    var body = $('body');
    var windowWidth = window.outerWidth, windowHeight = $(window).height();
    var scrollTop;
    var dropdowns = $('.dropdown');

    

    // isMobile.any ? body.addClass('is-mobile') : body.addClass('is-desktop');

    function resizeHandler(){
        windowWidth = window.outerWidth;
        windowHeight = $(window).height();
    }

    // Open and close header searchform
    animSearchform( $('#formSearch') );

    // Handle responsive header: burger menus + menus to swipe
    animResponsiveHeader( body, $('#mainNav'), $('#menus'), $('#main') );

    // Open and close custom dropdowns
    customDropdown(dropdowns);

    // Load more posts
    loadMorePosts(wp, $('#ajax-content'));


    $(window).on('resize', throttle(function(){
        requestAnimFrame(resizeHandler);
    }, 60)).on('load', function(){

    });


    $(document).on('scroll', throttle(function(){
        scrollTop = $(document).scrollTop();
        
        // Add a class to header when page is scrolled
        scrollTop > 100 ? $('.header').addClass('on') : $('.header').removeClass('on');
    }, 60));

});
