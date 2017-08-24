function updateRoomsAjax(){
	var room_size 		= document.getElementById("room_size").value;  
	var smoking_option	= document.getElementById("smoking_option").value;
	var pet_option		= document.getElementById("pet_option").value;
	var start_date 		= document.getElementById("start_date").value;
	var end_date 		= document.getElementById("end_date").value;


	var xmlhttp = new XMLHttpRequest();

	if(end_date != "" && start_date != ""){
			
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					 var msg = this.responseText;
					 document.getElementById("room_map").innerHTML = msg;
					

	}};
	
	}
			
			xmlhttp.open("GET", "updateRoomColour.php?room_size=" 	 		 + room_size
														+ "&smoking_option=" + smoking_option
														+ "&pet_option=" 	 + pet_option
														+ "&start_date=" 	 + start_date
														+ "&end_date="       + end_date
														, true);
			xmlhttp.send();
			
			updatePriceAjax();
			updateRoomNumberAjax();
} 	

function updatePriceAjax(){
	var room_num = document.getElementById("room_numbers").value;

	var xmlhttp = new XMLHttpRequest();

	if(room_num != ""){
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					 var msg = this.responseText;
					 document.getElementById("price").innerHTML = "Price: " + msg;
	}};
	
	}
			xmlhttp.open("GET", "updateRoomPriceAjax.php?room_num=" + room_num, true);
			xmlhttp.send();
} 	

function updateRoomNumberAjax(){
	
	var room_size 		= document.getElementById("room_size").value;  
	var smoking_option	= document.getElementById("smoking_option").value;
	var pet_option		= document.getElementById("pet_option").value;
	var start_date 		= document.getElementById("start_date").value;
	var end_date 		= document.getElementById("end_date").value;
	var room_num 		= document.getElementById("room_numbers").value;

	var xmlhttp = new XMLHttpRequest();

	if(room_num != ""){
			
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					 var msg = this.responseText;
					 document.getElementById("room_numbers").innerHTML = msg;
					

	}};
	
	}
			
			xmlhttp.open("GET", "updateRoomDropDown.php?room_size=" 	 	 + room_size
														+ "&smoking_option=" + smoking_option
														+ "&pet_option=" 	 + pet_option
														+ "&start_date=" 	 + start_date
														+ "&end_date="       + end_date
														, true);
			xmlhttp.send();
}