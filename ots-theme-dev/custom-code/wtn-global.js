// Global shorthand for using jQuery in Wordpress
var $j = jQuery.noConflict();

// Global brand object
var WTN = WTN || {

	// timezone offset in minutes - set in wtn-city-[cityname].js
	timeOffset: 0,
	
	apiServerPath: '',
	apiDataTypePath: '',
	apiDataTypeId: '',

	venueData: {},
	$newHoursRow: {},
	eventProps: {},
	$newEventRow: {},

	mapZoomLevel: 14,

	getInfoData: function(callbacks) {
		var apiPath = WTN.apiServerPath + WTN.apiDataTypePath + WTN.apiDataTypeId;

		$j.getJSON(apiPath, function(data) {
			WTN.venueData = data;

			if (callbacks) {
				callbacks.call();
			}
		});
	},

	parseEventsData: function() {
		var apiPath = WTN.apiServerPath + WTN.apiDataTypePath + WTN.apiDataTypeId + '/events';

		$j.getJSON(apiPath,
			function(data) {
				WTN.populateEventsList(data);
			})
			.fail(function() {
				WTN.showNoEventsBlock();
			});
	},

	parsePhotosData: function() {
		var apiPath = WTN.apiServerPath + WTN.apiDataTypePath + WTN.apiDataTypeId + '/photos';

		$j.getJSON(apiPath,
			function(data) {
				WTN.populatePhotos(data);
			})
			.fail(function() {
				WTN.hideLoaderIcon('.wtn-photos');
			});
	},

	populateSocialLinks: function() {
		var socialLinks = {
			email: WTN.venueData.email,
			facebook: WTN.venueData.facebookUrl,
			instagram: WTN.venueData.instagramHandle,
			twitter: WTN.venueData.twitterHandle,
			web: WTN.venueData.website
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

		WTN.hideLoaderIcon('.wtn-social');
	},

	hideLoaderIcon: function(container) {
		$j(container)
			.find('.loader')
				.addClass('hidden');
	},

	populateVenueInfo: function() {
		var venueInfo = {
			name: WTN.venueData.name,
			address: WTN.venueData.streetAddress,
			phone: WTN.venueData.phoneNumber,
			hours: WTN.venueData.hours
		};

		$j.each(venueInfo, function(param, value) {
		    if (!value) {
		    	return;
		    }
		    	
	    	WTN.parseVenueParam(param, value);
		});

		WTN.hideLoaderIcon('.wtn-venue-info');
	},

	parseVenueParam: function(param, value) {
		var phoneLink = '<a href="tel:' + value + '">' + value + '</a>',
			$venueParamDataCell = $j('.wtn-venue-info-' + param);

		if (param === 'hours') {
			$j.each(value, function(i, hoursEntry) {
	    		WTN.parseVenueHours(hoursEntry);
	    	});
		}
		else {
			if (param === 'phone') {
				value = phoneLink;
			}

			$venueParamDataCell.html(value);
		}

		$venueParamDataCell.removeClass('hidden')
	},

	parseVenueHours: function(hoursEntry) {
		WTN.$newHoursRow = $j('.wtn-venue-info-hours-proto')
				    			.clone()
				    				.addClass('wtn-venue-info-hours-entry')
				    				.removeClass('wtn-venue-info-hours-proto hidden');
		
		WTN.addNewHoursCell(hoursEntry.openingDay);
		WTN.formatVenueHoursTime(hoursEntry.openingTime);
		WTN.addTimeTo();
		WTN.formatVenueHoursTime(hoursEntry.closingTime);
		
		WTN.$newHoursRow.appendTo('.wtn-venue-info-hours table tbody');
	},

	formatVenueHoursTime: function(value) {
		var timeIncludesColon = (value.indexOf(':') > -1),
			timesSplitByColon = value.split(':'),
			timesSplitWithoutColon = [value.slice(0,2), value.slice(3,5)],
			timeParts = (timeIncludesColon) ? timesSplitByColon : timesSplitWithoutColon,
			timeObj = moment({
				hour: timeParts[0],
				minute: timeParts[1]
			}),
			displayValue = (timeObj.isValid()) ? timeObj.format('h:mm a') : '';
		
		WTN.addNewHoursCell(displayValue);
	},

	addNewHoursCell: function(displayValue) {
		WTN.$newHoursRow
			.find('.wtn-venue-info-hours-data-proto')
				.clone()
					.addClass('wtn-venue-info-hours-data')
					.html(displayValue)
					.removeClass('wtn-venue-info-hours-data-proto hidden')
					.appendTo(WTN.$newHoursRow);
	},

	addTimeTo: function() {
		WTN.$newHoursRow
			.find('.wtn-venue-info-hours-data-proto')
				.clone()
					.html('to')
					.removeClass('wtn-venue-info-hours-data-proto hidden')
					.appendTo(WTN.$newHoursRow);
	},

	populateMap: function() {
		var noCoords = (!WTN.venueData.latitude || !WTN.venueData.longitude);

		if (noCoords) {
			$j('.wtn-map-row').addClass('hidden');
			return;
		}

		var venueCoords = new google.maps.LatLng(WTN.venueData.latitude, WTN.venueData.longitude),

			mapOptions = {
				center: venueCoords,
		        zoom: WTN.mapZoomLevel
			},

			map = new google.maps.Map($j('.wtn-map').get(0), mapOptions),

			marker = new google.maps.Marker({
				position: venueCoords,
				map: map,
				title: WTN.venueData.name
			});

		WTN.hideLoaderIcon('.wtn-map-container');
	},

	populateEventsList: function(data) {
		if (data.length < 1) {
			WTN.showNoEventsBlock();
			return;
		}

		$j.each(data, function(i, thisEvent) {
			WTN.parseEvent(thisEvent);
		});
	},

	showNoEventsBlock: function() {
		$j('.wtn-events-none').removeClass('hidden');
		WTN.hideLoaderIcon('.wtn-events');
	},

	parseEvent: function(thisEvent) {
		WTN.createEventPropsObj(thisEvent);
		WTN.setEventDateOnly();
		WTN.removeEventDateFromEarlyMorningEndTime();
		WTN.createNewEventRow(thisEvent);
		WTN.wrapEventItemsInAnchors(thisEvent);
		WTN.appendNewEventRow();
		WTN.hideLoaderIcon('.wtn-events');
	},

	createEventPropsObj: function(thisEvent) {
		WTN.eventProps = new function() {
			this.localTimeOffset = moment().utcOffset();
			this.eventTimeOffset = WTN.timeOffset;
			this.displayTimeOffset = this.eventTimeOffset - this.localTimeOffset;

			this.dateAndTimeFormat = 'dddd, MMMM Do YYYY,<br />h:mma';
			this.fullDateOnlyFormat = 'dddd, MMMM Do YYYY';
			this.monthOnlyFormat = 'MMM';
			this.dateOnlyFormat = 'D';
			this.dayOnlyFormat = 'ddd';
			this.timeOnlyFormat = 'h:mma';

			this.startTime = moment(thisEvent.startTime);
			this.startTimeCorrected = moment(thisEvent.startTime).add(this.displayTimeOffset, 'minutes');
			this.startTimeHasHours = this.startTime.hour();
			this.startTimeStr = '';

			this.endTime = moment(thisEvent.endTime);
			this.endTimeCorrected = this.endTime.add(this.displayTimeOffset, 'minutes');
			this.endTimeStr = '';

			this.endTimeIsSameDateAsStartTime = moment(this.startTimeCorrected).isSame(this.endTimeCorrected, 'day');
			this.endTimeIsBefore5Am = (moment(this.endTimeCorrected).hour() < 5);

			this.month = this.startTimeCorrected.format(this.monthOnlyFormat);
			this.date = this.startTimeCorrected.format(this.dateOnlyFormat);
			this.day = this.startTimeCorrected.format(this.dayOnlyFormat);
			this.timeOnly = this.startTimeCorrected.format(this.timeOnlyFormat);
		};
	},

	setEventDateOnly: function() {
		if (WTN.eventProps.startTimeHasHours) {
			WTN.eventProps.startTimeStr = WTN.eventProps.startTimeCorrected.format(WTN.eventProps.dateAndTimeFormat);
		}
		else {
			WTN.eventProps.startTimeStr = WTN.eventProps.startTimeCorrected.format(WTN.eventProps.fullDateOnlyFormat);
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
		WTN.initNewEventRow();
		WTN.addEventRowDate();
		WTN.addEventRowMonth();
		WTN.addEventRowName(thisEvent);
		WTN.addEventRowDay();
		WTN.addEventRowLocation(thisEvent);
		WTN.addEventRowPrice(thisEvent);
	},

	initNewEventRow: function() {
		WTN.$newEventRow = $j('.wtn-events-event-proto')
								.clone()
				    				.addClass('wtn-events-event')
				    				.removeClass('wtn-events-event-proto');
	},

	addEventRowDate: function() {
		WTN.$newEventRow
			.find('.wtn-events-event-date-date')
		    	.html(WTN.eventProps.date);
	},

	addEventRowMonth: function() {
		WTN.$newEventRow
			.find('.wtn-events-event-date-month')
		    	.html(WTN.eventProps.month);
	},

	addEventRowName: function(thisEvent) {
		WTN.$newEventRow
			.find('.wtn-events-event-name-name')
			    .html(thisEvent.name);
	},

	addEventRowDay: function() {
		WTN.$newEventRow
			.find('.wtn-events-event-name-day')
		    	.html(WTN.eventProps.day + ' ' + WTN.eventProps.timeOnly);
	},

	addEventRowLocation: function(thisEvent) {
		WTN.$newEventRow
			.find('.wtn-events-event-location')
				.each(function() {
					var $locationCell = $j(this);

					if (thisEvent.place && WTN.apiDataTypePath === 'series/') {
						if (thisEvent.place.name) {
							$locationCell
								.html(thisEvent.place.name)
								.removeClass('hidden');
						}

						if (thisEvent.place.id) {
							WTN.venueId = thisEvent.place.id;
							
							WTN.getInfoData();

							$locationCell
								.wrapInner('<a></a>')
								.find('a')
									.attr('href', '#'); //[VENUE PAGE URL WILL GO HERE]
						}
					}
				});
	},

	addEventRowPrice: function(thisEvent) {
		WTN.$newEventRow
			.find('.wtn-events-event-price span')
				.each(function() {
					var $locationCell = $j(this);

					if (thisEvent.place) {
						if (thisEvent.place.name) {
							$locationCell
								.find('span')
									.html(thisEvent.place.name)
									.removeClass('hidden');
						}
					}
				})
				.html(thisEvent.price);
	},

	wrapEventItemsInAnchors: function(thisEvent) {
		if (thisEvent.url) {
			WTN.$newEventRow
				.find('.wtn-events-event-name')
					.wrapInner('a')
					.find('a')
						.attr('href', thisEvent.url)
						.end()
					.end()
				.find('.wtn-events-event-date')
					.wrapInner('a')
					.find('a')
						.attr('href', thisEvent.url);
		}
	},

	appendNewEventRow: function() {
		WTN.$newEventRow
			.appendTo('.wtn-events-table')
			.removeClass('hidden');
	},

	populatePhotos: function(data) {
		if (data.length < 1) {
			WTN.hideLoaderIcon('.wtn-photos');
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
					.appendTo('.wtn-photos ul')
					.removeClass('hidden');
		});

		WTN.hideLoaderIcon('.wtn-photos');
	},

	populateEventsHeader: function() {
		var venueName = $j('h1.cb-entry-title').html();

		$j('.wtn-events-header span').html(venueName);
	}
};