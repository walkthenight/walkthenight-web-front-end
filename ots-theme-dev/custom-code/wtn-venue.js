$j(function() {

	WTN.populateEventsHeader();

	WTN.apiDataTypePath = 'venues/';
	WTN.apiDataTypeId = WTN.venueId;

	WTN.getMainData(function() {
		WTN.populateSocialLinks();
		WTN.populateVenueInfo();
		WTN.populateMap();
	});

	WTN.parseEventsData(WTN.apiDataTypeId);
	WTN.parsePhotosData(WTN.apiDataTypeId);
});