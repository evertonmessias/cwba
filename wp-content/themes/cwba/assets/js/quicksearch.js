function debounce(func, wait, immediate) {
    var timeout;
  
    return function executedFunction() {
      var context = this;
      var args = arguments;
          
      var later = function() {
        timeout = null;
        if (!immediate) func.apply(context, args);
      };
  
      var callNow = immediate && !timeout;
      
      clearTimeout(timeout);
  
      timeout = setTimeout(later, wait);
      
      if (callNow) func.apply(context, args);
    };
  };

(function ($) {

    // quick search regex
    var qsRegex;

    // init Isotope
    var $grid = $('.grid-aulas').isotope({
        itemSelector: '.aulas-item',
        layoutMode: 'fitRows',        
        stagger: 10,
        hiddenStyle: {
            opacity: 0
        },
        visibleStyle: {
            opacity: 1
        },
        filter: function () {
            return qsRegex ? $(this).text().match(qsRegex) : true;
        }
    });

    // use value of search field to filter
    var $quicksearch = $('.quicksearch').keyup(debounce(function () {
        qsRegex = new RegExp($quicksearch.val(), 'gi');
        $grid.isotope();
        $('html, body').animate({
            scrollTop: $('#grid-aulas').offset().top - 170
        }, 300);
    }, 200));

    // debounce so filtering doesn't happen every millisecond
    function debounce(fn, threshold) {
        var timeout;
        threshold = threshold || 100;
        return function debounced() {
            clearTimeout(timeout);
            var args = arguments;
            var _this = this;
            function delayed() {
                fn.apply(_this, args);
            }
            timeout = setTimeout(delayed, threshold);
        };
    }

})(jQuery);