Event.observe(document, "dom:loaded", function() {
  var the_body = document.getElementsByTagName('body')[0];
  var the_chooser = $("chooser");
  the_body.style.paddingLeft = "" + the_chooser.clientWidth + "px";
  init_add_property_button();
  init_add_right_button();
  init_toggle_fieldsets();
  init_delete_forms();
  init_tags();
});

function init_tags() {
  var tag_panel = $('tag_panel');
  if(!tag_panel) {
    return;
  }
  
  Event.observe($('tag_panel_opener'), 'click', function() {
    tag_panel.toggleClassName('visible');
  });
  
  var tag_handler = new TagHandler(tag_panel.getAttribute('model_name'), tag_panel.getAttribute('tagged_item_id'));
  
  var remove_tag = function(request) {
    this.parentNode.removeChild(this);
  }
  
  var update_tags = function(tags) {
    tags.each(function(tag) {
      var tag_element = document.createElement('div');
      var remove_tag_element = $(document.createElement('span'));
      remove_tag_element.addClassName('link');
      remove_tag_element.appendChild(document.createTextNode("✗"))
      Event.observe(remove_tag_element, 'click', function(event) {
        tag_handler.remove_tag(this.tag_name, remove_tag.bind(this));
      }.bindAsEventListener(tag_element));
      tag_element.tag_name = tag.getAttribute('name');
      tag_element.appendChild(document.createTextNode(tag_element.tag_name+' '));
      tag_element.appendChild(remove_tag_element);
      tag_panel.appendChild(tag_element);
    });
  };
  
  tag_handler.list_tags(update_tags);
  
  var add_tag_input = $('add_tag_input');
  var suggestion = new Suggestion(add_tag_input, {tag_handler: tag_handler});

  Event.observe(add_tag_input, "keypress", function(event) {
    if(event.keyCode !== 13 || event.shouldBeCancelled) {
      return;
    }
    tag_handler.add_tags($F(this).split(','), update_tags);
    this.value = "";
  }.bindAsEventListener(add_tag_input));
}

function init_add_property_button() {
  var add_property_button = $('new_property');
  if(!add_property_button) {
    return;
  }
  var prototyper = new FormPrototyper($('clone_area'), $('new_property').parentNode, Insertion.Top);
  prototyper.bind_to(add_property_button, 'click');
}

function init_add_right_button() {
  var add_right_button = $('add_right');
  if(!add_right_button) {
    return;
  }
  
  var prototyper = new FormPrototyper($('clone_area'), $('user_rights'), Insertion.Bottom);
  prototyper.bind_to(add_right_button, 'click');
}

function init_toggle_fieldsets() {
  var togglers = $A(document.getElementsByTagName('legend'));
  togglers = togglers.findAll(function(toggler) {return Element.hasClassName(toggler, 'toggler')});
  var toggle_method = function() {
    legend = this;
    Element.toggleClassName(this, 'open');
    var siblings = $A(this.parentNode.childNodes).without(this);
    siblings.each(function(element_to_be_toggled) {
      if(element_to_be_toggled.nodeType !== 1) {
        return;
      }
      Element.toggle(element_to_be_toggled);
    });
  };
  togglers.each(function(toggler) {
    toggler.onclick = toggle_method;
  });
}

function delete_form_event_handler(event) {
  if(!confirm(this.getAttribute('title'))) {
    Event.stop(event);
  }
}

function init_delete_forms() {
  var forms = $A(document.getElementsByTagName('form'));
  forms.each(function(form) {
    if(!form.hasClassName('delete_form')) {
      return;
    }
    Event.observe(form, "submit", delete_form_event_handler.bindAsEventListener(form));
  });
}

function get_ajax_path(backend_module_name) {
	action = arguments[1] ? arguments[1] : "";
	return MAIN_DIR_FE+FILE_PREFIX+"/backend_ajax/"+backend_module_name+"/"+action;
}

var FormPrototyper = Class.create();
FormPrototyper.prototype = {
  initialize: function(clone_area, destination, insertion) {
    if(insertion === null || insertion === undefined) {
      insertion = Insertion.Bottom;
    }
    this.clone_elements = $(clone_area).childElements();
    this.clone_id = 0;
    this.insertion = insertion;
    this.destination = $(destination);
    this.options = arguments[3] || {};
  },
  
  create_copy: function() {
    this.new_clone_id = (0 + this.clone_id+ 1);
    var object = this;
    var elements = this.clone_elements.collect(function(element) {
      return $(element).cloneNode(true);
    });
    elements.invoke('getElementsBySelector', 'select, input').each(function(form_elements) {
      form_elements.each(FormPrototyper.prototype.update_id.bind(object));
    });
    elements.invoke('getElementsBySelector', 'label').concat([elements.findAll(function(clone_element) {return clone_element.tagName.toLowerCase() === 'label'})]).each(function(form_labels) {
      form_labels.each(function(form_label) {
        form_label.setAttribute('for', form_label.getAttribute('for')+object.new_clone_id);
      });
    });
    elements.invoke('getElementsBySelector', 'button[type=delete], .button.remove').each(function(clone_elements) {
      clone_elements.each(function(clone_element) {
        Event.observe(clone_element, "click", function(event) {
          elements.each(function(element) {
            element.parentNode.removeChild(element);
          });
          Event.stop(event);
        });
      });
    });
    this.insert_into_destination(elements);
    this.clone_id = this.new_clone_id;
    if(this.options.callback) {
      this.options.callback(elements);
    }
  },
  
  insert_into_destination: function(elements) {
    if(this.insertion === Insertion.Top || this.insertion === Insertion.After) {
      elements.reverse();
    }
    if(this.insertion === Insertion.Top) {
      elements.each(function(element) {
        this.destination.insertBefore(element, this.destination.firstChild);
      }.bind(this));
    }
    if(this.insertion === Insertion.Bottom) {
      elements.each(function(element) {
        this.destination.appendChild(element);
      }.bind(this));
    }
    if(this.insertion === Insertion.Before) {
      elements.each(function(element) {
        this.destination.parentNode.insertBefore(element, this.destination);
      }.bind(this));
    }
    if(this.insertion === Insertion.After) {
      elements.each(function(element) {
        this.destination.parentNode.insertBefore(element, this.destination.nextSibling);
      }.bind(this));
    }
  },
  
  update_id: function(element){
    if($(element).hasAttribute('id')) {
      element.setAttribute('id', element.getAttribute('id')+this.new_clone_id);
    }
    if(element.getAttribute('name').indexOf('[]') > -1) {
      if(element.getAttribute('type') === 'hidden' && (element.getAttribute('value') === '' || element.getAttribute('value') === 'new_')) {
        element.setAttribute('value', element.getAttribute('value')+this.new_clone_id);
      }
    } else {
      element.setAttribute('name', element.getAttribute('name')+this.new_clone_id);
    }
  },
  
  bind_to: function(element, event) {
    Event.observe($(element), event, FormPrototyper.prototype.create_copy.bindAsEventListener(this));
  }
};

var TagHandler = Class.create();
TagHandler.prototype = {
  initialize: function(model_name, tagged_item_id) {
    this.model_name = model_name;
    this.tagged_item_id = tagged_item_id;
    this.all_tag_list = null;
  },
  
  tags_starting_with: function(start) {
    if(this.all_tag_list === null) {
      this.list_all_tags(function(tags) {
        tags = tags.sortBy(function(tag) {
          return parseInt(tag.getAttribute('quantity'));
        });
        this.all_tag_list = tags.invoke('getAttribute', 'name').reverse();
      }.bind(this), true);
    }
    var results = [];
    this.all_tag_list.each(function(tag) {
      if(tag.indexOf(start) === 0) {
        results[results.length] = tag;
      }
    });
    return results;
  },
  
  list_all_tags: function(callback) {
    var is_synchronous = arguments[1] === true;
    this.do_request("all_tags", callback, {}, {asynchronous: !is_synchronous});
  },
  
  list_tags: function(callback) {
    this.do_request("tags_for", callback);
  },
  
  add_tags: function(tags, callback) {
    tags.each(function(tag) {
      this.add_tag(tag, callback);
    }.bind(this));
  },
  
  add_tag: function(tag, callback) {
    this.do_request("add_tag", callback, {tag: tag});
  },
  
  remove_tag: function(tag, callback) {
    this.do_request("remove_tag", callback, {tag: tag});
  },
  
  set_tags: function(tags, callback) {
    tags = tags.join(',');
    this.do_request("save_tags", callback, {tags: tags});
  },
  
  tag_callback: function(real_callback, request) {
    var request_document = request.responseXML;
    var tags = $A(request_document.getElementsByTagName("tag"));
    return real_callback(tags);
  },
  
  query_string: function() {
    var args = arguments[0] || {};
    args = Object.extend(args, {tagged_item_id: this.tagged_item_id, model_name: this.model_name});
    return Object.toQueryString(args);
  },
  
  do_request: function(action, callback) {
    var parameters = arguments[2] || {};
    var additional_options = arguments[3] || {};
    callback = this.tag_callback.bind(this, callback);
    var options = Object.extend(additional_options, {onComplete:callback, method:'post', postBody:this.query_string(parameters)});
    new Ajax.Request(get_ajax_path("tags", action), options);
  }
};

window.getInnerHeight = function() {
	return window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight;
};

//Add trim to string
String.prototype.trim = function() {
	var	str = this.replace(/^\s\s*/, '');
	var ws = /\s/;
	var i = str.length;
	while (ws.test(str.charAt(--i)));
	return str.slice(0, i + 1);
};

var Suggestion = Class.create();
Object.extend(Suggestion.prototype, {
  initialize: function(searchField) {
  	this.searchField = searchField;
  	this.options = arguments[1] || {};
  	this.timer = null;
  	this.latestWord = null;
  	this.currentRequest = null;
	
  	this.displayLayer = new Element("div", {class: 'suggest_results'});
    document.body.appendChild(this.displayLayer);
  	this.layerIsVisible = false
	
  	this.requestUrl = MAIN_DIR_FE+FILE_PREFIX+"/suggest_ajax";;
	
  	this.attach();
  },
  
  positionLayer: function() {
    this.displayLayer.style.left = ""+this.searchField.cumulativeOffset().left+"px";
    this.displayLayer.style.top = ""+(this.searchField.cumulativeOffset().top+this.searchField.getHeight())+"px";
    this.displayLayer.style.width = ""+this.searchField.getWidth()+"px";
  },
  
  attach: function() {
  	Event.observe(this.searchField, "keyup", function(event) {
      var element = Event.element(event);
  		var position = element.selectionStart;
  		if(position !== element.selectionEnd) {
  			return;
  		}
		
  		if(event.keyCode === 13 || (event.keyCode >= 37 && event.keyCode <= 40)) {
  			return;
  		}
				
  		var stringTillPosition = $F(element).substring(0, position);
  		var lastWord = stringTillPosition.split(/\b/);
  		if(lastWord.length === 0) {
  			return;
  		}
		
  		lastWord = lastWord[lastWord.length-1];
		
  		if(lastWord === this.latestWord) {
  			if(!this.layerIsVisible) {
  				this.showLayer();
  			}
  			return;
  		}
		
  		if(lastWord.trim().length === 0) {
  			return;
  		}
		
  		this.latestWord = lastWord;
		
  		if(this.timer !== null) {
  			window.clearTimeout(this.timer);
  		}
		
  		this.timer = window.setTimeout(this.execute.bind(this), 500);
  	}.bindAsEventListener(this));
  	
  	Event.observe(this.searchField, "keypress", function(event) {
      var element = Event.element(event);
  		if(!this.layerIsVisible) {
  			return;
  		}
  		if(event.keyCode === 40) {
  			this.moveFocusDown();
  		} else if(event.keyCode === 38) {
  			this.moveFocusUp();
  		} else if(event.keyCode === 13) {
  			this.activateCurrentSuggestion();
  		} else {
  			this.hideLayer();
  			return;
  		}
      event.shouldBeCancelled = true;
  	}.bindAsEventListener(this));
	
    this.positionLayer();
    Event.observe(window, 'resize', this.positionLayer.bindAsEventListener(this));
  },
  
  execute: function() {
  	this.timer = null;
    var results = this.options.tag_handler.tags_starting_with(this.latestWord);
    
  	this.displayLayer.innerHTML = '';
  	
    if(results.length === 0) {
  		this.displayLayer.hide();
  		return;
    }
    
  	results.each(function(result, counter) {
  		this.addSuggestion(result, counter);
    }.bind(this));

  	this.showLayer();
  },
  
  hideLayer: function() {
  	this.displayLayer.hide();
  	this.layerIsVisible = false;
  },
  
  showLayer: function() {
  	this.displayLayer.show();
  	this.layerIsVisible = true;
  },
  
  addSuggestion: function(suggestion, resultCounter) {
  	var suggestionResult = new Element('a', {href: '#', class: 'suggest_result'});
  	this.displayLayer.appendChild(suggestionResult);
  	suggestionResult.appendChild(document.createTextNode(suggestion));
  	suggestionResult.missingWordPart = suggestion.substring(this.latestWord.length, suggestion.length);
  	Event.observe(suggestionResult, "click", this.activateSuggestion.bind(this, suggestionResult));
  	if(resultCounter === 0) {
  		suggestionResult.addClassName("active");
  	}
  },
  
  activateSuggestion: function(suggestionResult) {
  	var firstPart = $F(this.searchField).substring(0, this.searchField.selectionStart);
  	var secondPart = $F(this.searchField).substring(this.searchField.selectionEnd);
  	this.searchField.value = firstPart+suggestionResult.missingWordPart+secondPart;
  	this.searchField.focus();
  	this.hideLayer();
  },
  
  activateCurrentSuggestion: function() {
  	var currentResult = this.displayLayer.select(".active")[0];
  	this.activateSuggestion(currentResult);
  },
  
  moveFocusUp: function() {
  	var currentResult = this.displayLayer.select(".active")[0];
  	var previous = currentResult.previous();
  	if(previous === null) {
  		previous = this.displayLayer.select(".suggest_result:last-child")[0];
  	}
  	currentResult.removeClassName("active");
  	previous.addClassName("active");
  },
  
  moveFocusDown: function() {
  	var currentResult = this.displayLayer.select(".active")[0];
  	var next = currentResult.next();
  	if(next === null) {
  		next = this.displayLayer.select(".suggest_result:first-child")[0];
  	}
  	currentResult.removeClassName("active");
  	next.addClassName("active");
  }
});