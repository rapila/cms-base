#! /usr/bin/env ruby
# encoding: UTF-8

require 'optparse'
require 'yaml'
require 'set'
require 'fileutils'

# Default options
$options = {:type => :widget, :location => :site, :force => false, :enabled => true, :sidebar_widget => 'list', :content_widget => 'list'}
$aspects = Set.new
$files = [:php, :yaml].to_set

default_aspects = {:frontend => ['dynamic', 'widget_based'], :widget => ['persistent']}

OptionParser.new("Usage: "+File.basename(__FILE__)+" [options] module_name") do|opts|
	## GENERAL
	opts.on('-t', '--type [TYPE]', [:widget, :frontend, :admin, :filter, :file], {:w => :widget, :f => :frontend, :a => :admin, :r => :filter, :e => :file}, 'Create module of type TYPE (one of w[idget], f[rontend], a[dmin], [filte]r, [fil]e; default: widget)') do |type|
		$options[:type] = type if type
		$aspects.merge default_aspects[$options[:type]] unless default_aspects[$options[:type]].nil?
	end
	
	opts.on('-f', '--[no-]force', 'Override files if they exist') do |force|
		$options[:force] = force
	end
	
	## LOCATION
	opts.on('-b', '--base', 'Put module into base. Not applicable with -p') do
		$options[:location] = :base
	end
	
	opts.on('-p', '--plugin PLUGIN', 'Put module into plugin PLUGIN. Not applicable with -b') do |plugin|
		$options[:location] = plugin
	end

	## ASPECTS
	opts.on('-a', '--aspects ASPECT1,ASPECT2', Array, 'Set aspects to [ASPECT1, ASPECT2]') do |var|
		$aspects.merge var
	end

	opts.on('-d', '--dashboard', 'Add the dashboard aspect. Applicable to widget modules') do
		$aspects << "dashboard"
	end
	
	opts.on('-l', '--[no-]list', 'Add the list aspect. Applicable to widget modules (default for modules ending in _list)') do |list|
		$options[:list_aspect] = list
	end
	
	opts.on('--detail', 'Add the detail aspect. Applicable to widget modules') do
		$aspects << "detail"
	end
	
	opts.on('--single-screen', 'Add the single_screen aspect. Applicable to admin modules') do
		$aspects << "single_screen"
	end
	
	opts.on('-e', '--[no-]edit', 'Add the edit aspect. Applicable to widget modules (default for modules ending in _edit)') do |edit|
		$options[:edit_aspect] = edit
	end
	
	opts.on('--[no-]dynamic', 'Add the dynamic aspect. Applicable to frontend modules (default)') do |dynamic|
		$aspects.delete "dynamic" unless dynamic
	end
	
	opts.on('--[no-]persistent', 'Add the persistent aspect. Applicable to widget modules (default)') do |persistent|
		$aspects.delete "persistent" unless persistent
	end
	
	opts.on('--[no-]widget-based', 'Add the widget_based aspect. Applicable to frontend modules (default)') do |widget_based|
		$aspects.delete "widget_based" unless widget_based
	end
	
	opts.on('--[no-]php', 'Write a php class file (default)') do |php|
		$files.delete :php unless php
	end
	
	opts.on('--[no-]yaml', 'Write a info.yml file (default)') do |yaml|
		$files.delete :yaml unless yaml
	end
	
	## INFO STUFF
	opts.on('--desc DESCRIPTION', 'Sets the module’s description in its info.yml to DESCRIPTION') do |description|
		$options[:description] = description
	end
	
	opts.on('--ver VERSION', 'Sets the module’s version in its info.yml to VERSION') do |version|
		$options[:version] = version
	end

	opts.on('--[no-]enabled', 'Sets the module to be enabled (default)') do |enabled|
		$options[:enabled] = enabled
	end
	
	## ADDITIONAL FILES
	opts.on('-j', '--js', 'Adds a js template. Applicable with widgets and admin modules') do
		$files << :js
	end
	
	opts.on('-c', '--css', 'Adds a css template. Applicable with widgets and admin modules') do
		$files << :css
	end

	opts.on('--sidebar WIDGET_TYPE=list', 'Sets this admin module’s sidebar widget type to WIDGET_TYPE') do |type|
		$options[:sidebar_widget] = type
	end

	opts.on('--content WIDGET_TYPE=list', 'Sets this admin module’s sidebar widget type to WIDGET_TYPE') do |type|
		$options[:content_widget] = type
	end

	opts.on('-h', '--help', 'Display this screen') do
		puts opts
		exit
	end
	
	opts.parse!
end

module_name = ARGV.pop
raise OptionParser::MissingArgument if module_name.nil?

if $options[:edit_aspect] or ($options[:edit_aspect].nil? and module_name.end_with? '_edit') then
	$aspects << 'edit'
end
if $options[:list_aspect] or ($options[:list_aspect].nil? and module_name.end_with? '_list') then
	$aspects << 'list'
end

$folder = $options[:location]
if($folder.instance_of?(Symbol)) then
	$folder = $folder.to_s
else
	$folder = "plugins/#{$folder}"
end
$folder = "#{$folder}/modules/#{$options[:type]}/#{module_name}"

class_name = "#{module_name}_#{$options[:type]}_module".gsub(/^[a-z]|_[a-z]/) { |a| a.upcase }.gsub(/_/, '')
super_class_name = "#{$options[:type]}_module".gsub(/^[a-z]|_[a-z]/) { |a| a.upcase }.gsub(/_/, '')

puts "Creating “#{class_name}” in #{$folder}."
puts "Frontend Module is NOT widget-based" if not $options[:widget_based] and $options[:type] == :frontend
puts "Module exists. Overriding existing files" if $options[:force] and File.exists?($folder)
puts "Module exists. Creating non-existant files only" if not $options[:force] and File.exists?($folder)
puts "Adding aspects #{$aspects.to_a.join(', ')}" unless $aspects.empty?
puts "Creating the following files: #{$files.to_a.join(', ')}" unless $files.empty?

FileUtils.mkdir_p $folder

def write_file(identifier, name, dir = nil, &block)
	return unless $files.include? identifier
	if dir.nil? then
		dir = "#{$folder}"
	else
		dir = "#{$folder}/#{dir}"
	end
	Dir.mkdir dir unless File.exists? dir
	file = "#{dir}/#{name}"
	if File.exists?(file) and not $options[:force] then
		return
	end
	File.open(file, 'w') do |f|
		contents = yield f
		f.write(contents) if contents
	end
end

def php_field(name, mod = 'private')
	name = (name=~ /\$/) ? name : '$' + name
	name = name.gsub('this->', '')
	"#{mod} #{name};"
end

def php_method(name, body = '', args = [], mod = 'public')
	args.map! do |arg|
		arg=~ /\$/ ? arg : '$' + arg
	end
	"#{mod} function #{name}(#{args.join(', ')}) {
		#{body}
	}"
end

def unboxing_php_filter_method(name, boxed = [], body = '', args = ['aContainer'])
	outer_body = ''
	boxed.each_with_index do |var, i|
		outer_body += "$#{var} = &$aContainer[#{i}];\n\t\t"
	end
	outer_body += body
	php_method(name, outer_body, args)
end

write_file(:php, "#{class_name}.php") do
	implements = ''
	if $options[:type] == :frontend and $aspects.include? 'widget_based' then
		implements = ' implements WidgetBasedFrontendModule'
	end

	extends = super_class_name
	if $options[:type] == :frontend then
		if $aspects.include? 'dynamic' then
			extends = "Dynamic#{super_class_name}"
		end
	elsif $options[:type] == :widget then
		if $aspects.include? 'edit' then
			extends = "Edit#{super_class_name}"
		elsif $aspects.include? 'persistent' then
			extends = "Persistent#{super_class_name}"
		end
	end
	
	php_methods = []
	
	if $options[:type] == :widget then
		constructor_content = "";
		if $aspects.include? 'list' then
			model_name = module_name.gsub('_list', '').capitalize
			php_methods.push php_field('oListWidget')
			php_methods.push php_field('oCriteriaListWidgetDelegate')
			constructor_content += "$this->oCriteriaListWidgetDelegate = new CriteriaListWidgetDelegate($this, '#{model_name}');
		$this->oListWidget = WidgetModule::getWidget('list', null, $this->oCriteriaListWidgetDelegate);"
			php_methods.push php_method('doWidget', "return $this->oListWidget->doWidget('#{module_name}');")
			php_methods.push php_method('getColumnIdentifiers', 'return array();')
			php_methods.push php_method('getMetadataForColumn', '', ['aColumnIdentifier'])
			php_methods.push php_method('getDatabaseColumnForColumn', '', ['aColumnIdentifier'])
			php_methods.push php_method('getCriteria', '$oCriteria = new Criteria();
		return $oCriteria;')
		end
		
		php_methods.push php_method('__construct', "parent::__construct($sSessionKey);
		#{constructor_content}", ['sSessionKey = null']) if $aspects.include? 'persistent'
		php_methods.push php_method('__construct', constructor_content) unless $aspects.include? 'persistent'
	elsif $options[:type] == :frontend then
		php_methods.push php_method('__construct', 'parent::__construct($oLanguageObject, $aRequestPath, $iId);', ['LanguageObject $oLanguageObject = null', 'aRequestPath = null', 'iId = 1'])
		php_methods.push php_method('renderFrontend')
	elsif $options[:type] == :admin then
		widgets = {}
		widgets[:sidebar_widget] = '$this->oSidebarWidget' unless $aspects.include? 'single_screen'
		widgets[:content_widget] = '$this->oMainWidget'
		constructor_content = ""
		widgets.each_pair do |widget, field|
			php_methods.push php_field(field)
			constructor_content += "#{field} = WidgetModule::getWidget('#{$options[widget]}');
		"
		end
		php_methods.push php_method('__construct', constructor_content)
		retnull = 'return null;'
		php_methods.push php_method('mainContent', "return $this->oMainWidget->doWidget();")
		php_methods.push php_method('sidebarContent', "return $this->oSidebarWidget->doWidget();") unless $aspects.include? 'single_screen'
		php_methods.push php_method('sidebarContent', 'return false;') if $aspects.include? 'single_screen'
		php_methods.push php_method('usedWidgets', "return array(#{widgets.values.join(', ')});")
	elsif $options[:type] == :filter then
		php_methods.push unboxing_php_filter_method('onAnyError', ['aError'])
		php_methods.push unboxing_php_filter_method('onErrorEmailSend', ['sAddress'])
		php_methods.push unboxing_php_filter_method('onErrorLog', ['sLogFilePath', 'aError', 'sErrorMessage', 'iMode', 'sDestination'])
		php_methods.push unboxing_php_filter_method('onErrorPrint', ['aError'])
		php_methods.push php_method('onNavigationPathFound', '', ['oRootNavigationItem', 'oMatchingNavigationItem'])
		php_methods.push php_method('onPageHasBeenSet', '', ['oCurrentPage', 'bIsNotFound', 'oCurrentNavigationItem'])
		php_methods.push unboxing_php_filter_method('onPageNotFoundDetectionComplete', ['bIsNotFoundMutable'], '', ['bIsNotFound', 'oCurrentPage', 'oCurrentNavigationItem', 'aContainer'])
		php_methods.push php_method('onPageNotFound')
		php_methods.push php_method('onBeforePageFill', '', ['oCurrentPage', 'oTemplate'])
		php_methods.push unboxing_php_filter_method('onRequestFinished', ['oCurrentPage', 'bIsDynamic', 'bIsAjaxRequest', 'bIsCached'])
		php_methods.push php_method('onFillPageAttributes', '', ['oCurrentPage', 'oTemplate'])
		php_methods.push php_method('onFillPageAttributesFinished', '', ['oCurrentPage', 'oTemplate'])
		php_methods.push php_method('onNavigationItemChildrenRequested', '', ['oNavigationItem'])
		php_methods.push unboxing_php_filter_method('onRichtextWriteTagForIdentifier', ['aParameters'], '', ['sTagName', 'aContainer', 'oIdentifier', 'sTagContent', 'mCallbackContext'])
		php_methods.push unboxing_php_filter_method('onUserLoggedIn', ['iUserLoginBitmap'], '', ['oUser', 'aContainer'])
		php_methods.push php_method('onDefaultPageTypeFilledContainer', '', ['oContainer', 'oPage', '$oTemplate', 'oFrontendTemplate', 'iModuleId'])
		php_methods.push php_method('onDefaultPageTypeFilledContainerWithModule', '', ['oContentObject', 'oModule', '$oTemplate', 'oFrontendTemplate', 'iModuleId'])
		php_methods.push unboxing_php_filter_method('onMailGroups', ['aMailGroups'])
		php_methods.push unboxing_php_filter_method('onMailGroupsRecipients', ['aRecipients'], '', ['aMailGroups', 'aContainer'])
	elsif $options[:type] == :file then
		php_methods.push php_method('__construct', 'parent::__construct($aRequestPath);', ['aRequestPath'])
			php_methods.push php_method('renderFile')
	end
	
	"<?php
class #{class_name} extends #{extends}#{implements} {
	#{php_methods.sort.join('
	
	')}
}"
end

write_file(:yaml, 'info.yml') do |f|
	info = {}
	info['description'] = $options[:description] if $options[:description]
	info['version'] = $options[:version] if $options[:version]
	info['aspects'] = $aspects.to_a unless $aspects.empty?
	info['enabled'] = $options[:enabled]
	YAML.dump(info, f)
end

write_file(:js, "#{module_name}.#{$options[:type]}.js.tmpl", 'templates') do
	if $options[:type] == :widget then
		res = "initialize: function() {
		
	},

	prepare: function() {
		
	},
	
	settings: {
		
	}"
		"Widget.types['#{module_name}'] = {
	#{res}
}"
	elsif $options[:type] == :admin then
		res = ""
		res += "var sidebar;
	" unless $aspects.include? "single_screen"
		res += "var content;
	"
		res += "AdminInterface.sidebar.children('[data-widget-type]').prepareWidget(function(widget) {
		sidebar = widget;
	});
	" unless $aspects.include? "single_screen" 
		
		res += "AdminInterface.content.children('[data-widget-type]').prepareWidget(function(widget) {
		content = widget;
	});
	"

		"jQuery(function() {
	#{res}
});"		
	end
end

write_file(:css, "#{module_name}.#{$options[:type]}.css.tmpl", 'templates') do
	if $options[:type] == :widget then
		res = "*[data-widget-type='#{module_name}'] {
	
}"
		if $aspects.include? 'detail' then
			res = "#{res}

.ui-dialog.detail-widget-#{module_name} {
	
}

.ui-dialog.detail-widget-#{module_name} .ui-dialog-content {
	
}"
		end
		if $aspects.include? 'dashboard' then
			res = "#{res}

.dashboard-widget-content > *[data-widget-type='#{module_name}'] {
	
}"
		end
		res
	elsif $options[:type] == :admin then
		res = "body.#{module_name} #admin_main {
	
}"
		if not $aspects.include? 'single_screen' then
			res = "#{res}

body.#{module_name} #admin_sidebar {
	
}"
		end
		res
	end
end