var $ = require('jquery');

require('gsap/CSSPlugin');
var TweenLite = require('gsap/TweenLite');

window.requestAnimFrame = require('./requestAnimFrame.js');
var throttle = require('./throttle.js');


module.exports = function(slider){

    if( !slider.length ) return;

    var slides = slider.find('.slide');
    var activeSlide = slider.find('.slide.on'), nonActiveSlides = slider.find('.slide.off');

    slider.on('click', 'a', function(e){
        if( !$(this).parent().hasClass('on') ){
            e.preventDefault();

            TweenLite.to(activeSlide, 0.3, {opacity: 0});
            activeSlide.removeClass('on').css('z-index', 'auto');

            slides.eq($(this).parent().index()).addClass('on').css('z-index', 1);
            activeSlide = slider.find('.slide.on');
            TweenLite.to(activeSlide, 0.3, {opacity: 1});

            slider.css('height', activeSlide.height());

            $(this).parent().addClass('on').siblings().removeClass('on');
        }
    });

    slider.css('height', activeSlide.height());
    slides.css('position', 'absolute');
    activeSlide.css('z-index', 1);
    nonActiveSlides.css('opacity', '0').removeClass('off');

    $(window).on('resize', throttle(function(){
        requestAnimFrame(function(){
            slider.css('height', activeSlide.height());
        });
    }, 60))

}