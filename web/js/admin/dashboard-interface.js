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
			if($(this).data('is-dashboard-widget')) {
				return;
			}
			$(this).data('is-dashboard-widget', true)
			
			var thisWidgetSettings = _this.getWidgetSettings(this.id);
			if (thisWidgetSettings.removable) {
				$('<a href="#" class="remove">CLOSE</a>').mousedown(function (e) {
					e.stopPropagation();	
				}).click(function () {
					var widget = $(this).parents(settings.widgetSelector);
					widget.triggerHandler('db-removing');
					return false;
				}).appendTo($(settings.handleSelector, this));
			}
			
			if (thisWidgetSettings.editable) {
				$('<a href="#" class="edit">EDIT</a>').mousedown(function (e) {
					e.stopPropagation();	
				}).toggle(function () {
					$(this).css({backgroundPosition: '-66px 0', width: '55px'})
						.parents(settings.widgetSelector)
							.find('.dashboard-edit-box').show().find('input').focus();
					return false;
				}, function () {
					var widget = $(this).css({backgroundPosition: '', width: ''}).parents(settings.widgetSelector);
					widget.find('.dashboard-edit-box').hide();
					widget.triggerHandler('db-configured');
					return false;
				}).appendTo($(settings.handleSelector,this));
				$('<div class="dashboard-edit-box" style="display:none;"/>')
					.append('<ul><li class="item"><label>Change the title?</label><input value="' + $('h3',this).text() + '"/></li>')
					.append((function(){
						var colorList = '<li class="item"><label>Available colors:</label><ul class="colors">';
						$(thisWidgetSettings.colors).each(function () {
							colorList += '<li style="background-color: ' + this + ';"/>';
						});
						return colorList + '</ul>';
					})())
					.append('</ul>')
					.insertAfter($(settings.handleSelector,this));
			}
			
			if (thisWidgetSettings.collapsible) {
				$('<a href="#" class="collapse">COLLAPSE</a>').mousedown(function (e) {
					e.stopPropagation();	
				}).toggle(function () {
					var widget = $(this).css({backgroundPosition: '-38px 0'}).parents(settings.widgetSelector);
					widget.find(settings.contentSelector).hide();
					widget.triggerHandler('db-collapsed', true);
					return false;
				},function () {
					var widget = $(this).css({backgroundPosition: ''}).parents(settings.widgetSelector);
					widget.find(settings.contentSelector).show();
					widget.triggerHandler('db-collapsed', false);
					return false;
				}).prependTo($(settings.handleSelector,this));
			}
		});
		
		$('.dashboard-edit-box').each(function () {
			$('input',this).keyup(function () {
				$(this).parents(settings.widgetSelector).find('h3').text( $(this).val().length>20 ? $(this).val().substr(0,20)+'...' : $(this).val() );
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
			$sortableItems = $('> li.'+settings.widgetSelector, settings.columns);
			
		$(settings.widgetSelector,$(settings.columns)).each(function (i) {
			if (!_this.getWidgetSettings(this.id).movable) {
				$sortableItems = $sortableItems.not(this);
			}
		});
		
		$sortableItems.find(settings.handleSelector).css({
			cursor: 'move'
		}).mousedown(function (e) {
			$sortableItems.css({width:''});
			$(this).parent().css({
				width: $(this).parent().width() + 'px'
			});
		}).mouseup(function () {
			if(!$(this).parent().hasClass('dragging')) {
				$(this).parent().css({width:''});
			} else {
				$(settings.columns).sortable('disable');
			}
		});

		$(settings.columns).sortable({
			items: $sortableItems,
			connectWith: $(settings.columns),
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
			opacity: 0.8,
			containment: 'document',
			start: function (e,ui) {
				$(ui.helper).addClass('dragging');
			},
			stop: function (e,ui) {
				$(ui.item).css({width:''}).removeClass('dragging');
				$(settings.columns).sortable('enable');
			}
		});
	}
};
})(jQuery);