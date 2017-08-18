'use strict';

var $ = require('jquery');
var ScrollReveal = require('scrollreveal');

// require('gsap');
// require('gsap/CSSPlugin');
// require('gsap/ScrollToPlugin');
// var TweenLite = require('gsap/TweenLite');


$(function(){

    window.requestAnimFrame = require('./requestAnimFrame.js');
    var throttle = require('./throttle.js');

    var animSearchform = require('./animSearchform.js');
    var animResponsiveHeader = require('./animResponsiveHeader.js');
    var headerStuck = require('./headerStuck.js');
    var customDropdown = require('./dropdown.js');
    var loadMorePosts = require('./loadMorePosts.js');
    var initScrollReval = require('./initScrollReveal.js');
    var sticky = require('./sticky.js');

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
    animResponsiveHeader(body, $('#mainNav'), $('#menus'), $('#main'));
    
    // Handle header pushed by filters
    headerStuck(body, $('.header'), 460, 'page-template-offres');

    // Open and close custom dropdowns
    customDropdown(dropdowns);

    // Load more posts
    loadMorePosts(wp, $('#ajax-content'));

    // ScrollReveal
    window.sr = ScrollReveal();
    //window.scrollReveal = new ScrollReveal({ reset: true, scale: 1, distance: '30px', duration: 800, viewFactor: 0.5 });
    initScrollReval('.isAnimated');

    // Sticky
    sticky($('#blockSticky'), 130, {
        minimumWidth: 960
    });
    sticky($('#blockStickyJobs'), 25, {
        minimumWidth: 960
    });
    sticky($('#dropdownsSticky'), 0, {
        minimumWidth: 960
    });

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
