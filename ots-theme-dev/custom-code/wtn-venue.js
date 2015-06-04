$j(function() {

	(function populateEventsHeader() {
		var venueName = $j('h1.cb-entry-title').html();

		$j('.wtn-events-header span').html(venueName);
	})();
	
	$j.getJSON('http://alpha.walkthenight.com/api/venues/' + WTN.venueId, function(data) {
		console.log('venue:',data);

		WTN.populateSocialLinks(data);
		WTN.populateVenueInfo(data);
		WTN.populateMap(data);
	});

	$j.getJSON('http://alpha.walkthenight.com/api/venues/' + WTN.venueId + '/events', function(data) {
		WTN.populateEventsList(data);
	});

	$j.getJSON('http://alpha.walkthenight.com/api/venues/' + WTN.venueId + '/photos', function(data) {
		WTN.populatePhotos(data);
	});

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
		    			var displayValue = value,
		    				timeParts = value.split(':'),
		    				timeObj = moment({
		    					hour: timeParts[0],
		    					minute: timeParts[1]
		    				});

		    			if (timeObj.isValid()) {
							displayValue = timeObj.format('h:mm a');
						}

		    			$newHoursRow
		    				.find('.wtn-venue-info-hours-data-proto')
		    					.clone()
		    						.addClass('wtn-venue-info-hours-data')
		    						.removeClass('wtn-venue-info-hours-data-proto hidden')
		    						.html(displayValue)
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
	var mapOptions = {
			center: {
				lat: data.latitude,
				lng: data.longitude
			},
	        zoom: 8
		},
		map = new google.maps.Map($j('.wtn-map').get(0), mapOptions);
};

WTN.populateEventsList = function(data) {
	if (data.length > 0) {
		$j.each(data, function(i, thisEvent) {
			var localTimeOffset = moment().utcOffset(),
				eventTimeOffset = WTN.timeOffset,
				displayTimeOffset = eventTimeOffset - localTimeOffset,
				dateAndTimeFormat = 'dddd, MMMM Do YYYY,<br />h:mma',
				dateOnlyFormat = 'dddd, MMMM Do YYYY',
				timeOnlyFormat = 'h:mma',

				startTime = moment(thisEvent.startTime),
				startTimeCorrected = moment(thisEvent.startTime).add(displayTimeOffset, 'minutes'),
				startTimeHasHours = startTime.hour(),
				startTimeStr,
				endTime = moment(thisEvent.endTime),
				endTimeCorrected = endTime.add(displayTimeOffset, 'minutes'),
				endTimeStr = '',

				endTimeIsSameDateAsStartTime = moment(startTimeCorrected).isSame(endTimeCorrected, 'day'),
				endTimeIsBefore5Am = (moment(endTimeCorrected).hour() < 5),
				
				$newEventRow;

			if (startTimeHasHours) {
				startTimeStr = startTimeCorrected.format(dateAndTimeFormat);
			}
			else {
				startTimeStr = startTimeCorrected.format(dateOnlyFormat);
			}

			if (endTime.isValid()) {
				if (endTimeIsSameDateAsStartTime || endTimeIsBefore5Am) {
					endTimeStr = ' to ' + endTimeCorrected.format(timeOnlyFormat);
				}
				else {
					endTimeStr = '<br />to<br />' + endTimeCorrected.format(dateAndTimeFormat);
				}
			}

			$newEventRow = $j('.wtn-events-event-proto')
								.clone()
				    				.addClass('wtn-events-event')
				    				.removeClass('wtn-events-event-proto')
			    					.find('.wtn-events-event-name')
			    						.html(thisEvent.name)
			    						.end()
			    					.find('.wtn-events-event-date')
			    						.html(startTimeStr + endTimeStr)
			    						.end()
			    					.find('.wtn-events-event-price span')
				    					.html(thisEvent.price)
				    					.end();
					    					
			if (thisEvent.url) {
				$newEventRow
					.find('.wtn-events-event-name')
						.wrapInner('a')
						.find('a')
    						.attr('src', thisEvent.url)
    						.end()
    					.end()
					.find('.wtn-events-event-date')
						.wrapInner('a')
						.find('a')
    						.attr('src', thisEvent.url);
			}

			$newEventRow
				.appendTo('.wtn-events')
				.removeClass('hidden');
		});
	}
	else {
		$j('.wtn-events-none').removeClass('hidden');
	}
};

WTN.populatePhotos = function(data) {
	if (data.length > 0) {
		$j.each(data, function(i, photoUrl) {
			$j('.wtn-photos-img-proto')
				.clone()
    				.addClass('wtn-photos-img')
    				.removeClass('wtn-photos-img-proto')
					.find('img')
						.attr('src', photoUrl)
						.end()
					.appendTo('.wtn-photos')
					.removeClass('hidden');
		});
	}
};