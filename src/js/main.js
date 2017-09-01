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
    var customDropdown = require('./dropdown.js');
    var loadMorePosts = require('./loadMorePosts.js');
    var initScrollReval = require('./initScrollReveal.js');
    var sticky = require('./sticky.js');
    var implantations = require('./map.js');
    var jobsSticky = require('./jobsSticky.js');
    var setSlider = require('./slider.js');
    $.fn.annotatedImage = require('./annotedImages.js');

    var body = $('body');
    var dropdowns = $('.dropdown');
    var dropdownsSticky = $('#dropdownsSticky');
    var header = $('#header');
    var windowWidth = window.outerWidth, windowHeight = $(window).height();
    var scrollTop;



    // isMobile.any ? body.addClass('is-mobile') : body.addClass('is-desktop');

    function resizeHandler(){
        windowWidth = window.outerWidth;
        windowHeight = $(window).height();
    }

    function loadHandler(){
        // Sticky
        sticky($('#blockSticky'), 130, {minimumWidth: 960});
        sticky(dropdownsSticky, 0, {minimumWidth: 960});

        // Handle header pushed by filters
        jobsSticky(body, header, $('#blockStickyJobs'), dropdownsSticky, 960);

        // Slider
        setSlider( $('#slider') );

        // Annoted images
        $('.annotated-image').annotatedImage();

        // Load more posts
        loadMorePosts(wp, $('#ajax-content'));
    }

    // Open and close header searchform
    animSearchform( $('#formSearch') );

    // Handle responsive header: burger menus + menus to swipe
    animResponsiveHeader(body, $('#mainNav'), $('#menus'), $('#main'));

    // Open and close custom dropdowns
    customDropdown(dropdowns);

    // ScrollReveal
    window.sr = ScrollReveal();
    //window.scrollReveal = new ScrollReveal({ reset: true, scale: 1, distance: '30px', duration: 800, viewFactor: 0.5 });
    initScrollReval('.isAnimated');

    // Charge la map
    implantations();

    // Header menu main
    header.on('click', '.btn-menu-main', function(){
        $(this).toggleClass('on');
    });

    // Since script is loaded asynchronously, load event isn't always fired !!!
    document.readyState === 'complete' ? loadHandler() : $(window).on('load', loadHandler);

    $(window).on('resize', throttle(function(){
        requestAnimFrame(resizeHandler);
    }, 60));


    $(document).on('scroll', throttle(function(){
        scrollTop = $(document).scrollTop();

        // Add a class to header when page is scrolled
        if( windowWidth > 768 ){
            scrollTop > 100 ? header.addClass('on') : header.removeClass('on');
        }else if( header.hasClass('on') ){
            header.removeClass('on');
        }
    }, 60));

});
