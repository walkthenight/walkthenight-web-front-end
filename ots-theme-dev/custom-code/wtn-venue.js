$j(function() {

	WTN.populateEventsHeader();

	WTN.apiDataTypePath = 'venues/';
	WTN.apiDataTypeId = WTN.venueId;

	WTN.getInfoData(function() {
		WTN.populateSocialLinks();
		WTN.populateVenueInfo();
		WTN.populateMap();
	});

	WTN.parseEventsData();
	WTN.parsePhotosData();

});