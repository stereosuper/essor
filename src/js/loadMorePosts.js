var $ = require('jquery');

require('gsap/CSSPlugin');
var TweenLite = require('gsap/TweenLite');


module.exports = function(wp, container){
    if( !container.length ) return;

    var postType = wp.postType;
    var postMaxNb = wp.postNb;
    var loadBtn, loadBtnLi, postNb;

    if( !postType || !postMaxNb ) return;

    // the number of posts per page
    postNb = postType === 'post' ? 7 : 1;
    
    if( postNb > postMaxNb ) return;

    // Insert the "More Posts" link.
    container.append( '<li class="load-more isAnimated"><button id="load-more"><span class="txt-more"><span id="text-more">Charger la suite</span><svg class="icon"><use xlink:href="#icon-arrow-bottom"></use></svg></span></button></li>' );

    loadBtn = $('#load-more');
    loadBtnLi = loadBtn.parent();

    loadBtn.on('click', function(e){
        e.preventDefault();

        $(this).find('#text-more').text('Chargement...');

        $.ajax({
            type: 'POST',
            url: wp.adminAjax,
            data: {
                'action' : 'essor_load_more',
                'postType': postType,
                'offset': postNb
            },
            dataType: 'html',
            success: function(data){
                loadBtnLi.before(data);

                postNb += postNb;

                if( postNb < postMaxNb ){
                    loadBtn.find('#text-more').text('Charger la suite');
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