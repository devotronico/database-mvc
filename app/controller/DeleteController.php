<?php
namespace app\controller;

use app\models\Delete;


class DeleteController extends Controller {

  
    private $deleteClass;


    public function __construct() {

        $this->deleteClass = new Delete;
        
    }
   




    //-----------------------------------------------------------------------------|
    /**
     * DELETE    -- cruD --
     * 
     * Cancella un solo utente ( una riga della tabella) con tutti i suoi -> 
     * dati ( tutti i campi della tabella ) che può essere eliminato
     * 
     * 
     * @param int $id:      user ID
     * @access public
     * @return null
     */
    public function delete($id) {

        $success = $this->deleteClass->deleteUser($id);

        if ( $success ) {

            $message = "Utente eliminato con successo";

            _redirect('/', $message);
        }

    }



    

/**
     * DELETE IMAGE  {AJAX}
     * 
     * 
     * @access public
     * @return string
     */
    public function deleteImage($id) {

        $this->deleteClass->deleteImage($id); // cancella vecchia immagine
        // $this->deleteClass->setImageDefault($id); // cancella vecchia immagine
       die('../image/avatar/avatar__default.png');
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