$j(function() {
	$j.getJSON('http://alpha.walkthenight.com/api/venues/' + WTN.venueId, function(data) {
		console.log(data);

		WTN.populateSocialLinks(data);
		WTN.populateVenueInfo(data);
		WTN.populateMap(data);
		WTN.populateEventsList(data);
		WTN.populatePhotos(data);
	});

	WTN.populateSocialLinks = function(data) {
		var socialLinks = {
			email: data.email,
			facebook: data.facebookUrl,
			instagram: data.instagramHandle,
			twitter: data.twitterHandle,
			web: data.website
		};

		$j.each(socialLinks, function(key, value) {
		    if (value) {
				$j('.wtn-social-' + key)
					.find('a')
						.attr('href', value)
						.end()
					.removeClass('hidden');
			}
		});
	};

	WTN.populateVenueInfo = function(data) {
		var venueInfo = {
			address: data.streetAddress,
			phone: data.phoneNumber,
			hours: data.hours
		};

		$j.each(venueInfo, function(key, value) {
		    if (value) {
		    	if (key === 'hours') {
		    		$j.each(value, function(i, hoursEntry) {
			    		var $newHoursRow = $j('.wtn-venue-info-hours-proto')
								    			.clone()
								    				.addClass('wtn-venue-info-hours-entry')
								    				.removeClass('wtn-venue-info-hours-proto hidden');

			    		$j.each(hoursEntry, function(key, value) {
			    			$newHoursRow
			    				.find('.wtn-venue-info-hours-data-proto')
			    					.clone()
			    						.addClass('wtn-venue-info-hours-data')
			    						.removeClass('wtn-venue-info-hours-data-proto hidden')
			    						.html(value)
			    						.appendTo($newHoursRow);
			    		});
			    		
			    		$newHoursRow.appendTo('.wtn-venue-info-hours table tbody');
			    	});

		    		$j('.wtn-venue-info-hours').removeClass('hidden');
		    	}
		    	else {
					$j('.wtn-venue-info-' + key)
						.html(value)
						.removeClass('hidden');
		    	}
			}
		});
	};

	WTN.populateMap = function(data) {

	};

	WTN.populateEventsList = function(data) {

	};

	WTN.populatePhotos = function(data) {

	};
});