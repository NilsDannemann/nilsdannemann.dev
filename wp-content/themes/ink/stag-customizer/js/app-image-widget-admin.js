jQuery(document).ready(function($){

	imageWidget = {

		// Call this from the upload button to initiate the upload frame.
		uploader : function( widget_id, widget_id_string, key ) {

			var frame = wp.media({
				title : 'Choose an Image',
				multiple : false,
				library : { type : 'image' },
				button : { text : 'Use Image' }
			});

			// Handle results from media manager.
			frame.on('close',function( ) {
				var attachments = frame.state().get('selection').toJSON();
				imageWidget.render( widget_id, widget_id_string, attachments[0], key );
				$("#" + widget_id_string + key).trigger('change');
			});

			frame.open();
			return false;
		},

		remove : function( widget_id, widget_id_string, key ) {
			$("#" + widget_id_string + 'preview').html('');
			$("#" + widget_id_string + key).val('');
			$("#" + widget_id_string + 'remove').css('display', 'none');
			$("#" + widget_id_string + key).trigger('change');
		},

		// Output Image preview and populate widget form.
		render : function( widget_id, widget_id_string, attachment, key ) {
			$("#" + widget_id_string + 'preview').html(imageWidget.imgHTML( attachment ));
			$("#" + widget_id_string + key).val(attachment.url);
			$("#" + widget_id_string + 'remove').css('display', 'inline-block');
		},

		// Render html for the image.
		imgHTML : function( attachment ) {
			var img_html = '<img src="' + attachment.url + '" alt="" />';
			return img_html;
		}

	};

});
