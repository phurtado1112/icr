!function ($) {

  $(function(){

	// tooltip
    $('.block_head').tooltip({
      selector: "a[rel=tooltip]"
    });
  
	// tooltip
    $('.block_content').tooltip({
      selector: "a[rel=tooltip2]",
	  placement: 'left'
    });

    // popover
    $("a[rel=popover]")
      .popover()
      .click(function(e) {
        e.preventDefault();
      });
  });

// Modified from the original jsonpi https://github.com/benvinegar/jquery-jsonpi
$.ajaxTransport('jsonpi', function(opts, originalOptions, jqXHR) {
  var url = opts.url;

  return {
    send: function(_, completeCallback) {
      var name = 'jQuery_iframe_' + jQuery.now()
        , iframe, form;

      iframe = $('<iframe>')
        .attr('name', name)
        .appendTo('head');

      form = $('<form>')
        .attr('method', opts.type) // GET or POST
        .attr('action', url)
        .attr('target', name);

      $.each(opts.params, function(k, v) {

        $('<input>')
          .attr('type', 'hidden')
          .attr('name', k)
          .attr('value', typeof v === 'string' ? v : JSON.stringify(v))
          .appendTo(form);
      });

      form.appendTo('body').submit();
    }
  };
});

}(window.jQuery);