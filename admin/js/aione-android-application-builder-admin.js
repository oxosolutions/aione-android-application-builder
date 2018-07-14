(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	
	$(document).ready(function() {

			/* user clicks button on custom field, runs below code that opens new window */
			$('#upload_image').click(function() {
			
			tb_show('Upload a Image', 'media-upload.php?referer=media_page&type=image&TB_iframe=true&post_id=0', false);
			return false;
		});
		
		window.send_to_editor = function(html) {
			var image_url = $('img', html).attr('src');
			//console.log(image_url);
			$('#image_path').val(image_url);
			tb_remove(); // calls the tb_remove() of the Thickbox plugin
			//$('#submit_button').trigger('click');
		}

	});


})( jQuery );
