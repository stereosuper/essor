var $ = require('jquery');

require('gsap/CSSPlugin');
var TweenLite = require('gsap/TweenLite');


module.exports = function(slider){

    if( !slider.length ) return;

    var slides = slider.find('.slide'), nonActiveSlides = slider.find('.slide.off');

    slider.on('click', 'a', function(e){
        if( !$(this).parent().hasClass('on') ){
            e.preventDefault();
            
            //TweenLite.to(slider.find('.slide.on'), 0.3, {});
            slider.find('.slide.on').removeClass('on');
            slides.eq($(this).parent().index()).addClass('on');

            $(this).parent().addClass('on').siblings().removeClass('on');
        }
    });

    TweenLite.set(nonActiveSlides, {display: 'none'});
    nonActiveSlides.removeClass('off');

}