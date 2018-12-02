import{postRequest} from "./modules/request.js";// <--import deve andare prima dell evento 'DOMContentLoaded'
import{inputFileImage} from "./modules/loadfile.js";


/**
 * EVENTO CLICK
 *  
 * httpRequest
 * 
 * controller: DeleteController
 * metodo controller: deleteImage
 * model: Delete
 * metodo model: deleteImage
 * 
 * al click sul bottone rosso sull'immagine dell'avatar
 * essendo che il bottone è un elemento html <a> con 
 * l' attributo href="/delete/image/id"
 * con preventDefault() blocchiamo il direzionamento verso la rotta /delete/image/id
 * poi assegniamo la rotta alla variabile const pathname
 * 
 * con la funzione 'postRequest()' facciamo una chiamata httpRequest
 * e come argomento passiamo la rotta che è nella variabile pathname,
 * 
 * 
 */
document.addEventListener('click', function(event){

  if ( event.target.classList.item(3) == 'btn-canc-img' ) {

    event.preventDefault()
    
    const pathname = event.target.pathname; //  /delete/image/3
    postRequest(pathname);
  }


});


/**
 * EVENTO INPUT 
 * form > input > type="range"
 * Se l'utente muove il cursore del campo input type="range"
 * Esempio campo input con il quale l'utente interagisce:
 * <input type="range" class="custom-range" min="0" max="100" id="level" name="level" value="<?=$user->level?>">
 * 
 * l' attributo 'value=' del campo input cambia valore a seconda della posizione del cursore
 * e viene passato all' elemento 'level-result' come testo
 * 
 */
let inputRange = document.getElementById("level");
let res = document.getElementById("level-result");

    inputRange.addEventListener("input", function() {
    res.innerHTML = "€" + inputRange.value;
}, false); 





/**
 * EVENTO CHANGE
 *  form > input > type="file"
 * 'change' rileva se viene premuto l'elemento <input> per caricare il file
 * Esempio campo input con il quale l'utente interagisce:
 * <input type="file" class="form-control-file" name="file" id="image" size="500000" accept="jpg jpeg"> 
 * 
 */
const input = document.querySelector('#image'); // seleziona il campo di input type="file"
input.addEventListener('change', () =>{

  inputFileImage(input)
});

