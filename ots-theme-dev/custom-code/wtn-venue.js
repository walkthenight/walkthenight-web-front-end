$j(function() {

	(function populateEventsHeader() {
		var venueName = $j('h1.cb-entry-title').html();

		$j('.wtn-events-header span').html(venueName);
	})();

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