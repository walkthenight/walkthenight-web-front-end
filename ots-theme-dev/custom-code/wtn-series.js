$j(function() {

	WTN.populateEventsHeader();

	WTN.apiDataTypePath = 'series/';
	WTN.apiDataTypeId = WTN.seriesId;

	WTN.getMainData(function() {
		WTN.populateSocialLinks();
	});
	
	WTN.parseEventsData(WTN.apiDataTypeId);
	WTN.parsePhotosData(WTN.apiDataTypeId);
});