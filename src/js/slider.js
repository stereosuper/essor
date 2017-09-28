var $ = require('jquery');

require('gsap/CSSPlugin');
var TweenLite = require('gsap/TweenLite');

window.requestAnimFrame = require('./requestAnimFrame.js');
var throttle = require('./throttle.js');


module.exports = function(slider){

    if( !slider.length ) return;

    var slides = slider.find('.slide');
    var activeSlide = slider.find('.slide.on');

    slider.css('height', activeSlide.height());

    $(window).on('resize', throttle(function(){

        requestAnimFrame(function(){ slider.css('height', activeSlide.find('img').height()); });

    }, 60));


    if( slides.length < 2 ) return;

    var nonActiveSlides = slider.find('.slide.off');
    var sliderNav = slider.find('.slider-nav');
    var timeOut;


    function slide(newActiveSlide, button){
        setSliderTimeout();

        if( !newActiveSlide ){
            newActiveSlide = activeSlide.next('.slide').length ? activeSlide.next('.slide') : slides.eq(0);
        }

        if( !button ){
            button = sliderNav.find('.on').next().length ? sliderNav.find('.on').next() : sliderNav.find('li').eq(0);
        }

        TweenLite.to(activeSlide, 0.3, {opacity: 0});
        activeSlide.removeClass('on').css('z-index', 'auto');

        newActiveSlide.addClass('on').css('z-index', 1);
        activeSlide = slider.find('.slide.on');
        TweenLite.to(activeSlide, 0.3, {opacity: 1});

        // slider.css('height', activeSlide.height());

        button.addClass('on').siblings().removeClass('on');

        TweenLite.fromTo(sliderNav.find('.on').find('.indicator'), 8, {scaleX: 1}, {scaleX: 0});
    }

    function setSliderTimeout(){
        clearTimeout(timeOut);
        timeOut = setTimeout(slide, 8000);
    }


    slides.css('position', 'absolute');
    activeSlide.css('z-index', 1);
    nonActiveSlides.css('opacity', '0').removeClass('off');

    TweenLite.fromTo(sliderNav.find('.on').find('.indicator'), 8, {scaleX: 1}, {scaleX: 0});
    setSliderTimeout();


    sliderNav.on('click', '.slider-btn', function(e){

        if( !$(this).parent().hasClass('on') ){
            e.preventDefault();
            slide(slides.eq($(this).parent().index()), $(this).parent());
        }

    });

    slides.on('mouseenter', function(){
        clearTimeout(timeOut);
        TweenLite.to(sliderNav.find('.on').find('.indicator'), 0.2, {scaleX: 1});
    }).on('mouseleave', function(){
        TweenLite.fromTo(sliderNav.find('.on').find('.indicator'), 8, {scaleX: 1}, {scaleX: 0});
        setSliderTimeout();
    });

    $(window).on('focusout', function(){
        clearTimeout(timeOut);
    }).on('focusin', setSliderTimeout);

}