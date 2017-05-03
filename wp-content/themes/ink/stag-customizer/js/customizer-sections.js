/* global jQuery, chosenOptions */

( function( $ ) {
	/**
	 * Font Choices
	 */
	fontChoices = {
		cache: {},

		init: function() {
			fontChoices.cache.options = {};
			$.each(chosenOptions.fontOptions, function(index, key) {
				fontChoices.cache.options[key] = $('select', '#customize-control-' + key);
			});

			// Insert
			fontChoices.insertChoices();
		},

		// Insert the HTML into each font family select
		insertChoices: function() {
			$.each(fontChoices.cache.options, function(key, element) {
				element.chosen({
					no_results_text          : chosenOptions.chosen_no_results_fonts,
					search_contains          : true,
					width                    : '100%'
				});
			});
		}
	};

	// Load font choices after Customizer initialization is complete.
	$(document).ready(function() {
		fontChoices.init();
	});

} )( jQuery );
