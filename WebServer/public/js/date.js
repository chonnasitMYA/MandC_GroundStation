$('#Startcalendar').calendar({
	type: 'date',
	endCalendar: $('#Endcalendar'),
	monthFirst: false,
	formatter: {
		date: function (date, settings) {
			if(!date) return '';
			var day = ("0" + date.getDate()).slice(-2);
			var month = ("0" + (date.getMonth() + 1)).slice(-2);
			var year = date.getFullYear();
			return day + '/' + month + '/' + year;
		}
	}
});
$('#Endcalendar').calendar({
	type: 'date',
	startCalendar: $('#Startcalendar'),
	monthFirst: false,
	formatter: {
		date: function (date, settings) {
			if(!date) return '';
			var day = ("0" + date.getDate()).slice(-2);
			var month = ("0" + (date.getMonth() + 1)).slice(-2);
			var year = date.getFullYear();
			return day + '/' + month + '/' + year;
		}
	}
});