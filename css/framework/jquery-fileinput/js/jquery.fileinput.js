/**
 * --------------------------------------------------------------------
 * jQuery customfileinput plugin
 * Author: Scott Jehl, scott@filamentgroup.com
 * Copyright (c) 2009 Filament Group 
 * licensed under MIT (filamentgroup.com/examples/mit-license.txt)
 * --------------------------------------------------------------------
 */
(function($) {
	$.fn.customFileInput = function(text) {
		if ($.browser.msie)
			return this;

		text = text || "Browse";
		return $(this).each(function(){
			//apply events and styles for file input element
			var fileInput = $(this)
				.mousemove(function(e) {
					upload.addClass('hover');
					var offset = uploadButton.offset();

					if (e.pageX >= offset.left && e.pageX <= offset.left + uploadButton.outerWidth()
						&& e.pageY >= offset.top && e.pageY <= offset.top + uploadButton.outerHeight()) {
						uploadButton.addClass('hover');
					}
					else {
						uploadButton.removeClass('hover');
					}
				})
				.mouseout(function() {
					upload.removeClass('hover');
					uploadButton.removeClass('hover');
				})
				.focus(function() {
					upload.addClass('focus');
					fileInput.data('val', fileInput.val());
				})
				.blur(function(){
					upload.removeClass('focus');
					$(this).trigger('checkChange');
				})
				.bind('disable',function(){
					fileInput.attr('disabled',true);
					upload.addClass('disabled');
				})
				.bind('enable',function(){
					fileInput.removeAttr('disabled');
					upload.removeClass('disabled');
				})
				.bind('checkChange', function(){
					if(fileInput.val() && fileInput.val() != fileInput.data('val')){
						fileInput.trigger('change');
					}
				})
				.bind('change',function(){
					//get file name
					var fileName = $(this).val().split(/\\/).pop();
					//get file extension
					var fileExt = 'customfile-ext-' + fileName.split('.').pop().toLowerCase();
					//update the feedback
					uploadFeedback
						.val(fileName) //set feedback text to filename
						.removeClass(uploadFeedback.data('fileExt') || '') //remove any existing file extension class
						.addClass(fileExt) //add file extension class
						.data('fileExt', fileExt) //store file extension for class removal on next change
						.addClass('customfile-feedback-populated'); //add class to show populated state
					//change text of button
					//uploadButton.text('Change');
				})
				.click(function(){ //for IE and Opera, make sure change fires after choosing a file, using an async callback
					fileInput.data('val', fileInput.val());
					setTimeout(function(){
						fileInput.trigger('checkChange');
					},100);
				});

			/*
			 * <div class="input-append input-file clearfix">
					<input type="text" class="input-medium disabled" disabled="disabled" />
					<label for="fileSubmitButton" class="add-on">
					  <button id="fileSubmitButton" class="btn cancel btn-small" type="submit"><?php echo Yii::t('form', 'file.browse_button'); ?></button>
					</label>
				  </div>
			 */

			var id = fileInput.attr('id') + '-input-file';
			//create custom control container
			var upload = $('<div class="input-append input-file clearfix"><label for="' + id + '" class="add-on"></label></div>').addClass(fileInput.attr('class'));
			//create custom control feedback
			var uploadFeedback = $('<input type="text" class="customfile-text-input disabled" disabled="disabled" />').prependTo(upload);
			//create custom control button
			var uploadButton = $('<button id="' + id + '" class="btn cancel btn-small">' + text + '</button>').appendTo(upload.find('label')).click(function() {
				return false;
			});

			// match disabled state
			if(fileInput.is('[disabled]')) {
				fileInput.trigger('disable');
			}

			//on mousemove, keep file input under the cursor to steal click
			upload.mousemove(function(e){
				fileInput.css({
					left: e.pageX - upload.offset().left - fileInput.outerWidth() + 20, //position right side 20px right of cursor X)
					top: e.pageY - upload.offset().top - 3
				});
			}).insertAfter(fileInput); //insert after the input

			upload.insertAfter(fileInput);

			fileInput.attr('class', 'customfile-input').appendTo(upload);

		});
	};
})(jQuery);