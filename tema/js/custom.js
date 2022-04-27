//angle up down
$('.collapse').on('show.bs.collapse', function() {
  $(this).parent().find(".fa-angle-down").removeClass("fa-angle-down").addClass("fa-angle-up");
}).on('hide.bs.collapse', function() {
  $(this).parent().find(".fa-angle-up").removeClass("fa-angle-up").addClass("fa-angle-down");
});

//carousel home
var owl = $('#11');
owl.owlCarousel({
    items:2,
    autoplay:true,
    autoplayTimeout: 2200,
    autoplayHoverPause:true,
    loop: true,
    nav: true,
    dots: false
});

//carousel general information
var owl = $('#12');
owl.owlCarousel({
    items:1,
    autoplay:true,
    autoplayTimeout: 2600,
    autoplayHoverPause:true,
    loop: true,
    dots: false,
    nav: true
});

//pagination
var items = $(".list-wrapper .list-item");
    var numItems = items.length;
    var perPage = 1;

    items.slice(perPage).hide();

    $('#pagination-container').pagination({
        items: numItems,
        itemsOnPage: perPage,
        prevText: "&laquo;",
        nextText: "&raquo;",
        onPageClick: function (pageNumber) {
            var showFrom = perPage * (pageNumber - 1);
            var showTo = showFrom + perPage;
            items.hide().slice(showFrom, showTo).show();
        }
    });
//accordion
$('.collapse').on('shown.bs.collapse', function(e) {
    var $panel = $(this).closest('.card').prev();
    $('html,body').animate({
  scrollTop: $panel.offset().top
    });
  });

 $(window).resize(function(){
     var w = $(window).width()
     if(w < 768){
        $('.collapse').on('shown.bs.collapse', function(e) {
            var $panel = $(this).closest('.card');
            $('html,body').animate({
          scrollTop: $panel.offset().top
            });
          });
     }
 })

 
