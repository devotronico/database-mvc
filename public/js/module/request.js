
  function postRequest(pathname){
  
    const http = new XMLHttpRequest();
 
    http.open("POST", pathname, true); // passare una path all' url con il metodo post
    // Imposta le informazioni sull'intestazione del tipo di contenuto per l'invio di variabili con codifica url nella richiesta
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    http.onreadystatechange = function() {

	    if ( http.readyState == 4 && http.status == 200 ) {

        const data = http.responseText; // risposta dal server

        const profileImgBox = document.querySelector('.profile__img__box');
      
        profileImgBox.removeChild(profileImgBox.childNodes[1]);

        console.log(data); 
        document.querySelector('.profile__img').src = data;
	    }
    }
    // Send the data to PHP now... and wait for response to update the status div
    http.send(); // Actually execute the request
   // document.getElementById("status").innerHTML = "processing...";
}


export { postRequest };