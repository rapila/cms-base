// jQuery 1.3 compliance
if(!jQuery.noop) {
	jQuery.noop = function() {};
}

//Bind method (heavily used)
Function.prototype.bind = function(context) {
	var __method = this;
	var __arguments = jQuery.makeArray(arguments).slice(arguments.callee.length);
	return function() {
		var args = __arguments.concat(jQuery.makeArray(arguments));
		return __method.apply(context, args);
	};
};

// escapes all selector meta chars
String.prototype.escapeSelector = function() {
	return this.replace(/([#;&,\.+\*~':"!\^\$\[\]\(\)=>|\/])/g, "\\$1");
};

//Option to serializeArrayKV so it can be used for JSON POST requests which are then being treated by PHP as $_REQUEST or $_POST would
jQuery.fn.extend({
	serializeArrayKV: function() {
		var result = {};
		this.map(function() {
			return this.elements ? jQuery.makeArray(this.elements) : this;
		}).each(function() {
			if(!(this.name && !this.disabled && (/select|textarea|input/i).test(this.nodeName))) {
				return;
			}
			
			var val = null;
			if(this.nodeName.toLowerCase() === 'input') {
				if(this.type.toLowerCase() === 'checkbox') {
					val = this.checked ? (this.hasAttribute('value') ? this.value : true) : false;
				} else if(this.type.toLowerCase() === 'radio') {
					val = this.checked ? this.value : null;
				} else {
					val = jQuery(this).val();
				}
			} else {
				val = jQuery(this).val();
			}
			
			if(val === null) {
				return;
			}
			
			if(this.name.match(/\[\]$/)) {
				var name = this.name.substring(0, this.name.length-2);
				if(!jQuery.isArray(result[name])) {
					result[name] = [];
				}
				if(jQuery.isArray(val)) {
					result[name] = result[name].concat(val);
				} else {
					result[name][result[name].length] = val;
				}
			} else {
				result[this.name] = val;
			}
		});
		
		return result;
	}
});

//Widget class
var Widget = function() {
};

jQuery.extend(Widget.prototype, {
	_widgetJSON: function(action, callback, options, attributes) {
		return Widget.widgetJSON(this.widgetType, this, action, callback, options, attributes);
	},
	
	_callMethod: function(name) {
		var args = jQuery.makeArray(arguments).slice(arguments.callee.length);
		var callback = args.pop();
		if(!jQuery.isFunction(callback)) {
			callback !== undefined && args.push(callback);
			callback = Widget.defaultMethodHandler;
		}
		var options = args.pop();
		if(!options || options.constructor !== WidgetJSONOptions) {
			options !== undefined && args.push(options);
			options = new WidgetJSONOptions();
		}
		var params = {};
		if(args.length > 0) {
			params['method_parameters'] = args;
		}
		var result = null;
		var error = null;
		if(options.async) {
			//Make getters and setter synchronous, Char after set or get must be uppercase
			options.async = !((name.indexOf('get') === 0 || name.indexOf('set') === 0) && /[A-Z]/.test(name[3]));
		}
		var widget = this;
		this._widgetJSON(['methodCall', name], function(response, exception) {
			if(callback.length<2 && exception) {
				Widget.notifyUser('alert', exception.message);
			}
			callback.call(widget, response.result, exception);
			result = response.result;
			error = exception;
		}, options, params);
		if(error && !options.async) {
			throw error;
		}
		return result;
	},
	
	fire: function(eventName, realEvent) {
		var event = jQuery.Event("widget."+eventName);
		var has_real_event = (realEvent instanceof jQuery.Event);
		if(has_real_event) {
			event.realTarget = realEvent.target;
		}
		var args = jQuery.makeArray(arguments).slice(has_real_event ? 2 : 1);
		this._pastEvents[eventName] = [event].concat(args);
		jQuery(this).trigger(event, args);
		if(has_real_event) {
			if(event.isDefaultPrevented()) {
				realEvent.preventDefault();
			}
			if(event.isImmediatePropagationStopped()) {
				realEvent.stopImmediatePropagation();
			}
			if(event.isPropagationStopped()) {
				realEvent.stopPropagation();
			}
		}
		return !event.isDefaultPrevented() && !event.isPropagationStopped();
	},
	
	handle: function(event, handler, isOnce, fireIfPast) {
		jQuery.each(event.split(/\s+/), function(i, eventName) {
			if(fireIfPast && this._pastEvents[eventName]) {
				handler.apply(this, this._pastEvents[eventName]);
				if(isOnce) {
					return this;
				}
			}
			jQuery(this)[isOnce ? 'one' : 'bind']("widget."+eventName, handler.bind(this));
		}.bind(this));
		return this;
	},
	
	_pastEvents: {},
	_widgetInformation: {},
	_instanceInformation: {}
});

jQuery.extend(Widget, {
	uuid: function() {
		return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
			var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
			return v.toString(16);
		}).toUpperCase();
	},
	
	loadInfo: function(widgetType) {
		if(!Widget.widgetInformation[widgetType]) {
			var widgetInformation = null;
			Widget.widgetJSON(widgetType, null, 'widgetInformation', function(info, error) {
				widgetInformation = info;
				if(!Widget.types[widgetType]) {
					if(widgetInformation.resources !== '') {
						var resources = jQuery.parseHTML(widgetInformation.resources);
						var head = jQuery('head');
						//Add scripts
						resources.filter('script').each(function() {
							var script = jQuery(this);
							if(!script.attr('src')) {
								head.append(this.cloneNode(true));
							} else if(head.find('script[src="'+script.attr('src')+'"]').length == 0) {
								jQuery.ajax({
									url: script.attr('src'),
									dataType: 'script',
									async: false
								});
							}
						});
						//Add styles
						head.append(resources.find('style'));
						//Add linked elements (mostly CSS)
						resources.filter('link').each(function() {
							if(head.find('link[href="'+this.getAttribute('href')+'"]').length == 0) {
								head.append(this);
							}
						});
					}
					if(!Widget.types[widgetType]){
						Widget.types[widgetType] = {}; //An empty widget type… useful if it only exposes PHP methods
					}
				}
			}, WidgetJSONOptions.with_async(false));
			Widget.widgetInformation[widgetType] = widgetInformation;
		}
		
		//If the widget is not yet a function… (its Constructor not the Function constructor)
		if(Widget.types[widgetType].constructor !== Function) {
			var widgetInformation = Widget.widgetInformation[widgetType];
			//…make Widget.types[widgetType] a function
			var old_type = Widget.types[widgetType]; //must now be defined after including resources
			Widget.types[widgetType] = function(instanceInformation) {
				this._widgetInformation = widgetInformation;
				this._instanceInformation = instanceInformation;
				this.widgetId = instanceInformation.session_id;
				this.widgetType = widgetType;
			};
			//Setting default properties
			Widget.types[widgetType].prototype = new Widget();
			Widget.types[widgetType].prototype.constructor = Widget.types[widgetType];
			//Add PHP methods
			jQuery.each(widgetInformation.methods, function(i, method) {
				Widget.types[widgetType].prototype[method] = function() {
					return this._callMethod.apply(this, [method].concat(jQuery.makeArray(arguments)));
				};
			});
			//Add JS methods (including initialize [which is not the constructor] and prepare)
			jQuery.extend(Widget.types[widgetType].prototype, old_type);
			//Settings must be present
			if(!Widget.types[widgetType].prototype.settings) {
				Widget.types[widgetType].prototype.settings = {};
			}
			//Fix – static – types property
			if(old_type.types) {
				delete Widget.types[widgetType].prototype.types;
				Widget.types[widgetType].types = old_type.types;
			}
		}
		
		return Widget.widgetInformation[widgetType];
	},
	
	create: function(widgetType, finishCallback, session) {
		var intermediateCallback = jQuery.noop;
		if(jQuery.isFunction(session)) {
			//intermediate callback given → shift session
			intermediateCallback = finishCallback;
			finishCallback = session;
			session = arguments[3];
		}
		if(Widget.singletons[widgetType]) {
			if(intermediateCallback) {
				intermediateCallback(Widget.singletons[widgetType]);
			}
			if(finishCallback) {
				finishCallback(Widget.singletons[widgetType]);
			}
			return Widget.singletons[widgetType];
		}
		var widgetInformation = Widget.loadInfo(widgetType)
		Widget.widgetJSON(widgetType, session, 'instanciateWidget', function(instanceInformation, error) {
			if(error) {
				Widget.notifyUser('alert', error.message);
				return;
			}
			var widget = new Widget.types[widgetType](instanceInformation);
			
			//Settings need to be mutable without changing globally
			widget.settings = {};
			jQuery.extend(true, widget.settings, Widget.types[widgetType].prototype.settings);
			
			//past events must not be shared across instances
			widget._pastEvents = {};
			
			if(widgetInformation.is_singleton) {
				Widget.singletons[widgetType] = widget;
			}
			if(intermediateCallback) {
				intermediateCallback(widget)
			}
			if(widget.initialize) {
				widget.initialize();
			}
			if(finishCallback) {
				finishCallback(widget);
			}
			if(widget.prepare) {
				widget.prepare();
			}
			widget.fire('prepared', widget, widgetInformation, instanceInformation);
		}, WidgetJSONOptions.with_async(!widgetInformation.is_singleton));
		if(widgetInformation.is_singleton) {
			return Widget.singletons[widgetType];
		}
	},
	
	createWithElement: function(widgetType, finishCallback, session) {
		var intermediateCallback = jQuery.noop;
		if(jQuery.isFunction(session)) {
			//intermediate callback given → shift session
			intermediateCallback = finishCallback;
			finishCallback = session;
			session = arguments[3];
		}
		Widget.create(widgetType, intermediateCallback, function(widget) {
			widget._element = jQuery.parseHTML(widget._instanceInformation.content);
			widget.fire('element_set', widget._element);
			widget.handle('prepared', function(event, widget) {
				finishCallback(widget);
			}, false);
		}, session);
	},
	
	notifyUser: function(severity, message) {
		alert("Message of severity "+severity+": "+message);
	},
	
	notificationWithIdentifier: function() {
		return null;
	},
	
	tooltip: function(element, text) {
		jQuery(element).bind('mouseenter', alert.bind(window, text));
	},
	
	confirm: function(title, message, callback, cancelButtonText, okButtonText) {
		message = title+' '+message;
		if(cancelButtonText === null) {
			Widget.notifyUser('info', message);
			return callback(true);
		}
		callback(confirm(message));
	},
	
	//Show Ajax loader
	load: jQuery.noop,
	
	//Hide Ajax loader
	end_load: jQuery.noop,
	
	//Show activity indicator
	activity: jQuery.noop,
	
	//Hide activity indicator
	end_activity: jQuery.noop,
	
	widgetJSON: function(widgetType, widgetOrId, action, callback, options) {
		options = options || new WidgetJSONOptions();
		var attributes = arguments[arguments.callee.length] || {};
		if(!jQuery.isArray(action)) {
			action = [action];
		}
		action.unshift('widget_json', widgetType);
		var url = FILE_PREFIX;
		jQuery.each(action, function(i, urlPart) {
			url += '/'+encodeURIComponent(urlPart);
		});
		if(widgetOrId) {
			attributes['session_key'] = widgetOrId.widgetId !== undefined ? widgetOrId.widgetId : widgetOrId;
		}
		var attr_str = attributes;
		if(attributes.constructor !== String) {
			if(options.content_type === 'application/json') {
				attr_str = JSON.stringify(attributes);
			} else if(options.content_type === 'multipart/form-data') {
				if(attributes.constructor !== FormData) {
					attr_str = new FormData();
					jQuery.each(attributes, function(i, val) {
						attr_str.append(i, val);
					});
				}
			} else if(options.content_type === 'application/x-www-form-urlencoded') {
				attr_str = '';
				jQuery.each(attributes, function(i, val) {
					if(jQuery.isArray(val)) {
						jQuery.each(val, function(j, value) {
							attr_str += encodeURIComponent(i+'[]')+'='+encodeURIComponent(value)+'&';
						});
					} else {
						attr_str += encodeURIComponent(i)+'='+encodeURIComponent(val)+'&';
					}
				});
			}
		}
		jQuery.ajax({
			url: url,
			data: attr_str,
			type: 'POST',
			dataType: 'json',
			async: options.async,
			contentType: options.content_type,
			cache: true,
			beforeSend: function(xmlhttprequest) {
				if(options.download_progress_callback) {
					xmlhttprequest.addEventListener('progress', options.download_progress_callback, false);
				}
				if(options.upload_progess_callback) {
					xmlhttprequest.upload.addEventListener('progress', options.upload_progess_callback, false);
				}
				Widget.activity();
			},
			success: function(result) {
				callback = (callback || Widget.defaultJSONHandler);
				var error = null;
				var call_callback = true;
				if(result && result.exception) {
					error = result.exception;
					var exception_handler = Widget.exception_type_handlers[error.exception_type] || Widget.exception_type_handlers.fallback;
					action.shift();
					var call_callback = exception_handler(error, widgetType, widgetOrId, action, callback, options, attributes);
				}
				if(call_callback) {
					callback.call(this, result, error);
				}
			},
			error: function(request, statusCode, error) {
				var error_object = {message: error, exception_type: statusCode};
				if(statusCode === 'parsererror') {
					var text = jQuery.parseHTML(jQuery.trim(request.responseText));
					error_object.message = text;
				}
				var exception_handler = Widget.exception_type_handlers[error.exception_type] || Widget.exception_type_handlers.fallback;
				action.shift();
				if(exception_handler(error, widgetType, widgetOrId, action, callback, options, attributes)) {
					callback.call(this, {}, error_object);
				}
			},
			complete: function() {
				Widget.end_activity();
			}
		});
	},
	
	callStaticWidgetMethod: function(widgetType, methodName) {
		var parameters = jQuery.makeArray(arguments).slice(2);
		if(!Widget.types[widgetType]) {
			Widget.loadInfo(widgetType);
		}
		return Widget.types[widgetType].prototype[methodName].apply(window, parameters);
	},
	
	fire: function(eventName) {
		var event = jQuery.Event("Widget."+eventName);
		var args = jQuery.makeArray(arguments).slice(arguments.callee.length);
		this._pastEvents[eventName] = [event].concat(args);
		jQuery(Widget).triggerHandler(event, args);
	},
	
	handle: function(event, handler, isOnce, fireIfPast) {
		jQuery.each(event.split(/\s+/), function(i, eventName) {
			if(fireIfPast && this._pastEvents[eventName]) {
				handler.apply(this, this._pastEvents[eventName]);
				if(isOnce) {
					return this;
				}
			}
			jQuery(Widget)[isOnce ? 'one' : 'bind']("Widget."+eventName, handler.bind(this));
		}.bind(this));
		return this;
	},
	
	_pastEvents: {},
	
	defaultJSONHandler: jQuery.noop,
	
	defaultMethodHandler: jQuery.noop,
	
	log: jQuery.noop,
	
	types: {},
	singletons: {},
	widgetInformation: {},
	
	//Called when a specific type of Exception is thrown in _widgetJSON. Return true from the function to execute the callback or false to cancel it. The Widget.notifyUser function will not be called either way.
	exception_type_handlers: {
		fallback: function(error, widgetType, widgetOrId, action, callback, options, attributes) {
			if(callback.length<2) {
				Widget.notifyUser('alert', error.message);
			}
			return true;
		},
		
		needs_login: function(error, widgetType, widgetOrId, action, callback, options, attributes) {
			Widget.create('login_window', function(login_widget) {
				login_widget.show();
				Widget.handle('cmos.logged_in', function(event) {
					// Re-try the action
					Widget.widgetJSON(widgetType, widgetOrId, action, callback, options, attributes);
				}, true);
			});
			
			return false;
		},
		
		ValidationException: function(error, widgetType, widgetOrId, action, callback, options, attributes) {
			if(widgetOrId.detail_widget) {
				widgetOrId.detail_widget.validate_with(error.parameters);
				return false;
			}
			return true;
		}
	}
});

if(window.console && window.console.log) {
	Widget.log = function() {
		window.console.log.apply(console, jQuery.makeArray(arguments));
	};
} else {
	Widget.log = function() {
		var args = jQuery.makeArray(arguments);
		args.unshift('info');
		Widget.notifyUser.apply(Widget, args);
	};
}

var WidgetJSONOptions = function(options) {
	jQuery.extend(this, this.options, options || {});
};

jQuery.extend(WidgetJSONOptions.prototype, {
	options: {
		async: true,
		upload_progess_callback: null,
		download_progress_callback: null,
		content_type: 'application/json'
	}
});

jQuery.each(WidgetJSONOptions.prototype.options, function(i, option) {
	WidgetJSONOptions['with_'+i] = function(value) {
		var options = {};
		options[i] = value;
		return new WidgetJSONOptions(options);
	};
});

jQuery.extend(jQuery, {
	widgetElements: function(type) {
		if(type) {
			return jQuery('*[data-widget-type='+type+']');
		} else {
			return jQuery('*[data-widget-type]');
		}
	},
	
	parseHTML: function(html, instanciateWidgets) {
		var element = document.createElement('div');
		element.innerHTML = html;
		var result = jQuery(element.childNodes);
		if(instanciateWidgets) {
			result.find('*[data-widget-type]').each(function() {
				jQuery(this).prepareWidget();
			});
		}
		return result;
	}
});

jQuery.fn.extend({
	prepareWidget: function() {
		if(this.length == 0) {
			return;
		}
		var callback = arguments[0] || jQuery.noop;
		var intermediateCallback = jQuery.noop;
		if(arguments[1]) {
			callback = arguments[1];
			intermediateCallback = arguments[0];
		}
		if(this.data('widget')) {
			callback(this.data('widget'));
			return this;
		}
		var waiting_callbacks = this.data('waiting_prepare_callbacks');
		if(waiting_callbacks) {
			waiting_callbacks.intermediate.push(intermediateCallback);
			waiting_callbacks.ending.push(callback);
			return;
		}
		waiting_callbacks = {intermediate: [intermediateCallback], ending: [callback]};
		this.data('waiting_prepare_callbacks', waiting_callbacks);
		var widget_type = this.attr('data-widget-type');
		var widget_session = this.attr('data-widget-session');
		var widget_element = this;
		Widget.create(widget_type, function(widget) {
			widget_element.data('widget', widget);
			widget._element = widget_element;
			jQuery.each(widget_element.data('waiting_prepare_callbacks').intermediate, function(i, callback) {
				callback(widget);
			});
			widget.handle('prepared', function() {
				jQuery.each(widget_element.data('waiting_prepare_callbacks').ending, function(i, callback) {
					callback(widget);
				});
				widget_element.removeData('waiting_prepare_callbacks');
			});
		}, widget_session);
		return this;
	},
	
	isInDom: function() {
		var doc = document || arguments[0];
		return jQuery(doc).has(this[0]).length > 0;
	}
});

//Initialize all widgets present as html elements on document.ready
jQuery(document).ready(function() {
	jQuery.widgetElements().each(function() {
		jQuery(this).prepareWidget();
	});
});
