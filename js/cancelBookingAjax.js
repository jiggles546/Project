function updateCancellationID(){
	
	var guest_id = document.getElementById('guest_id').value;
	var xmlhttp = new XMLHttpRequest();
	
	xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					 var msg = this.responseText;
					 document.getElementById("reservation_id").innerHTML = msg;
 				}};
	xmlhttp.open("GET", "updateCancellationIDAjax.php?guest_id=" + guest_id, true);
	xmlhttp.send();
	
	
}

function updateRoomNum(){
	
	var reservation_id = document.getElementById('reservation_id').value;
	var xmlhttproomnum = new XMLHttpRequest();
	
	xmlhttproomnum.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					 var msg = this.responseText;
					 document.getElementById("room_id").value = msg;
				}};
	xmlhttproomnum.open("GET", "updateCancellationRoomNumberAjax.php?reservation_id=" + reservation_id, true);
	xmlhttproomnum.send();
	
	
}

