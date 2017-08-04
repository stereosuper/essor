var $ = require('jquery');

module.exports = function(dropdowns){
    if( !dropdowns.length ) return;
    var dropdownButton;

    dropdowns.each(function(index){
        dropdownButton = $(this).find('.dropdown-title');
        dropdownButton.on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            $('.dropdown-title').not(this).parents('.dropdown').removeClass('isOpen');
            $(this).parents('.dropdown').toggleClass('isOpen');
        });
        $('html').click(function() {
            dropdowns.removeClass('isOpen');
        });
    });
    
}
