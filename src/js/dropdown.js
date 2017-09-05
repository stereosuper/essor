var $ = require('jquery');

module.exports = function(dropdowns){
    if( !dropdowns.length ) return;

    dropdowns.on('click', '.dropdown-title', function(e){
        e.preventDefault();
        e.stopPropagation();
        $(this).parent().toggleClass('isOpen').siblings().find('.dropdown-title').removeClass('isOpen');
    }).on('click', '.active', function(e){
        e.preventDefault();
    });

    $('html').on('click', function(){
        dropdowns.removeClass('isOpen');
    });
    
}
