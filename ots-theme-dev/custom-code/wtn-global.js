var $j = jQuery.noConflict();	// Global var: shorthand for using jQuery in Wordpress

// Global brand object
var WTN = WTN || {

	timeOffset: 0,	// timezone offset in minutes - set in wtn-city-[cityname].js
	
	apiServerPath: '',
	apiDataTypePath: '',
	apiDataTypeId: '',

	venueData: {},
	$newHoursRow: {},
	eventProps: {},
	$newEventRow: {},

	seriesData: {},

	eventData: {},
	eventId: '',
	eventsTimeframe: '?timeframe=future',	// which events get requested from FB API call :: Value = future|past|all[default]
	seriesAssociatedWithEvent: [],

	mapZoomLevel: 14,

	getMainData: function(callbacks) {
		var apiPath = WTN.apiServerPath + WTN.apiDataTypePath + WTN.apiDataTypeId;

		$j.getJSON(apiPath,
			function(data) {
				if (WTN.apiDataTypePath === 'venues/') {
					WTN.venueData = data;
				}
				else if (WTN.apiDataTypePath === 'series/') {
					WTN.seriesData = data;
				}

				WTN.doCallbacksIfData(data, callbacks);
			})
			.fail(function() {
				WTN.hideLoaderIcon('.wtn-social');
			});
	},

	doCallbacksIfData: function(data, callbacks) {
		if (data && callbacks) {
			callbacks.call();
		}
	},

	parseEventsData: function(apiId) {
		var apiPath = WTN.apiServerPath + WTN.apiDataTypePath + apiId + '/events' + WTN.eventsTimeframe;

		$j.getJSON(apiPath,
			function(data) {
				WTN.populateEventsList(data);
			})
			.fail(function() {
				WTN.hideEventsBlock();
			});
	},

	// TO DO: Loop all series in array to pull more photos (for event page)
	parsePhotosData: function(apiId) {
		var apiPath = WTN.apiServerPath + WTN.apiDataTypePath + apiId + '/photos';

		$j.getJSON(apiPath,
			function(data) {
				WTN.populatePhotos(data);
			})
			.fail(function() {
				WTN.hideLoaderIcon('.wtn-photos');
			});
	},

	getMatchingSeriesIds: function(eventId, callbacks) {
		var apiPath = WTN.apiServerPath + WTN.apiDataTypePath + eventId + '/series';

		$j.getJSON(apiPath, function(data) {
			WTN.seriesAssociatedWithEvent = data[0];	// only use first returned series ID for now

			WTN.doCallbacksIfData(data, callbacks);
		});
	},

	parseSingleEventData: function(seriesId) {
		var apiPath = WTN.apiServerPath + WTN.apiDataTypePath + WTN.apiDataTypeId;

		$j.getJSON(apiPath,
			function(data) {
				WTN.populateEventData(data, seriesId);
			})
			.fail(function() {
				WTN.hideLoaderIcon('.wtn-photos');
			});

		WTN.apiDataTypePath = 'series/';
		WTN.apiDataTypeId = seriesId;
		
		WTN.getMainData(function() {
			WTN.populateSocialLinks();
		});
	},

	populateEventData: function(data, seriesId) {
		WTN.eventData = data;
		WTN.venueData = data.place;

		WTN.populateMainImage();
		WTN.populateName();
		WTN.populateDescription();
		WTN.populateVenueInfo();
		WTN.populateMap();

		WTN.apiDataTypePath = 'series/';

		WTN.parsePhotosData(seriesId);
	},

	populateMainImage: function() {
		$j.backstretch(WTN.eventData.picture, {fade: 1200});

		$j('.wtn-event-cover-image').attr('src', WTN.eventData.picture);
	},

	populateName: function() {
		$j('h1.cb-entry-title')
			.html(WTN.eventData.name)
			.removeClass('indentHide loaderBg');
	},

	populateDescription: function() {
		$j('.wtn-event-blurb').html(WTN.eventData.description);
	},

	populateSocialLinks: function() {
		var mainData;

		if (WTN.apiDataTypePath === 'venues/') {
			mainData = WTN.venueData;
		}
		else if (WTN.apiDataTypePath === 'series/') {
			mainData = WTN.seriesData;
		}

		if (mainData) {

			var socialLinks = {
				email: (mainData.email) ? 'mailto:' + mainData.email : undefined,
				facebook: (mainData.facebookUrl) ? mainData.facebookUrl : mainData.facebookPage,
				instagram: (mainData.instagramHandle) ? 'https://instagram.com/' + mainData.instagramHandle : undefined,
				twitter: (mainData.twitterHandle) ? 'https://twitter.com/' + mainData.twitterHandle : undefined,
				web: mainData.website
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
		}

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
		WTN.createNewHoursRow();
		WTN.addNewHoursCell(hoursEntry.openingDay);
		WTN.formatVenueHoursTime(hoursEntry.openingTime);
		WTN.addTimeTo();
		WTN.formatVenueHoursTime(hoursEntry.closingTime);
		
		WTN.$newHoursRow.appendTo('.wtn-venue-info-hours table tbody');
	},

	createNewHoursRow: function() {
		WTN.$newHoursRow = $j('.wtn-venue-info-hours-proto')
				    			.clone()
				    				.addClass('wtn-venue-info-hours-entry')
				    				.removeClass('wtn-venue-info-hours-proto hidden');
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

		var latitude = WTN.venueData.latitude,
			longitude = WTN.venueData.longitude,
			venueCoords = new google.maps.LatLng(latitude, longitude),

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
			WTN.hideEventsBlock();
			return;
		}

		$j.each(data, function(i, thisEvent) {
			WTN.parseEvent(thisEvent);
		});
	},

	hideEventsBlock: function() {
		$j('.wtn-events').addClass('hidden');
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

						if (thisEvent.wtnVenueUrl) {
							var venueFullUrl = '/' + WTN.cityPath + '/venues/' + thisEvent.wtnVenueUrl;

							$locationCell
								.wrapInner('<a></a>')
								.find('a')
									.attr('target', '_blank')
									.attr('href', venueFullUrl);
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
		if (!thisEvent.wtnManagedEventUrlName && !thisEvent.id) {
			return;
		}

		var eventUrlSuffix = (thisEvent.wtnManagedEventUrlName) ? thisEvent.wtnManagedEventUrlName : '#' + thisEvent.id,
			eventUrl = '/' + WTN.cityPath + '/event/' + eventUrlSuffix;

		WTN.$newEventRow
			.find('.wtn-events-event-name-name')
				.wrapInner('<a></a>')
				.find('a')
					.attr('href', eventUrl)
					.end()
				.end()
			.find('.wtn-events-event-date')
				.wrapInner('<a></a>')
				.find('a')
					.attr('href', eventUrl);
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
		var headerName = $j('h1.cb-entry-title').html();

		if (!headerName) {
			return;
		}

		$j('.wtn-events-header span').html(headerName);
	}
};