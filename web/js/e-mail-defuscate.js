//Transform mailto-links
jQuery(document).ready(function() {
	jQuery(".mailto_link").each(function() {
		var link = jQuery(this);
		var link_address = link.attr("href");
		link_address = link_address.replace(/!/g, ".");
		link_address = link_address.replace(/\^/g, "@");
		link_address = "mailto:"+link_address;
		link.attr("href", link_address);
	});
});
