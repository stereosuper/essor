var $ = require('jquery');

window.requestAnimFrame = require('./requestAnimFrame.js');
var throttle = require('./throttle.js');


module.exports = function(body, header, blockSticky, dropdownsSticky, minimumWidth){
    if( !blockSticky.length ) return;
    
    
    var scrollTop, windowWidth = window.outerWidth;
    var belowWidth = minimumWidth && windowWidth <= minimumWidth ? true : false;
    var dropdownsTop = dropdownsSticky.offset().top;
    var posTop = windowWidth > 1200 ? dropdownsTop - 72 : dropdownsTop - 57;
    

    function headerStuck(){
        scrollTop >= posTop ? header.addClass('off').css({'top': posTop}) : header.removeClass('off').css({'top': ''});
    }

    function stickyInterval(){
        if( scrollTop >= blockSticky.data('initialPos') - 95 ){
            if( scrollTop > posTop ){
                if( scrollTop > posTop + 70 ){
                    blockSticky.css({'position': 'fixed', 'top': '25px', 'margin-top': ''});
                }else{
                    blockSticky.css({'position': '', 'top': '', 'margin-top': blockSticky.height() - 46+'px'});
                }
            }else{
                blockSticky.css({'position': 'fixed', 'top': '95px', 'margin-top': ''});
            }
        }
        
        if( scrollTop < blockSticky.data('initialPos') - 85 || belowWidth ){
            blockSticky.css({'position': '', 'top': '', 'margin-top': ''});
        }
    }


    blockSticky.data({'initialPos': blockSticky.offset().top});
    console.log(posTop);


    $(document).on('scroll', throttle(function(){
        
        requestAnimFrame(function(){
            scrollTop = $(document).scrollTop();

            headerStuck();
            stickyInterval();
        });

    }, 10));

    $(window).on('resize', throttle(function(){
        
        requestAnimFrame(function(){
            windowWidth = window.outerWidth;
            belowWidth = minimumWidth && windowWidth <= minimumWidth ? true : false;
            posTop = windowWidth > 1200 ? dropdownsTop - 72 : dropdownsTop - 57;
        });

    }, 10));
}
