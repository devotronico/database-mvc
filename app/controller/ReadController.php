<?php
namespace app\controller;

use app\models\Read;


class ReadController extends Controller {

  
    private $readClass;


    public function __construct() {

        $this->readClass = new Read;
        
    }
   

    /**
     * READ  {cRud}
     * 
     * Mostra un solo utente con tutte le sue proprietà/valori
     * 
     * La funzione intval(built-in) converte il parametro $id da stringa a integer,
     * Non c'è alcun modo di eseguire un'iniezione SQL quando il parametro
     * viene convertito in numero intero, perché il formato di un intero non consente 
     * di inserire parole chiave SQL (o virgolette o altro) in esso.
     * 
     * il metodo singleUser restituisce un oggetto con tutti i valori di un utente specifico
     * che verrano inseriti nel template read.tpl.php
     * 
     * @param int $id:      
     * @access public
     * @return null
     */
    public function read($id) {

        $id = intval($id);

        $user = $this->readClass->singleUser($id);

        $files=['navbar', 'read'];

        $this->template = _view($files, compact('user'));
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