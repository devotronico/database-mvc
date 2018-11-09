<?php
namespace app\controller;

use app\models\Create;
use app\models\Image;


class CreateController extends Controller {

  
    private $createClass;


    public function __construct() {

        $this->createClass = new Create;
        
    }
   
    



 //-----------------------------------------------------------------------------|
    /**
     * CREATE  {Crud}
     * 
     * Dalla home cliccando sul bottone 'aggiungi utente' si attiva il metodo di questa
     * classe che consente di inserire un nuovo utente all'interno del database.
     * Se l'operazione ha successo si viene indirizzati nella home del sito.
     *  Crea un nuovo utente all' interno di un form
     *  `create()`: Carica il template(solo html) del form il cui metodo è POST
     *  `new()`:    Immagazzina nel database i dati inseriti nei campi di input ->
     *              del form e riporta l' utente alla pagina della lista degli users
     * 
     * @access public
     * @return null
     */
    public function create() {

        $files=['navbar', 'create'];

        $this->template = _view($files);
    }



/**
 * SET IMAGE
 * 
 * Questo metodo ha 2 obiettivi per l'immagine caricata nel form:
 * [1] salvare l' immagine in una cartella del server con un nuovo nome
 * [2] restituire il nuovo nome per immagazzinarlo nel database
 * 
 * Per Ottenere tutti i valori dell' array $_FILES settare al tag form l'attributo `enctype="multipart/form-data"`
   $_FILES = [file] => Array( [name] => 30.jpg, [type] => image/jpeg, [tmp_name] => C:\xampp\tmp\php1AA6.tmp, [error] => 0, [size] => 21545 )
 *
 * I parametri della classe Image sono:
 * scaleType:   tipo di ridimensionamento da applicare all'immagine ==> 'normal'
 * max_width:   massima larghezza del file da noi accettato         ==> 0
 * max_height:  massima altezza del file da noi accettato           ==> 0
 * max_size:    massima peso del file da noi accettato              ==> 500000 ( = 0.5 Megabytes(MB))
 * folder:      cartella del percorso del file dove verrà salvato   ==> 'avatar'
 * array:       $_FILES che contiene tutti i valori del file        ==> $_FILES
 * 
 * 
 * Per maggiori info sull' unità di misura del peso delle immagini:  https://www.gbmb.org/bytes-to-mb
 * 1    Megabytes(MB) = 1000000 Bytes(B)
 * 0.5  Megabytes(MB) =  500000 Bytes(B)
 * 0.25 Megabytes(MB) =  250000 Bytes(B)
 * 
 * @access private
 * @author Daniele Manzi
 * @return string nome dell' immagine
 */
    private function setImage() {

        if ( !isset($_FILES) || !isset($_FILES['file']) ) { 
            return 'avatar-default.png';  //  die ('ERRORE: FILE NON PRESENTE');
        }

        if ( $_FILES['file']['error'] === 4 ) 
        {
            return 'avatar-default.png'; // die('immagine non caricata'); 
        }
        else
        {
            $Image = new Image('normal', 0, 0, 500000, 'avatar', $_FILES);

            if ( !empty( $Image->getMessage()) ){ // se si è verificato un errore...
              
                return 'avatar-default.png'; // die('Si è verificato un errore:<br>'.$Image->getMessage());
            }
            // Se il file è stato caricato senza errori restituisce il nuovo nome del file, es.: 5be1c89d2513d3.2
            return $Image->getNewImageName();  
        }
    }


/**
 * STORE
 * 
 * Il metodo setImage() può restituire o il nome dell'immagine oppure null,
 * se è null allora alla variabile $imageName assegniamo il nome di default: 'avatar-default.png'
 * 
 * In $data(array) assegniamo i valori sanitizzati 
 * di $_POST che sono stati inseriti nel form: es. $_POST['name'], $_POST['country']
 * 
 * Poi aggiungiamo un altro valore di array associativo con il nome dell' immagine
 * es.: ["imageName"=>$imageName]
 * 
 * Il metodo createUser($data) immaganizza tutti i valori raccolti nel database e
 * restituisce true o false. Se è true allora verremo indirizzati nella home del sito 
 * con il messaggio: "Un Nuovo Utente è stato creato"
 *
 * @access public
 * @author Daniele Manzi
 * @return null
 */
    public function store() {
        // $imageName = !is_null($this->setImage()) ? $this->setImage() : 'avatar-default.png' ;
        $imageName = $this->setImage();

        $data = filter_var_array($_POST, FILTER_SANITIZE_STRING);

        if ( !isset( $_POST['cookie'] )) {

            $data = array_merge(array("imageName"=>$imageName, "cookie"=>false), $data); 
        } else {

            $data = array_merge(array("imageName"=>$imageName), $data); 
        }

        $success = $this->createClass->createUser($data);
        
        if ( $success ) {
            
            $message = "Un Nuovo Utente è stato creato";
           
            _redirect('/', $message);
        }
    }
// END CREATE








    





} // Chiude la Classe



/**
 * die( $ );
 * die( '' );
 * var_dump( $ );
 * echo '<pre>';print_r( $ );
 * if ( isset( $ )) { var_dump( $ ); echo '<pre>';print_r( $ ); die(); }
 * gettype( $ ));
 */


/**
 * Get photo from blog author
 * 
 * Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut id volutpat 
 * orci. Etiam pharetra eget turpis non ultrices. Pellentesque vitae risus 
 * sagittis, vehicula massa eget, tincidunt ligula.
 *
 * @access private
 * @author Firstname Lastname
 * @global object $post
 * @param int $id Author ID
 * @param string $type Type of photo
 * @param int $width Photo width in px
 * @param int $height Photo height in px
 * @return object Photo
 */