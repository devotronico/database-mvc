<?php
namespace app\controller;

use app\models\Create;
use app\models\Image;


class CreateController extends Controller {

  
    private $createClass;


    public function __construct() {

        $this->createClass = new Create;
        
    }
   
    



    /**
     * CREATE  {Crud}
     * 
     * Mostra pagina del form per la creazione di un nuovo user
     * 
     * Dalla home cliccando sul bottone 'aggiungi utente' si viene indirizzati 
     * nella pagina per la creazione di un nuovo user 
     * la pagina è un form per l'inserimento di dati
     * 
     * Attributi del form per l' inserimento dei dati: 
     * <form action="/store" method="POST" enctype="multipart/form-data">
     * 
     * @access public
     * @return void
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
 *  $_FILES = [file] => Array( [name] => 30.jpg, [type] => image/jpeg, [tmp_name] => C:\xampp\tmp\php1AA6.tmp, [error] => 0, [size] => 21545 )
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
 * @global array $_FILES
 * @global string IMAGE_DEFAULT
 * @return string nome dell' immagine
 */
    private function setImage() {

        if ( !isset($_FILES) || !isset($_FILES['file']) ) { 

            return IMAGE_DEFAULT; //  die ('ERRORE: FILE NON PRESENTE');
        }

        if ( $_FILES['file']['error'] === 4 ) 
        {
            return IMAGE_DEFAULT;  // die('immagine non caricata'); 
        }
        else
        {
            $Image = new Image('normal', 0, 0, 500000, 'avatar', $_FILES);

            if ( !empty( $Image->getMessage()) ){ // se si è verificato un errore...
              
                return IMAGE_DEFAULT; // die('Si è verificato un errore:<br>'.$Image->getMessage());
            }
            // Se il file è stato caricato senza errori restituisce il nuovo nome del file, es.: 5be1c89d2513d3.2
            return $Image->getNewImageName();  
        }
    }


/**
 * STORE
 * 
 * Salva un nuovo user, inserendo tutti i suoi dati nei campi di una nuova riga nella tabella users
 * 
 * Il metodo setImage() può restituire:
 *  se il file immagine è stato caricato e non ci sono errori nel caricamento allora il metodo restituisce un nome per l'immagine
 *  se il file immagine non è stato caricato o è stato caricato ma ci sono errori nel caricamento restituisce il nome del file immagine di default: avatar__default.jpg
 * 
 * In $data(array) assegniamo i valori sanitizzati 
 * di $_POST che sono stati inseriti nel form: es. $_POST['name'], $_POST['country']
 * 
 * se nel form è stato spuntato il campo input con attributo checkbox allora il valore $_POST['cookie'] è settato e
 * quindi deve essere aggiunto un altro valore di array
 * 
 * Poi aggiungiamo un altro valore di array associativo con il nome dell' immagine
 * es.: ["imageName"=>$imageName]
 * 
 * Il metodo createUser($data) immaganizza tutti i valori raccolti nel database e
 * restituisce true o false. Se è true allora verremo indirizzati nella home del sito 
 * con il messaggio: "Un Nuovo Utente è stato creato"
 *
 * @access public
 * @global array $_POST
 * @global string IMAGE_DEFAULT
 * @return void
 */
    public function store() {

        $imageName = $this->setImage();

        $data = filter_var_array($_POST, FILTER_SANITIZE_STRING);

        if ( !isset( $_POST['cookie'] )) {

            $data = array_merge(array("imageName"=>$imageName, "cookie"=>'NO'), $data); 
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
 * echo '<br>';
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