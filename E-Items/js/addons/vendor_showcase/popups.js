(function (_, $) {
  $.ceEvent('on', 'ce.commoninit', function (context) {

    $('.vendor-showcase:not(.cm-dialog-opener)', context).on('click', function () {
      $('.vendor-showcase.vs-popup').toggleClass('open');
    });

  });

  $(document).on('keydown', function (e) {
    if (e.key === 'Escape') {
      $('.vendor-showcase.vs-popup').removeClass('open');
    }
  })

  $(document).on('click', function (e) {
    if (!$(e.target).closest('.vendor-showcase').length > 0) {
      $('.vendor-showcase.vs-popup').removeClass('open');
    }
  })

}(Tygh, Tygh.$));