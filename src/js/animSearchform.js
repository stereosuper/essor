var $ = require('jquery');

module.exports = function(form){
    if( !form.length ) return;

    var eltsToHide = $('.js-form-off');

    form.on('submit', function(e){

        e.preventDefault();

        if( !$(this).hasClass('on') ){

            $(this).children('input').focus();
            eltsToHide.addClass('off');
            $(this).addClass('on');

        }else if( $(this).children('input').val() !== '' ){

            $(this)[0].submit();

        }

    }).on('focusout', 'input', function(){

        eltsToHide.removeClass('off');
        $(this).parent().removeClass('on');

    });
}