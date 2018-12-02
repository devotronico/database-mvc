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
     * @return void
     */
    public function update(int $id) {

        $user = $this->updateClass->singleUser($id);
      
        $files=['navbar', 'update'];

        $this->template = _view($files, compact('user'));
    }








/**
 * EDIT
 * 
 * Gestisce e salva nel database i dati che sono stati passati attraverso il form
 * 
 * in $data passiamo il valore dell' array $_POST sanitizzato,
 * ma non vengono passati i valori del file immagine che eventualmente è stato inserito nel form.
 * i valori dei file vengono passati con l' array $_FILES.
 * Se un file è stato caricato lo si gestisce attraverso i suoi valori contenuti nell' array $_FILES
 * e dopo aver ottenuto il nome dell' immagine lo si converte in array associativo, es.: array("imageName"=>$imageName)
 * e lo si unisce all' array $data, es.: $data = array_merge(array("imageName"=>$imageName),  $data);
 * 
 *  
 * IMMAGINE: se è stata caricato un file immagine nel form senza errori:
 *  
 *   Con la vecchia Immagine:
 *     tramite l'id viene preso il vecchio nome dell'immagine dal database che viene utilizzato 
 *     per cancellare il file della vecchia immagine dal suo percorso. es.: public/image/avatar/immagineVecchia.jpg
 * 
 *   Con la nuova Immagine:
 *     viene salvato il nuovo nome dell' immagine nel database e
 *     caricata la nuova immagine nel percorso. es.: public/image/avatar/nuovaVecchia.jpg
 * /IMMAGINE
 * 
 * se abbiamo
 * 
 * @access public
 * @param int $id
 * @global array $_POST
 * @global array $_FILES
 * @return void
 */
    public function edit(int $id) {
    
        $data = filter_var_array($_POST, FILTER_SANITIZE_STRING);
        
        if ( $_FILES['file']['error'] !== 4 ) {  // se è stata caricata una nuova immagine senza errori
            
            $this->updateClass->deleteImage($id); // cancella vecchia immagine se diversa da quella di default o da quella precedentemente caricata
            
            $imageName = $this->setImage(); // ritorna o un nuovo nome di immagine oppure il nome di default del immagine

            $data = array_merge(array("imageName"=>$imageName),  $data); // inseriamo nell'array anche la proprietà "imageName"  con il valore $imageName
        }


        $success = $this->updateClass->updateUser($id, $data);
      
        if ( $success ) {

            $message = "Un Utente è stato aggiornato";
    
            _redirect('/', $message);
        }
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
 * @global array $_FILES
 * @return string nome dell' immagine
 */
private function setImage() {

    if ( !isset($_FILES) || !isset($_FILES['file']) ) { 
        return IMAGE_DEFAULT; // 'avatar__default.jpg'; 
    }

    $Image = new Image('normal', 0, 0, 500000, 'avatar', $_FILES);

    if ( !empty( $Image->getMessage()) ){ // se si è verificato un errore...
        
        return IMAGE_DEFAULT; // 'avatar__default.jpg'; 
    }
    // Se il file è stato caricato senza errori restituisce il nuovo nome del file, es.: 5be1c89d2513d3.2
    return $Image->getNewImageName();  
}






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

