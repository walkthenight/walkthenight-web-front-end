$j(function() {

	var eventId = window.location.hash ? window.location.hash.split('#')[1] : '';

	WTN.apiDataTypePath = 'events/';
	WTN.apiDataTypeId = eventId;

	WTN.parseSingleEventData();

});