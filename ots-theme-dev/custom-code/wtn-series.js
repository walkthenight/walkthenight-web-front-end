$j(function() {

	WTN.apiDataTypePath = 'series/';
	WTN.apiDataTypeId = WTN.seriesId;

	WTN.getInfoData(function() {
		WTN.populateSocialLinks();
		WTN.populateMap();
	});
	
	WTN.parseEventsData();
	WTN.parsePhotosData();

});

});