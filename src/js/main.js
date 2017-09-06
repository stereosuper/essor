'use strict';

var $ = require('jquery');
var ScrollReveal = require('scrollreveal');

var throttle = require('./throttle.js');
window.requestAnimFrame = require('./requestAnimFrame.js');


$(function(){

    window.requestAnimFrame = require('./requestAnimFrame.js');
    var throttle = require('./throttle.js');

    var animHeader = require('./animHeader.js');
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
    var blocTitle = $('#blocTitle');
    var annotatedImages = $('.annotated-image');
    
    var scrollTop;


    function loadHandler(){
        // Sticky
        sticky($('#blockSticky'), 130, {minimumWidth: 960});
        sticky(dropdownsSticky, 0, {minimumWidth: 960});

        // Handle header pushed by filters
        jobsSticky(body, header, $('#blockStickyJobs'), dropdownsSticky, 960);

        // Slider
        setSlider( $('#slider') );

        // Annoted images
        annotatedImages.annotatedImage();

        // Load more posts
        loadMorePosts(wp, $('#ajax-content'));
    }

    
    if(!(window.ActiveXObject) && "ActiveXObject" in window) body.addClass('ie11');

    // Anim header
    animHeader(header);

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

    // Annotated images bloc title
    annotatedImages.on('mouseleave', function(){
        blocTitle.removeClass('off');
    });


    // Since script is loaded asynchronously, load event isn't always fired !!!
    document.readyState === 'complete' ? loadHandler() : $(window).on('load', loadHandler);


    $(document).on('scroll', throttle(function(){
        scrollTop = $(document).scrollTop();

        scrollTop > 20 ? blocTitle.addClass('offScroll') : blocTitle.removeClass('offScroll');
    }, 60));

});
