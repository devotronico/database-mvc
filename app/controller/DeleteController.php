<?php
namespace app\controller;

use app\models\Delete;


class DeleteController extends Controller {

  
    private $deleteClass;


    public function __construct() {

        $this->deleteClass = new Delete;
        
    }








    /**
     * DELETE    -- cruD --
     * 
     * Eliminare un user
     * 
     * Prima di eliminare una riga della tabella user deve essere eliminato il 
     * file immagine associato a questo user che si trova in: public/image/avatar/nomeImmagine.jpg
     * 
     * Dopo aver eliminato il file immagine cancella l' user ( una riga della tabella) con tutti i suoi 
     * dati ( tutti i campi della tabella )
     * 
     * Se tutto è andato a buon fine veniamo reinderizzati alla home del sito
     * 
     * @param int $id: user id
     * @access public
     * @return null
     */
    public function delete(int $id) {

        $this->deleteClass->deleteImage($id); // cancella file immagine

        $success = $this->deleteClass->deleteUser($id);
    
        if ( $success ) { // integer

            $message = "Utente eliminato con successo";

           _redirect('/', $message);
        }
    }








/**
 * DELETE IMAGE  {AJAX} 
 * la rotta per attivare questo controller e metodo vengono gestiti con javascript per fare una Request al server
 * il file javascript e il suo percorso sono: public/js/update.js
 * 
 * Quando ci si trova nella pagina dove si modificano i valori di un utente ovvero all'indirizzo url.: http://host/update/:n
 * Questo metodo si attiva se viene premuto il bottone rosso sull' immagine attuale dell' user
 * la funzione die() ritorna al client il percorso dell' immagine per essere linkata 
 * nell' attributo src dell' nodo/elemento html <img> 
 * es.: <img class="profile__img" src="../image/avatar/avatar__default.jpg" alt="avatar personale">
 * 
 * @access public
 * @global string IMAGE_DEFAULT
 * @param int $id: user id
 * @return string
 */
    public function deleteImage(int $id) {

        $this->deleteClass->deleteImage($id); // cancella file immagine
      
        $this->deleteClass->setImageDefault($id); // Setta il nome dell' immagine di default

        die('../image/avatar/'.IMAGE_DEFAULT);
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