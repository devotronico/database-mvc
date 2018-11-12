
  function postRequest(pathname){
  
    const http = new XMLHttpRequest();
 
    http.open("POST", pathname, true); // passare una path all' url con il metodo post
    // Imposta le informazioni sull'intestazione del tipo di contenuto per l'invio di variabili con codifica url nella richiesta
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  
    http.onreadystatechange = function() {

	    if ( http.readyState == 4 && http.status == 200 ) { // se riceviamo una risposta positiva dal server...

        const data = http.responseText; // risposta dal server
console.log(data);
        const profileImgBox = document.querySelector('.profile__img__box'); // selezioniamo il contenitore dell' immagine
      
        profileImgBox.removeChild(profileImgBox.childNodes[1]); // rimuoviamo il secondo elemento child del contenitore che è l'elemento img

        document.querySelector('.profile__img').src = data; // e assegniamo la il nuovo percorso del file immagine che è: ../image/avatar/avatar__default.png
	    }
    }
    // Send the data to PHP now... and wait for response to update the status div
    http.send(); // Actually execute the request
   // document.getElementById("status").innerHTML = "processing...";
}


export { postRequest };