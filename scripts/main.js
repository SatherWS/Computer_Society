(function($) {
    "use strict";  

  $(window).on('load', function() {
    function close_toggle() {
        if ($(window).width() <= 768) {
            $('.navbar-collapse a').on('click', function () {
                $('.navbar-collapse').collapse('hide');
            });
        }
        else {
            $('.navbar .navbar-inverse a').off('click');
        }
        }
        close_toggle();
        $(window).resize(close_toggle);
  });    
}(jQuery));