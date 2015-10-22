$j(function() {

	$j('h1.cb-entry-title').addClass('fullWidth loaderBg indentHide');

	var eventId = '';

	if (WTN.eventId) {
		eventId = WTN.eventId;
	}
	else if (window.location.hash) {
		eventId = window.location.hash.split('#')[1]
	}

	WTN.apiDataTypePath = 'events/';
	WTN.apiDataTypeId = eventId;
	
	WTN.getMatchingSeriesIds(eventId, function() {
		WTN.parseSingleEventData(WTN.seriesAssociatedWithEvent);
	});
});