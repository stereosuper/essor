var $ = require('jquery');

require('gsap/CSSPlugin');
var TweenLite = require('gsap/TweenLite');


module.exports = function(wp, container){
    if( !container.length ) return;

    var pageNum = parseInt(wp.startPage) + 1;
    var max = parseInt(wp.maxPages);
    var nextLink = wp.nextLink;
    var loadBtn, loadBtnLi;

    if( pageNum > max ) return;

    // Insert the "More Posts" link.
    container.append( '<li class="load-more"><a href="#" id="load-more"><span class="txt-more"><span id="text-more">Charger la suite</span><svg class="icon"><use xlink:href="#icon-arrow-bottom"></use></svg></span></a></li>' );

    loadBtn = $('#load-more');
    loadBtnLi = loadBtn.parent();

    loadBtn.on('click', function(e){
        e.preventDefault();

        $(this).find('#text-more').text('Loading posts...');

        $.ajax({
            url: nextLink,
            dataType: 'html',
            success: function(data){
                loadBtnLi.before($(data).find('#ajax-content').find('li'));

                pageNum ++;
                nextLink = nextLink.replace(/\/page\/[0-9]?/, '/page/'+ pageNum);

                if( pageNum < max ){
                    loadBtn.attr('href', nextLink).find('#text-more').text('Charger la suite');
                }else{
                    TweenLite.to(loadBtnLi, 0.3, {opacity: 0, onComplete: function(){
                        loadBtn.remove();
                    }});
                }

            },
            error: function(req, status, err){
                console.log(err);
            }
        });
    });
}