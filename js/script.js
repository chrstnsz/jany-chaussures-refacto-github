$(function() {   

  $(".danger").on("click", function () {
    $(".danger").fadeOut();
  });
  $(".success").on("click", function () {
    $(".success").fadeOut();
  });
  
  //hide flash message
  $('#log_notif').delay(3000).fadeOut(300);

  $('.pagination a').click(function () {
    $('.pagination a.active').removeClass('active');
    $(this).find("a").addClass('active');
  });

  if ($('#to-Top').length) {
    var scrollTrigger = 100, // px
      backToTop = function () {
        var scrollTop = $(window).scrollTop();
        if (scrollTop > scrollTrigger) {
          $('#to-Top').addClass('show');
        } else {
          $('#to-Top').removeClass('show');
        }
      };
    backToTop();
    $(window).on('scroll', function () {
      backToTop();
    });
    $('#to-Top').on('click', function (e) {
      e.preventDefault();
      $('html,body').animate({
        scrollTop: 0
      }, 10);
    });
  }

  $('#js-nav-toggle').click(function () {
    $('#js-menu').slideToggle('medium', function(){
      if ($(this).is(':visible'))
        $(this).css('display', 'flex');
    });
  });

  $('#js-nav-toggle').on('click', function () {
    this.classList.toggle('switch');
  });

  $('.js-click').on("click", function(){
    // Get the expanded image
    var src = $(this).attr('src');

    $('#expandedImg').attr('src', src);
    $('#expandedImg').show();
  });
 
});
