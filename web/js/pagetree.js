//Helper class Cookie
var Cookie = Class.create({
  initialize: function(name) {
    this.name = name;
  },
  
  set: function(value) {
    var days = arguments[1] || 7;
    if (days) {
      var date = new Date();
      date.setTime(date.getTime()+(days*24*60*60*1000));
      var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = this.name+"="+value+expires+"; path=/";
  },

  get: function() {
    var nameEQ = this.name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
  },
  
  erase: function() {
    this.create("", -1);
  }
});

/**
 * PageTreeBuilder using Prototype.
 *
 */
/**
 * PageTreeBuilder class for handling recursive page tree
 */
var PageTreeBuilder = Class.create({
  options: {
    currentElementClassName: 'current',
    elementIdPrefix: 'page-tree-item-',
    pageElementTagName: 'li',
    pageListTagName: 'ul',
    selectionCookie: 'page_tree_open_page_ids',
    clickerTag: 'span',
    clickerClass: 'tree-clicker',
    openedClickerClass: 'opened',
    closedClickerClass: 'closed',
    clickerProxyClass: 'tree-clicker-proxy'
  },
  
  /**
   * Create a PageTreeBuilder.
   *
   */
  initialize: function(root_element) {
    this.root_element = $(root_element);
    Object.extend(this.options, arguments[1] || {});
    this.cookie = new Cookie(this.options.selectionCookie);
    this.attach();
    $A(this.cookie.get().split(',')).each(function(page_id) {
      this.toggle($(this.options.elementIdPrefix+page_id), true);
    }.bind(this));
    this.open_current();
  },
  
  /**
   * 
   */
  attach: function() {
    this.root_element.select(this.options.pageElementTagName).each(function(element) {
      var page_id = element.getAttribute('id');
      page_id = page_id.substring(this.options.elementIdPrefix.length, page_id.length+1);
      element.page_id = page_id;
      element.child_list = element.select(this.options.pageListTagName)[0];
      element.child_list = element.child_list ? element.child_list : null;
      if(element.child_list) {
        element.child_list.hide();
        element.clicker = new Element(this.options.clickerTag, {'class': this.options.clickerClass+' '+this.options.closedClickerClass});
        element.clicker.page_id = element.page_id;
        element.insert({top: element.clicker});
        Event.observe(element.clicker, 'click', this.handle_click.bindAsEventListener(this, element));
      } else {
        element.insert({top: new Element(this.options.clickerTag, {'class': this.options.clickerProxyClass})});
      }
    }.bind(this));
    
    Event.observe(window, 'unload', function() {
      var open_ids = this.root_element.select(this.options.clickerTag+'.'+this.options.clickerClass+'.'+this.options.openedClickerClass).pluck('page_id').join(',');
      this.cookie.set(open_ids);
    }.bindAsEventListener(this));
  },
  
  handle_click: function(event, element) {
    this.toggle(element);
  },
  
  open_current: function() {
    var current = this.root_element.select(this.options.pageElementTagName+'.'+this.options.currentElementClassName)[0];
    if(!current) {
      return;
    }
    while(current && current.descendantOf(this.root_element)) {
      this.toggle(current, true);
      current = current.up(this.options.pageElementTagName);
    }
  },
  
  toggle: function(element) {
    if(!element || !element.child_list) {
      return;
    }
    var force_open = arguments[1] === true;
    if(force_open) {
      element.child_list.show();
      element.clicker.removeClassName(this.options.closedClickerClass);
      element.clicker.addClassName(this.options.openedClickerClass);
    } else {
      element.child_list.toggle();
      element.clicker.toggleClassName(this.options.closedClickerClass);
      element.clicker.toggleClassName(this.options.openedClickerClass);
    }
  }
});

Event.observe(document, "dom:loaded", function() {
  var page_tree = $$('#chooser_list > ul')[0];
  if(page_tree)
    new PageTreeBuilder(page_tree);
});