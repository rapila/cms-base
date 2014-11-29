/*
 * Script from NETTUTS.com [by James Padolsey]
 * @requires jQuery($), jQuery UI & sortable/draggable UI modules
 */

var Dashboard = (function($) {
	
	return {
	
	jQuery : $,
	
	settings : {
		columns : '.dashboard-column',
		widgetSelector: '.dashboard-widget',
		handleSelector: '.dashboard-widget-head',
		contentSelector: '.dashboard-widget-content',
		widgetDefault : {
			movable: true,
			removable: true,
			collapsible: true,
			editable: true,
			colors : ['#f2bc00', '#dd0000', '#148ea4', '#dfdfdf', '#f66e00', '#8dc100']
		}
	},

	init : function (usedSettings) {
		jQuery.extend(true, this.settings, usedSettings);
		this.addWidgetControls();
		this.makeSortable();
	},
	
	getWidgetSettings : function (id) {
		var $ = this.jQuery,
			settings = this.settings;
		return (id&&settings.widgetIndividual&&settings.widgetIndividual[id]) ? $.extend({},settings.widgetDefault,settings.widgetIndividual[id]) : settings.widgetDefault;
	},
	
	addWidgetControls : function () {
		var _this = this,
			$ = this.jQuery,
			settings = this.settings;

		$(settings.widgetSelector, $(settings.columns)).each(function () {
			var widget = $(this);
			var head = widget.find(settings.handleSelector);

			if(widget.data('isDashboardWidget')) {
				return;
			}
			widget.data('isDashboardWidget', true)

			var thisWidgetSettings = _this.getWidgetSettings(this.id);
			if (thisWidgetSettings.removable) {
				$('<a class="remove rapila-icon">✘</a>').mousedown(function (e) {
					e.stopPropagation();
				}).click(function () {
					var widget = $(this).parents(settings.widgetSelector);
					widget.triggerHandler('db-removing');
					return false;
				}).appendTo(head);
			}

			if (thisWidgetSettings.editable) {
				var widget_edit = $('<a class="edit rapila-icon">edit</a>').mousedown(function (e) {
					e.stopPropagation();
				}).on('click', function toggle() {
					if(toggle.toggled = !toggle.toggled) {
						widget_edit.addClass('active');
						widget.addClass('editing').find('.dashboard-edit-box input').focus();
					} else {
						widget_edit.removeClass('active');
						widget.removeClass('editing');
						widget.triggerHandler('db-configured');
					}
					return false;
				}).appendTo(head);
				$('<div class="dashboard-edit-box" />')
					.append('<ul/>')
					.children('ul')
						.append('<li class="item"><label>'+AdminInterface.translations.dashboardChangeTitle+'</label><input value="' + $('h3',this).text() + '"/></li>')
						.append((function(){
							var colorList = '<li class="item"><label>'+AdminInterface.translations.dashboardAvailableColors+':</label><ul class="colors">';
							$(thisWidgetSettings.colors).each(function () {
								colorList += '<li style="background-color: ' + this + ';"/>';
							});
							return colorList + '</ul>';
						})())
					.end()
					.insertAfter(head);
			}

			if (thisWidgetSettings.collapsible) {
				head.on('dblclick', function toggle() {
					if(!widget.hasClass('collapsed')) {
						widget.addClass('collapsed');
						widget.triggerHandler('db-collapsed', true);
					} else {
						widget.removeClass('collapsed');
						widget.triggerHandler('db-collapsed', false);
					}
					return false;
				});
			}
		});

		$('.dashboard-edit-box').each(function () {
			$('input',this).keyup(function () {
				$(this).parents(settings.widgetSelector).find('h3').text( $(this).val().length>23 ? $(this).val().substr(0,20)+'…' : $(this).val() );
			});
			$('ul.colors li', this).click(function () {
				var currentColor = $(this).css('backgroundColor');
				var rgb = (/rgba?\s*\((\d+),\s*(\d+),\s*(\d+)/).exec(currentColor);
				var r = parseInt(rgb[1], 10), g = parseInt(rgb[2], 10), b = parseInt(rgb[3], 10);
				var brightness = (r*299 + g*587 + b*114) / 1000;
				$(this).parents(settings.widgetSelector).css('backgroundColor', $(this).css('backgroundColor'));
				if(brightness > 125) {
					$(this).parents(settings.widgetSelector).find(settings.handleSelector+' h3').css('color', 'black');
				} else {
					$(this).parents(settings.widgetSelector).find(settings.handleSelector+' h3').css('color', 'white');
				}
				return false;
			});
		});
	},
	
	makeSortable : function () {
		var _this = this,
			$ = this.jQuery,
			settings = this.settings,
			$sortableItems = $('> li'+settings.widgetSelector, settings.columns);

		var columns = $(settings.columns);

		$(settings.widgetSelector, columns).each(function (i) {
			if (!_this.getWidgetSettings(this.id).movable) {
				$sortableItems = $sortableItems.not(this);
			}
		});

		columns.sortable({
			items: $sortableItems,
			cancel: '.editing',
			connectWith: columns,
			update: function(event, ui) {
				if(ui.sender) {
					return;
				}
				var item = jQuery(ui.item);
				var target = item.parent();
				var position = target.children().index(item);
				item.triggerHandler('db-moved', {
					to: target.attr('id'),
					pos: position
				});
			},
			handle: settings.handleSelector,
			placeholder: 'dashboard-widget-placeholder',
			forcePlaceholderSize: true,
			revert: 300,
			delay: 100,
			scroll: false,
			tolerance: 'pointer',
			opacity: 0.8,
			start: function (e,ui) {
				var item = $(ui.item);
				item.css('width', item.width()+'px').addClass('dragging');
			},
			stop: function (e,ui) {
				var item = $(ui.item);
				item.css({width:''}).removeClass('dragging');
			}
		});
	}
};
})(jQuery);