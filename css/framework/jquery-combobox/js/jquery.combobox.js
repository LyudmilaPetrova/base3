
(function( $ ) {
	$.widget( "ui.combobox", {
		options: {
			allowCustomValue: false,
			customName: null,
			allowEmpty: true,
			editable: true,
			emptyText: null
		},

		_create: function() {
			var input,
				self = this,
				select = this.element.hide(),
				selected = select.children( ":selected" ),
				emptyText = this.options.emptyText === null ? select.find('[value=""]').text() : this.options.emptyText,
				value = selected.text() !== emptyText ? selected.text() : '',
				wrapper = $( "<span>" )
					.addClass( "ui-combobox" )
					.addClass(this.element.attr('class'))
					.insertAfter( select),
				selectedValue = null,
				validValue = select.val(),
				validValueText = value,
				options = this.options;

			input = $( "<input>" )
				.appendTo( wrapper )
				.val( value )
				.addClass( "ui-state-default" )
//				.attr('placeholder', emptyText)
				.placeholder(emptyText)
				.autocomplete({
					delay: 0,
					minLength: 0,
					position: {
						offset: '0 2'
					},
					source: function( request, response ) {
						var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
						response( select.children( "option" ).map(function() {
							var text = $( this ).text();
							if ( (this.value || (!options.editable && options.allowEmpty)) && ( !request.term || matcher.test(text) ) && !this.disabled && this.value !== 'custom') {
								return {
									label: text.replace(
										new RegExp(
											"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
										), "<strong>$1</strong>" ),
									value: text,
									option: this
								};
							}
						}) );
					},
					select: function( event, ui ) {
						ui.item.option.selected = true;
						self._trigger( "selected", event, {
							item: ui.item.option
						});

						if (ui.item.option.value !==  selectedValue) {
							selectedValue = ui.item.option.value;
							select.val(selectedValue).trigger('change');
						}

						validValue = select.val();
						validValueText = ui.item.option.innerHTML;

						// focusout
						$('<input style="position:fixed;top:0;left:0;" type="text" />').appendTo(document.body).focus().remove();
					},
					change: function( event, ui ) {
						var returnFalse = false;

						if ( !ui.item ) {
							// search item
							var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
								valid = false;

							select.children( "option").not('[value="custom"]').each(function() {
								if ( $( this ).text().match( matcher ) ) {
									select.val($(this).val());
									this.selected = valid = true;
									return false;
								}
							});

							if (!valid) {
								if ($.trim($(this).val()).length > 0) {
									if (options.allowCustomValue) {
										if (select.find('option[value="custom"]').size() == 0)
											select.append('<option value="custom"></option>');
										select.val('custom');
									}
									else {
										// remove invalid value, as it didn't match anything
										$(this).val( validValueText );
										select.val( validValue );
										input.data( "autocomplete" ).term = validValueText;
										returnFalse = true;
									}
								}
								else {
									var option = select.find('option').get(0);
									if (options.allowEmpty || !option) {
										$(this).val( '' );
										select.val( '' );
										input.data( "autocomplete" ).term = '';
									}
									else {
										$(this).val( option.innerHTML );
										select.val( option.value );
										input.data( "autocomplete" ).term = option.innerHTML;
									}
								}
							}
						}
						else {
							select.val(ui.item.option.value);
						}

						validValue = select.val();
						validValueText = input.val();

						if (select.val() !== selectedValue) {
							selectedValue = select.val();
							select.trigger('change');
						}

						if (returnFalse)
							return false;
					}
				})
				.addClass( "ui-widget ui-widget-content ui-corner-left" )
				.on('keypress', function(e) {
					if (e.keyCode === 13) {
						var el = input.autocomplete('widget');
						if (el.is(':visible')) {
							//input.trigger('autocompletechange');
							input.autocomplete('close');
							return false;
						}
					}
				});

			select.data('autocomplete-input', input);

			if (this.options.allowCustomValue) {
				if (this.options.customName)
					input.attr('name', this.options.customName);
				else
					input.attr('name', select.attr('name') + '_value');
			}

			input.data( "autocomplete" )._renderItem = function( ul, item ) {
				return $( "<li></li>" )
					.data( "item.autocomplete", item )
					.append( "<a>" + item.label + "</a>" )
					.appendTo( ul );
			};

			function openMenu() {
				// close if already visible
				if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
					input.autocomplete( "close" );
					return;
				}

				// work around a bug (likely same cause as #5265)
				$( this ).blur();

				// pass empty string as value to search for, displaying all results
				input.autocomplete( "search", "" );
				input.focus();
			}

			if (!this.options.editable) {
				input.attr('readonly', true);
			}

			input.on('click', openMenu);

			$( "<a><i></i></a>" )
				.attr( "tabIndex", -1 )
//				.attr( "title", "Show All Items" )
				.appendTo( wrapper )
				.removeClass( "ui-corner-all" )
				.addClass( "ui-corner-right ui-button-icon btn" )
				.click(openMenu);
		},

		destroy: function() {
			this.wrapper.remove();
			this.element.show();
			$.Widget.prototype.destroy.call( this );
		}
	});
})( jQuery );