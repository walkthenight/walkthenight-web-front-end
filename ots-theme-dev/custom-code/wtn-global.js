// Global shorthand for using jQuery in Wordpress
var $j = jQuery.noConflict();

// Global brand object
var WTN = WTN || {
	// minutes in timezone offset - change according to location of WTN install
	timeOffset: -420,

	parseVenueInfoData: function() {
		$j.getJSON('http://alpha.walkthenight.com/api/venues/' + this.venueId, function(data) {
			console.log('venue:',data);

			WTN.populateSocialLinks(data);
			WTN.populateVenueInfo(data);
			WTN.populateMap(data);
		});
	},

	parseEventsData: function() {
		$j.getJSON('http://alpha.walkthenight.com/api/venues/' + this.venueId + '/events', function(data) {
			WTN.populateEventsList(data);
		});
	},

	parsePhotosData: function() {
		$j.getJSON('http://alpha.walkthenight.com/api/venues/' + this.venueId + '/photos', function(data) {
			WTN.populatePhotos(data);
		});
	},

	populateSocialLinks: function(data) {
		var socialLinks = {
			email: data.email,
			facebook: data.facebookUrl,
			instagram: data.instagramHandle,
			twitter: data.twitterHandle,
			web: data.website
		};

		$j.each(socialLinks, function(key, value) {
		    if (!value) {
		    	return;
		    }

			$j('.wtn-social-' + key)
				.find('a')
					.attr('href', value)
					.end()
				.removeClass('hidden');
		});
	},

	populateVenueInfo: function(data) {
		var venueInfo = {
			address: data.streetAddress,
			phone: data.phoneNumber,
			hours: data.hours
		};

		$j.each(venueInfo, function(param, value) {
		    if (!value) {
		    	return;
		    }
		    	
	    	WTN.parseVenueParams(param, value);
		});
	},

	parseVenueParams: function(param, value) {
		if (param === 'hours') {
			$j.each(value, function(i, hoursEntry) {
	    		WTN.parseVenueHours(hoursEntry);
	    	});

			$j('.wtn-venue-info-hours').removeClass('hidden');
		}
		else {
			$j('.wtn-venue-info-' + param)
				.html(value)
				.removeClass('hidden');
		}
	},

	parseVenueHours: function(hoursEntry) {
		WTN.$newHoursRow = $j('.wtn-venue-info-hours-proto')
				    			.clone()
				    				.addClass('wtn-venue-info-hours-entry')
				    				.removeClass('wtn-venue-info-hours-proto hidden');

		$j.each(hoursEntry, function(key, value) {
			WTN.parseVenueHoursRow(key, value);
		});
		
		WTN.$newHoursRow.appendTo('.wtn-venue-info-hours table tbody');
	},

	parseVenueHoursRow: function(key, value) {
		var timeParts = value.split(':'),
			timeObj = moment({
				hour: timeParts[0],
				minute: timeParts[1]
			}),
			displayValue = value;

		if (timeObj.isValid()) {
			displayValue = timeObj.format('h:mm a');
		}
		
		WTN.addNewHoursRow(displayValue);
	},

	addNewHoursRow: function(displayValue) {
		WTN.$newHoursRow
			.find('.wtn-venue-info-hours-data-proto')
				.clone()
					.addClass('wtn-venue-info-hours-data')
					.removeClass('wtn-venue-info-hours-data-proto hidden')
					.html(displayValue)
					.appendTo(WTN.$newHoursRow);
	},

	populateMap: function(data) {
		var mapOptions = {
				center: {
					lat: data.latitude,
					lng: data.longitude
				},
		        zoom: 8
			},
			map = new google.maps.Map($j('.wtn-map').get(0), mapOptions);
	},

	populateEventsList: function(data) {
		if (data.length < 1) {
			$j('.wtn-events-none').removeClass('hidden');
			return;
		}

		$j.each(data, function(i, thisEvent) {
			WTN.parseEvent(thisEvent);
		});
	},

	parseEvent: function(thisEvent) {
		WTN.createEventPropsObj(thisEvent);
		WTN.setEventDateOnly();
		WTN.removeEventDateFromEarlyMorningEndTime();
		WTN.createNewEventRow(thisEvent);
		WTN.wrapEventItemsInAnchors(thisEvent);
		WTN.apendNewEventRow();
	},

	createEventPropsObj: function(thisEvent) {
		WTN.eventProps = new function() {
			this.localTimeOffset = moment().utcOffset();
			this.eventTimeOffset = WTN.timeOffset;
			this.displayTimeOffset = this.eventTimeOffset - this.localTimeOffset;
			this.dateAndTimeFormat = 'dddd, MMMM Do YYYY,<br />h:mma';
			this.dateOnlyFormat = 'dddd, MMMM Do YYYY';
			this.timeOnlyFormat = 'h:mma';

			this.startTime = moment(thisEvent.startTime);
			this.startTimeCorrected = moment(thisEvent.startTime).add(this.displayTimeOffset, 'minutes');
			this.startTimeHasHours = this.startTime.hour();
			this.endTime = moment(thisEvent.endTime);
			this.endTimeCorrected = this.endTime.add(this.displayTimeOffset, 'minutes');
			this.endTimeStr = '';

			this.endTimeIsSameDateAsStartTime = moment(this.startTimeCorrected).isSame(this.endTimeCorrected, 'day');
			this.endTimeIsBefore5Am = (moment(this.endTimeCorrected).hour() < 5);
		};
	},

	setEventDateOnly: function() {
		if (WTN.eventProps.startTimeHasHours) {
			WTN.eventProps.startTimeStr = WTN.eventProps.startTimeCorrected.format(WTN.eventProps.dateAndTimeFormat);
		}
		else {
			WTN.eventProps.startTimeStr = WTN.eventProps.startTimeCorrected.format(WTN.eventProps.dateOnlyFormat);
		}
	},

	removeEventDateFromEarlyMorningEndTime: function() {
		if (WTN.eventProps.endTime.isValid()) {
			if (WTN.eventProps.endTimeIsSameDateAsStartTime || WTN.eventProps.endTimeIsBefore5Am) {
				WTN.eventProps.endTimeStr = ' to ' + WTN.eventProps.endTimeCorrected.format(WTN.eventProps.timeOnlyFormat);
			}
			else {
				WTN.eventProps.endTimeStr = '<br />to<br />' + WTN.eventProps.endTimeCorrected.format(WTN.eventProps.dateAndTimeFormat);
			}
		}
	},

	createNewEventRow: function(thisEvent) {
		WTN.$newEventRow = $j('.wtn-events-event-proto')
								.clone()
				    				.addClass('wtn-events-event')
				    				.removeClass('wtn-events-event-proto')
			    					.find('.wtn-events-event-name')
			    						.html(thisEvent.name)
			    						.end()
			    					.find('.wtn-events-event-date')
			    						.html(WTN.eventProps.startTimeStr + WTN.eventProps.endTimeStr)
			    						.end()
			    					.find('.wtn-events-event-price span')
				    					.html(thisEvent.price)
				    					.end();
	},

	wrapEventItemsInAnchors: function(thisEvent) {
		if (thisEvent.url) {
			WTN.$newEventRow
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
	},

	apendNewEventRow: function() {
		WTN.$newEventRow
			.appendTo('.wtn-events')
			.removeClass('hidden');
	},

	populatePhotos: function(data) {
		if (data.length < 1) {
			return;
		}

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