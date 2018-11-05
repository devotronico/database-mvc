<?php
namespace app\controller;

use app\models\Single;


class SingleController extends Controller {

  
    private $userClass;


    public function __construct() {

        $this->userClass = new Single;
        
    }
   
    

    //-----------------------------------------------------------------------------|
    /**
     * READ  {cRud}
     * 
     *  Mostra un solo utente con maggiori dettagli rispetto alla lista utenti
     * 
     * @param int $id:      user ID
     * @param string $type: tipo di select da eseguire con il metodo `singleUser()`
     * @access public
     * @return null
     */
    public function read($id) {

        $user = $this->userClass->singleUser($id, "read");

     
        $files=['navbar', 'read'];
        $this->template = _view($files, compact('user'));
    }








    //-----------------------------------------------------------------------------|
    /**
     * UPDATE    -- crUd --
     * 
     *  Mostra un solo utente con tutti i suoi dati ( tutti i campi del database )
     *  che possono essere modificati e memorizzati nel databse.
     *  `update()`: Carica il template(html, php) del form il cui metodo è POST
     *  `store()`:  Immagazzina nel database i dati modificati nei campi di input ->
     *              del form e riporta l' utente alla pagina della lista degli users
     * 
     * @param int $id:      user ID
     * @param string $type: tipo di select da eseguire con il metodo `singleUser()`
     * @access public
     * @return null
     */
    public function update($id) {

        $user = $this->userClass->singleUser($id, "update");
      

        $this->page = 'update';


        $this->template = _view($this->page, compact('user'));
    }

   
    public function store($id) {
   
        $success = $this->userClass->updateUser($id, $_POST);
      
        if ( $success ) {

            $message = "SUCCESS";
            $uri ='/list/';
            _redirect($uri, $message);
        }
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

        $success = $this->userClass->deleteUser($id);

        if ( $success ) {

            $message = "SUCCESS";
            $uri ='/list/';
            _redirect($uri, $message);
        }

    }


} // Chiude la Classe



/**
 * die( $ );
 * die( '' );
 * var_dump( $ );
 * echo '<pre>';print_r( $ );
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