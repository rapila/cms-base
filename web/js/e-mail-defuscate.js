//Transform mailto-links
document.addEventListener('DOMContentLoaded', function() {
	[].forEach.call(document.querySelectorAll('.mailto_link'), function(link) {
		var link_address = link.getAttribute('href');
		link_address = link_address.replace(/!/g, ".");
		link_address = link_address.replace(/\^/g, "@");
		link_address = "mailto:"+link_address;
		link.href = link_address;
	});
}, false);
