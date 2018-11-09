<?php
namespace app\controller;

use app\models\Update;
use app\models\Image;


class UpdateController extends Controller {

  
    private $updateClass;


    public function __construct() {

        $this->updateClass = new Update;
        
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
            return 'avatar-default.png'; 
        }

        $Image = new Image('normal', 0, 0, 500000, 'avatar', $_FILES);

        if ( !empty( $Image->getMessage()) ){ // se si è verificato un errore...
            
            return 'avatar-default.png'; 
        }
        // Se il file è stato caricato senza errori restituisce il nuovo nome del file, es.: 5be1c89d2513d3.2
        return $Image->getNewImageName();  
    }







    //-----------------------------------------------------------------------------|
    /**
     * UPDATE    -- crUd --
     * 
     *  Mostra un solo utente con tutti i suoi dati ( tutti i campi del database )
     *  che possono essere modificati e memorizzati nel databse.
     *  `update()`: Carica il template(html, php) del form il cui metodo è POST
     *  `edit()`:  Immagazzina nel database i dati modificati nei campi di input ->
     *              del form e riporta l' utente alla pagina della lista degli users
     * 
     * @param int $id:     
     * @access public
     * @return null
     */
    public function update($id) {

        $id = intval($id);
        $user = $this->updateClass->singleUser($id);
      
        $files=['navbar', 'update'];

        $this->template = _view($files, compact('user'));
    }

   


    public function edit($id) {

        $data = filter_var_array($_POST, FILTER_SANITIZE_STRING);
        
        if ( $_FILES['file']['error'] !== 4 ) {  // se è stata caricata una nuova immagine senza errori
            
            $this->updateClass->deleteImage($id); // cancella vecchia immagine se diversa da quella di default o da quella precedentemente caricata
            
            $imageName = $this->setImage(); // ritorna o un nuovo nomedi immagine oppure il nome di default del immagine

            $data = array_merge(array("imageName"=>$imageName),  $data); // inseriamo nell'array anche la proprietà "imageName"  con il valore $imageName
        }


        $success = $this->updateClass->updateUser($id, $data);
      
        if ( $success ) {

            $message = "Un Utente è stato aggiornato";
    
            _redirect('/', $message);
        }
    }




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