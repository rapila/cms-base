//Bind method (heavily used)
if(!Function.prototype.bind) {
	Function.prototype.bind = function(context) {
		var __method = this;
		var __arguments = jQuery.makeArray(arguments).slice(arguments.callee.length);
		return function() {
			var args = __arguments.concat(jQuery.makeArray(arguments));
			return __method.apply(context, args);
		};
	};
}

jQuery.ajaxSetup({cache: true});

Function.prototype.deferred = function(list) {
	var d = jQuery.Deferred();
	if(list) {
		list.push(d.promise());
	}
	d.done(this);
	return d;
};

// escapes all selector meta chars
String.prototype.escapeSelector = function() {
	return this.replace(/([#;&,\.+\*~':"!\^\$\[\]\(\)=>|\/])/g, "\\$1");
};

(function() {
	//Widget class
	var Widget = function() {
	};
	
	var EventHook = function(el) {
		if(!el._eventHook) {
			el._eventHook = {
				dflt: {},
				past: {}
			};
		}
		var hook = el._eventHook;
		return {
			init: function(eventName) {
				if(!hook.dflt[eventName]) {
					hook.dflt[eventName] = jQuery.Callbacks('unique stopOnFalse');
				}
				if(!hook.past[eventName]) {
					hook.past[eventName] = jQuery.Callbacks('unique stopOnFalse memory');
				}
			},
			fire: function(eventName, realEvent, args) {
				this.init(eventName);
				var event = jQuery.Event("widget-"+eventName);
				var has_real_event = (realEvent instanceof jQuery.Event);
				if(has_real_event) {
					event.realTarget = realEvent.target;
				}
				args = args.slice(has_real_event ? 2 : 1);

				var type;
				for(type in hook) {
					if(hook.hasOwnProperty(type)) {
						hook[type][eventName].fireWith(el, [event].concat(args));
					}
				}

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
			handle: function(event, originalHandler, isOnce, fireIfPast) {
				jQuery.each(event.split(/\s+/), function(i, eventName) {
					var handler = originalHandler;
					this.init(eventName);
					var hk = (fireIfPast ? hook.past : hook.dflt)[eventName];
					if(isOnce) {
						handler = function() {
							var result = originalHandler.apply(this, jQuery.makeArray(arguments));
							hk.remove(arguments.callee);
							return result;
						};
					}
					hk.add(handler);
				}.bind(this));
				return el;
			}
		};
	};

	jQuery.extend(Widget.prototype, {
		_widgetJSON: function(action, callback, options, attributes) {
			return Widget.widgetJSON(this.widgetType, this, action, callback, options, attributes);
		},
	
		_callMethod: function(name) {
			var args = jQuery.makeArray(arguments).slice(arguments.callee.length);
			var options = args.pop();
			if(!options || options.constructor !== WidgetJSONOptions) {
				options !== undefined && args.push(options);
				options = new WidgetJSONOptions();
			}
			var callback = args.pop();
			if(!callback || (!jQuery.isFunction(callback) && !callback.resolveWith)) {
				callback !== undefined && args.push(callback);
				callback = Widget.defaultMethodHandler;
			}
			var params = {};
			if(args.length > 0) {
				params.method_parameters = args;
			}
			if(options.additional_params) {
				jQuery.extend(params, options.additional_params);
				delete options.additional_params;
			}
			var result = null;
			var error = null;
			if(options.async === null) {
				//Make getters and setter synchronous, Char after set or get must be uppercase
				options.async = !((name.indexOf('get') === 0 || name.indexOf('set') === 0) && (/[A-Z]/).test(name[3]));
			}
			if(options.callback_handles_error === null) {
				options.callback_handles_error = !!callback.resolveWith || callback.length>=2;
			}
			var action = options.action || 'methodCall';
			var widget = this;
			this._widgetJSON([action, name], function(response, exception) {
				if(callback.resolveWith) {
					if(exception) {
						callback.rejectWith(widget, [exception]);
					}
					callback.resolveWith(widget, [response.result]);
				} else {
					callback.call(widget, response.result, exception);
				}
				result = response.result;
				error = exception;
			}, options, params);
			if(error && !options.async) {
				throw error;
			}
			return result;
		},
	
		fire: function(eventName, realEvent) {
			return EventHook(this).fire(eventName, realEvent, jQuery.makeArray(arguments));
		},
	
		handle: function(event, handler, isOnce, fireIfPast) {
			return EventHook(this).handle(event, handler, isOnce, fireIfPast);
		},
	
		_widgetInformation: {},
		_instanceInformation: {},
	
		widgetType: null,
		widgetId: null
	});

	jQuery.extend(Widget, {
		fire: function(eventName, realEvent) {
			return EventHook(this).fire(eventName, realEvent, jQuery.makeArray(arguments));
		},
	
		handle: function(event, handler, isOnce, fireIfPast) {
			return EventHook(this).handle(event, handler, isOnce, fireIfPast);
		},
	
		uuid: function() {
			return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
				var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
				return v.toString(16);
			}).toUpperCase();
		},
	
		loadInfo: function(widgetType) {
			var widgetInformation = null;
			if(!Widget.widgetInformation[widgetType]) {
				Widget.widgetJSON(widgetType, null, 'widgetInformation', function(info) {
					widgetInformation = info;
					if(!Widget.types[widgetType]) {
						if(widgetInformation.resources !== '') {
							var resources = jQuery.parseHTML(widgetInformation.resources);
							Widget.fire('loadInfo-resources', resources);
							var head = jQuery('head');
							//Add scripts
							resources.filter('script').each(function() {
								var script = jQuery(this);
								if(!script.attr('src')) {
									head.append(this.cloneNode(true));
								} else if(head.find('script[src="'+script.attr('src')+'"]').length === 0) {
									head.append(this.cloneNode(true));
								}
							});
							//Add styles
							head.append(resources.find('style'));
							//Add linked elements (mostly CSS)
							resources.filter('link').each(function() {
								if(head.find('link[href="'+this.getAttribute('href')+'"]').length === 0) {
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
				widgetInformation = Widget.widgetInformation[widgetType];
				//…make Widget.types[widgetType] a function
				var old_type = Widget.types[widgetType]; //must now be defined after including resources
				Widget.types[widgetType] = function(instanceInformation) {
					this._widgetInformation = widgetInformation;
					this._instanceInformation = instanceInformation;
					this.widgetId = instanceInformation.session_id;
				};
				//Setting default properties
				Widget.types[widgetType].prototype = new Widget();
				Widget.types[widgetType].prototype.constructor = Widget.types[widgetType];
				Widget.types[widgetType].prototype._staticMethods = {};
				Widget.types[widgetType].prototype.widgetType = widgetType;
				//Add PHP methods
				jQuery.each(widgetInformation.methods.instance, function(i, method) {
					Widget.types[widgetType].prototype[method] = function() {
						return this._callMethod.apply(this, [method].concat(jQuery.makeArray(arguments)));
					};
				});
				jQuery.each(widgetInformation.methods['static'], function(i, method) {
					Widget.types[widgetType].prototype._staticMethods[method] = function() {
						var args = jQuery.makeArray(arguments);
						var options = args.pop();
						if(!options || options.constructor !== WidgetJSONOptions) {
							options !== undefined && args.push(options);
							options = new WidgetJSONOptions();
						}
						options.action = 'staticMethodCall';
						var callback = args.pop();
						if(!callback || (!jQuery.isFunction(callback) && !callback.resolveWith)) {
							callback !== undefined && args.push(callback);
							callback = Widget.defaultMethodHandler;
						}
						args.push(callback);
						args.push(options);
						args.unshift(method);
						return Widget.types[widgetType].prototype._callMethod.apply(Widget.types[widgetType].prototype, args);
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
			if(session && (jQuery.isFunction(session) || session.resolveWith)) {
				//intermediate callback given → shift session
				intermediateCallback = finishCallback;
				finishCallback = session;
				session = arguments[3];
			}
			if(Widget.singletons[widgetType]) {
				if(intermediateCallback) {
					if(intermediateCallback.resolveWith) {
						intermediateCallback.resolve(Widget.singletons[widgetType]);
					} else {
						intermediateCallback(Widget.singletons[widgetType]);
					}
				}
				if(finishCallback) {
					if(finishCallback.resolveWith) {
						finishCallback.resolve(Widget.singletons[widgetType]);
					} else {
						finishCallback(Widget.singletons[widgetType]);
					}
				}
				return Widget.singletons[widgetType];
			}
			var widgetInformation = Widget.loadInfo(widgetType);
			Widget.widgetJSON(widgetType, session, 'instanciateWidget', function(instanceInformation, error) {
				if(error) {
					Widget.notifyUser(Widget.logSeverity.ALERT, error.message);
					return;
				}
				var widget = new Widget.types[widgetType](instanceInformation);
				widget._type = widgetType;

				//Settings need to be mutable without changing globally
				widget.settings = {};
				jQuery.extend(true, widget.settings, Widget.types[widgetType].prototype.settings);
				jQuery.extend(widget.settings, instanceInformation.initial_settings);

				if(widgetInformation.is_singleton) {
					Widget.singletons[widgetType] = widget;
				}
				if(intermediateCallback) {
					if(intermediateCallback.resolveWith) {
						intermediateCallback.resolve(widget);
					} else {
						intermediateCallback(widget);
					}
				}
				if(widget.initialize) {
					widget.initialize();
				}
				if(finishCallback) {
					if(finishCallback.resolveWith) {
						finishCallback.resolve(widget);
					} else {
						finishCallback(widget);
					}
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
			if(session && (jQuery.isFunction(session) || session.resolveWith)) {
				//intermediate callback given → shift session
				intermediateCallback = finishCallback;
				finishCallback = session;
				session = arguments[3];
			}
			Widget.create(widgetType, intermediateCallback, function(widget) {
				widget._element = jQuery.parseHTML(widget._instanceInformation.content);
				widget.fire('element_set', widget._element);
				widget.handle('prepared', function(event, widget) {
					if(finishCallback.resolveWith) {
						finishCallback.resolve(widget);
					} else {
						finishCallback(widget);
					}
				}, false);
			}, session);
		},
	
		notifyUser: function(severity, message) {
			var options = {
				closeDelay: 5000,
				identifier: null,
				isHTML: false,
				closable: false,
				searchInfo: false
			};
			if(severity === Widget.logSeverity.ALERT) {
				delete options.closeDelay;
				options.closable = true;
			}
			jQuery.extend(options, arguments[2] || {});
		
			var notification_area = jQuery('#widget-notifications');
		
			//Handle messages with identical identifier
			if(options.identifier) {
				var prev_message = Widget.notificationWithIdentifier(options.identifier);
				if(prev_message) {
					prev_message.data('functions').increase_badge_count();
					prev_message.data('functions').set_message(message);
					return;
				}
			}
			var highlight = severity == 'info' ? 'highlight' : 'error';
			var display;
			if(options.searchInfo) {
				display = jQuery.parseHTML('<div class="ui-widget ui-notify search_info"><div class="ui-state-'+highlight+' ui-corner-all"><div class="ui-icon ui-icon-circle-close close-handle"></div><div><span class="message"></span></div></div></div>');
			} else {
				display = jQuery.parseHTML('<div class="ui-widget ui-notify search_info"><div class="ui-state-'+highlight+' ui-corner-all"><div class="ui-badge">1</div><div class="ui-icon ui-icon-circle-close close-handle"></div><div><span class="ui-icon ui-icon-'+severity+'"></span><span class="message"></span></div></div></div>');
			}
			display.hide().appendTo(notification_area).data('identifier', options.identifier);
		
			var badge = display.find('.ui-badge').hide();
			var close_button = display.find('.close-handle').hide();
			var message_container = display.find('.message');
		
			var functions = {
				element: display,
				options: options,
				close: function() {
					if(options.searchInfo) {
						display.hide('blind', function() {display.remove();});
					} else {
						display.hide('blind', function() {display.remove();});
					}
				},
				set_severity: function(new_severity) {
					var new_highlight = new_severity == 'info' ? 'highlight' : 'error';
					display.find('.ui-state-'+highlight).removeClass('ui-state-'+highlight).addClass('ui-state-'+new_highlight);
					display.find('.ui-icon-'+severity).removeClass('ui-icon-'+severity).addClass('ui-icon-'+new_severity);
					severity = new_severity;
					highlight = new_highlight;
				},
				increase_badge_count: function() {
					var count = parseInt(badge.text(), 10);
					if(isNaN(count)) {
						count = 0;
					}
					count++;
					badge.show().text(count);
					this.reset_timeout();
				},
				reset_timeout: function(closeDelay) {
					if(closeDelay !== undefined) {
						this.options.closeDelay = closeDelay;
					}
					this.clear_timeout();
					if(this.options.closeDelay) {
						this.options.timeout = window.setTimeout(this.close, this.options.closeDelay);
					}
				},
				clear_timeout: function() {
					if(this.options.timeout) {
						window.clearTimeout(this.options.timeout);
					}
				},
				set_message: function(message) {
					if(message.constructor === String) {
						if(this.options.isHTML) {
							message_container.html(message);
						} else {
							message_container.text(message);
						}
					} else {
						message_container.empty().append(message);
					}
				},
				enable_close_button: function() {
					close_button.show().click(function() {
						this.close();
					}.bind(this));
				}
			};
			functions.set_message(message);
			display.data('functions', functions).show('blind');
			functions.reset_timeout();
			if(options.closable) {
				functions.enable_close_button();
			}
			return functions;
		},
	
		notificationWithIdentifier: function(identifier) {
			var notification_area = jQuery('#widget-notifications');
			var result = null;
			notification_area.find('div.ui-notify').each(function() {
				var notification = jQuery(this);
				if(notification.data('identifier') === identifier) {
					result = notification;
					return false;
				}
			});
			return result;
		},
	
		tooltip: function(element, text) {
			jQuery(element).bind('mouseenter', alert.bind(window, text));
		},
	
		confirm: function(title, message, callback, cancelButtonText, okButtonText) {
			message = title+' '+message;
			// We don’t support the changing of button texts but still need to follow the convention of not displaying the cancel button if it is false-y but not undefined
			if(cancelButtonText !== undefined && !cancelButtonText) {
				alert(message);
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
			if(widgetOrId) {
				attributes.session_key = widgetOrId.widgetId !== undefined ? widgetOrId.widgetId : widgetOrId;
				if(attributes.session_key) {
					Widget.seenWidgets[attributes.session_key] = true;
				}
			}
			Widget.fire('widget-json-call', action, attributes, options);
			action.unshift('widget_json', widgetType);
			var url = FILE_PREFIX;
			jQuery.each(action, function(i, urlPart) {
				url += '/'+encodeURIComponent(urlPart);
			});
			var attr_str = attributes;
			if(attributes.constructor !== String) {
				if(options.content_type === 'application/json') {
					attr_str = JSON.stringify(attributes);
				} else if(options.content_type === 'multipart/form-data') {
					if(attributes.constructor !== FormData) {
						attr_str = new FormData();
						jQuery.each(attributes, function(i, val) {
							if(val instanceof File || (window.Blob && val instanceof Blob)) {
								attr_str.append(i, val);
							} else {
								attr_str.append(i, JSON.stringify(val));
							}
						});
					}
					if(attr_str.fake) {
						// Is fake FormData object
						options.content_type = "multipart/form-data; boundary="+attr_str.boundary;
						attr_str = attr_str.toString();
						options.send_as_binary = true;
					} else {
						options.content_type = false;
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
			if(options.callback_handles_error === null && callback) {
				options.callback_handles_error = !!callback.resolveWith || callback.length>=2;
			}
			var ajaxOpts = {
				url: url,
				data: attr_str,
				type: 'POST',
				processData: false,
				dataType: 'json',
				async: (options.async === null || options.async),
				contentType: options.content_type,
				cache: true,
				xhr: function() {
					var xmlhttprequest = jQuery.ajaxSettings.xhr();
					if(options.download_progress_callback) {
						xmlhttprequest.addEventListener('progress', options.download_progress_callback, false);
					}
					if(options.upload_progess_callback) {
						xmlhttprequest.upload.addEventListener('progress', options.upload_progess_callback, false);
					}
					if(options.send_as_binary && xmlhttprequest.sendAsBinary) {
						xmlhttprequest.send = xmlhttprequest.sendAsBinary;
					}
					return xmlhttprequest;
				},
				beforeSend: function() {
					Widget.activity();
				},
				success: function(result) {
					callback = (callback || Widget.defaultJSONHandler);
					var error = null;
					if(result && result.exception) {
						error = result.exception;
						var exception_handler = Widget.exception_type_handlers[error.exception_type] || Widget.exception_type_handlers.fallback;
						action.shift();
						var call_callback = options.callback_handles_error || exception_handler(error, widgetType, widgetOrId, action, callback, options, attributes);
						if(options.call_callback === null) {
							options.call_callback = call_callback;
						}
					}
					if(options.call_callback === null || options.call_callback) {
						if(callback.resolveWith) {
							if(error) {
								callback.rejectWith(this, [error]);
							} else {
								callback.resolveWith(this, [result]);
							}
						} else {
							callback.call(this, result, error);
						}
					}
				},
				error: function(request, statusCode, error) {
					var error_object = {message: error, exception_type: statusCode};
					if(statusCode === 'parsererror') {
						var text = jQuery.trim(request.responseText);
						error_object.message = jQuery.parseHTML(text);
					}
					var exception_handler = Widget.exception_type_handlers[error_object.exception_type] || Widget.exception_type_handlers.fallback;
					action.shift();
					var call_callback = options.callback_handles_error || exception_handler(error_object, widgetType, widgetOrId, action, callback, options, attributes);
					if(options.call_callback === null) {
						options.call_callback = call_callback;
					}
					if(options.call_callback) {
						if(callback.resolveWith) {
							callback.rejectWith(this, [error_object]);
						} else {
							callback.call(this, {}, error_object);
						}
					}
				},
				complete: function() {
					Widget.end_activity();
				}
			};
			jQuery.ajax(ajaxOpts);
		},
	
		callStatic: function(widgetType, methodName) {
			var parameters = jQuery.makeArray(arguments).slice(2);
			if(!Widget.types[widgetType]) {
				Widget.loadInfo(widgetType);
			}
			var method = jQuery.noop;
			if(Widget.types[widgetType].prototype[methodName]) {
				method = Widget.types[widgetType].prototype[methodName];
			} else if(Widget.types[widgetType].prototype._staticMethods[methodName]) {
				method = Widget.types[widgetType].prototype._staticMethods[methodName];
			}
			return method.apply(Widget.types[widgetType].prototype, parameters);
		},
	
		defaultJSONHandler: jQuery.noop,
		defaultMethodHandler: jQuery.noop,
	
		log: jQuery.noop,
	
		types: {},
		singletons: {},
		widgetInformation: {},
	
		seenWidgets: {},
	
		//Called when a specific type of Exception is thrown in _widgetJSON and options.callback_handles_error is not true. Return true from the function to execute the callback or false to cancel it. The Widget.notifyUser function will not be called either way.
		exception_type_handlers: {
			fallback: function(error, widgetType, widgetOrId, action, callback, options, attributes) {
				error.reporting_done = true;
				Widget.notifyUser(Widget.logSeverity.ALERT, error.message);
				return true;
			},
		
			needs_login: function(error, widgetType, widgetOrId, action, callback, options, attributes) {
				Widget.create('login_window', function(login_widget) {
					login_widget.show();
					Widget.handle('rapila-logged_in', function(event) {
						// Re-try the action
						Widget.widgetJSON(widgetType, widgetOrId, action, callback, options, attributes);
					}, true);
				});
				return false;
			},
		
			ValidationException: function(error, widgetType, widgetOrId, action, callback, options, attributes) {
				if(widgetOrId.validate_with && widgetOrId.validate_with.constructor === Function) {
					error.reporting_done = true;
					widgetOrId.validate_with(error.parameters);
				} else if (widgetOrId.detail_widget) {
					error.reporting_done = true;
					widgetOrId.detail_widget.validate_with(error.parameters, widgetOrId.detail_widget.content);
				} else {
					error.reporting_done = true;
					message = jQuery('<div/>').text(error.message);
					var error_list = jQuery('<ul/>').appendTo(message);
					jQuery.each(error.parameters, function(counter, item) {
						if(item.string) error_list.append(jQuery('<li/>').html(item.string));
					});
					Widget.notifyUser(Widget.logSeverity.ALERT, message, {
						closeDelay: false,
						isHTML: true,
						closable: true
					});
				}
				return false;
			},
		
			StillReferencedException: function(error, widgetType, widgetOrId, action, callback, options, attributes) {
				message = jQuery('<div/>').text(error.message);
				var error_list = jQuery('<ul/>').appendTo(message);
				jQuery.each(error.parameters.references, function(counter, item) {
					var li = jQuery('<li/>').text(item.name+' ');
					var link = jQuery('<a/>').addClass("ui-icon ui-icon-pencil pointer").attr('title', AdminInterface.translations.editEntry);
					if(item.admin_link) {
						link.attr('href', item.admin_link);
						li.append(link);
					} else if(item.admin_widget) {
						link.bind('click', function() {
							Widget.createWithElement(item.admin_widget[0], function(widget) {
								widget.handle('element_set', function() {
									var buttons = [];
									if(widget.save) {
										buttons.push({
											text: AdminInterface.translations.saveEntry,
											'class': 'primary ui-state-highlight',
											click: function() {
												widget.save(function() {
													widget._element.dialog('close');
												});
											},
											accesskey: 's'
										});
									}
									widget._element.dialog({buttons: buttons, width: 550, title: item.name});
								});
							}, jQuery.noop, item.admin_widget[1]);
						});
						li.append(link);
					}
					error_list.append(li);
				});
				Widget.notifyUser(Widget.logSeverity.ALERT, message, {
					closeDelay: false,
					isHTML: true,
					closable: true
				});
				error.reporting_done = true;
				return false;
			}
		}
	});

	Widget.logSeverity = {
		DEBUG: 'debug',
		INFO: 'info',
		ALERT: 'alert'
	};

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
			async: null, //defaults to false for getters and setters, true otherwise
			upload_progess_callback: null, //"progress" event handlers on request
			download_progress_callback: null, //"progress" event handlers on response
			content_type: 'application/json', //determines interpretation of the data
			action: null,
			callback_handles_error: null, //defaults to true if the callback has two args
			call_callback: null //defaults to true if callback_handles_error || the default error handler returns true
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
		parseHTML: function(html, instanciateWidgets, elementName) {
			var element = document.createElement(elementName || 'div');
			element.innerHTML = jQuery.trim(html);
			var result = jQuery(element.childNodes);
			if(instanciateWidgets) {
				result.widgetElements().each(function() {
					jQuery(this).prepareWidget();
				});
			}
			return result;
		},
	
		validateEmail: function(email) {
			var email_regex = /^[\w._\-%+]+@[\w\-]+(\.[\w\-]+)*(\.\w+)$/;
			return email.length > 4 && email_regex.test(email);
		},
	
		openLink: function(link, event) {
			if(event[jQuery.support.linkOpenModifierKey] || event.shiftKey) {
				window.open(link);
			} else {
				window.location.href = link;
			}
		}
	});

	jQuery.support.linkOpenModifierKey = /Mac OS X/.test(navigator.userAgent) ? 'metaKey' : 'ctrlKey';

	jQuery.fn.extend({
		//Option to serializeArrayKV so it can be used for JSON POST requests which are then being treated by PHP as $_REQUEST or $_POST would
		serializeArrayKV: function() {
			var result = {};
			this.map(function() {
				return this.elements ? jQuery.makeArray(this.elements) : this;
			}).each(function() {
				if(!(this.name && (/select|textarea|input/i).test(this.nodeName))) {
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
		},

		unserialize: function(data) {
			///TODO: handle arrays (keys ending in “[]”), checkboxes and radios (.attr)
			var _this = this;
			jQuery.each(data, function(key, item) {
				_this.find('[name='+key.escapeSelector()+']').val(item);
			});
			return this;
		},
	
		widgetElements: function(type) {
			if(type) {
				return this.find('*[data-widget-type='+type+']');
			} else {
				return this.find('*[data-widget-type]');
			}
		},
	
		prepareWidget: function() {
			if(this.length === 0) {
				return this;
			}
			var callback = arguments[0] || jQuery.noop;
			var intermediateCallback = jQuery.noop;
			if(arguments[1]) {
				intermediateCallback = callback;
				callback = arguments[1];
			}
			callback && this.ensureWidget(callback);
			intermediateCallback && this.ensureWidget(intermediateCallback, true);
		
			if(this.didPrepareWidget() || this.hasWidget()) {
				return this;
			}
			this.data('prepareWidget_called', true);
		
			var widget_type = this.attr('data-widget-type');
			var widget_session = this.attr('data-widget-session');
			var widget_element = this;
		
			Widget.create(widget_type, function(widget) {
				widget_element.data('widget', widget);
				widget._element = widget_element;
				(widget_element.data('waiting_intermediate_callbacks') || {resolve: jQuery.noop}).resolve(widget);
				widget.handle('prepared', function() {
					(widget_element.data('waiting_prepare_callbacks') || {resolve: jQuery.noop}).resolve(widget);
				});
			}, widget_session);
		
			return this;
		},
	
		hasWidget: function() {
			return !!this.data('widget');
		},
	
		didPrepareWidget: function() {
			return !!this.data('prepareWidget_called');
		},
	
		/**
		* Use this to make sure a specific element’s widget is initialized/prepared when the callback is called but DO NOT WANT to cause the widget to initialize, for example if you know that the widget will be initialized eventually.
		*/
		ensureWidget: function(callback, is_intermediate) {
			var data_name = is_intermediate ? 'waiting_intermediate_callbacks' : 'waiting_prepare_callbacks';
			var queue = this.data(data_name);
			if(!queue) {
				queue = new jQuery.Deferred();
				this.data(data_name, queue);
			}
			if(callback.resolveWith) {
				queue.done(function() {
					callback.resolveWith(this, jQuery.makeArray(arguments));
				});
			} else {
				queue.done(callback);
			}
			return this;
		},
	
		isInDom: function() {
			var doc = document || arguments[0];
			return jQuery(doc).has(this[0]).length > 0;
		},
	
		populate: function(options, default_value, use_text_as_value) {
			var _this = this;
			use_text_as_value = (use_text_as_value === undefined) ? jQuery.isArray(options) : !!use_text_as_value;
			jQuery.each(options, function(value, text) {
				if(use_text_as_value) {
					value = text;
				}
				if((default_value === null && !_this.prop('multiple')) || default_value === undefined) {
					default_value = value;
				}
				var option = jQuery('<option/>').text(text).attr('value', value);
				_this.append(option);
			});
			this.val(default_value);
			return this;
		}
	});

	function UnsavedChanges(element) {
		if(!(this instanceof UnsavedChanges)) {
			return new UnsavedChanges();
		}

		var unsaved = false;
		this.set = function(event) {
			if(event && !event.originalEvent) {
				//Prevent triggerHandler('change') from affecting unsaved state
				return;
			}
			!unsaved && (unsaved = true) && ++UnsavedChanges.global;
			return this;
		};
		this.release = function() {
			unsaved && !(unsaved = false) && --UnsavedChanges.global ;
			return this;
		};
		this.check = function() {
			return unsaved;
		};
		this.warn = function(callback) {
			if(!unsaved) {
				callback(true);
			} else {
				Widget.confirm(AdminInterface.translations.discardAlertTitle, AdminInterface.translations.discardAlertMessage, function(ok) {
					ok && this.release();
					callback(ok);
				}.bind(this));
			}
			return this;
		};
		this.protect = function(element) {
			element.delegate(':input', 'change.UnsavedChanges', this.set.bind(this));
			return this;
		};
		this.unprotect = function(element) {
			element.undelegate('.UnsavedChanges');
			return this;
		};
	
		element && this.protect(element);
	}

	UnsavedChanges.global = 0;
	
	window.UnsavedChanges = UnsavedChanges;
	window.Widget = Widget;
	window.WidgetJSONOptions = WidgetJSONOptions;
})();