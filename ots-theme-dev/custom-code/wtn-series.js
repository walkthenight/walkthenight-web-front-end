$j(function() {

	WTN.apiDataTypePath = 'series/';
	WTN.apiDataTypeId = WTN.seriesId;

	WTN.getInfoData();
	WTN.populateSocialLinks();
	WTN.populateMap();
	
	WTN.parseEventsData();
	WTN.parsePhotosData();

});