
(function($) {
	var nativePlaceholderSupport = (function(){
		var i = document.createElement('input');
		return ('placeholder' in i);
	})();

    $.fn.placeholder = function(text) {
        text = text || '';
        return this.each(function() {
            var el = $(this);
            
			if (nativePlaceholderSupport) {
				el.attr('placeholder', text);
			}
			else {
				el.focus(function() {
					if (el.val() == text) {
						el.removeClass('placeholder');
						el.val('');
					}
				}).blur(function() {
					if (el.val() == '' || el.val() == text) {
						el.val(text);
						el.addClass('placeholder');
					}
				}).trigger('blur');
				
				el.parents('form').bind('submit', function() {
					if (el.val() == text)
						el.val('');
				});
			}
        });
    };
})(jQuery);