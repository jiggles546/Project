$(document).ready(function() {
	$("#start_date").datepicker({
        minDate:0,
		dateFormat: "yy-mm-dd",
		
		onSelect: function(selectedDate){
			var min_end_date = new Date(selectedDate);
			min_end_date.setDate(min_end_date.getDate() + 1);
			$("#end_date").datepicker("option", "minDate", min_end_date);
		}
    });


	$( "#end_date" ).datepicker({
		minDate:0,
		dateFormat: "yy-mm-dd",
		onSelect: function(selectedDate){
			var max_start_date = new Date(selectedDate);
			max_start_date.setDate(max_start_date.getDate() - 1);
			$("#start_date").datepicker("option","maxDate", max_start_date);

		}
	}); 
});

