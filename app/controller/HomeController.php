<?php
namespace app\controller;

use app\models\Home;


class HomeController extends Controller {


     private $homeClass;


    public function __construct() {

        $this->homeClass = new Home;
        
    }
   
    // HOME
    /**
     * ALL  
     * route: "all", "/", ""
     * 
     * Mostra la lista di tutti gli utenti presenti nel database
     *  $users:  è un array di oggetti:
     *      $users[0]{"nome"=>foo, "age"=>20}
     *      $users[1]{"nome"=>bar, "age"=>30}
     *  _view:  è una funzione che carica codice html e variabili php 
     *      insieme all'interno di un template
     * 
     * `compact`: http://php.net/manual/en/function.compact.php
     * `extract`: http://php.net/manual/en/function.extract.php
     * 
     * @access public
     * @global object GET
     * @return null
     */
    public function all() {

        $page = 'all';

        $users = $this->homeClass->getAllUsers();
    
        $files=['navbar', 'buttons', 'search', 'list'];
        $this->template = _view($files, compact('page', 'users'));
    }

    
    /**
     * SEARCH  
     * route: "search"
     * 
     * Cerca tra tutti le row presenti nel database
     *  
     *     
     * 
     * @access public
     * @global object GET
     * @return null
     */
    public function search() {

        $data = filter_var_array($_POST, FILTER_SANITIZE_STRING);

   

        $page = 'all';


        $users = $this->homeClass->getDataFiltered($data);
    
    // if ( isset( $users )) { var_dump( $users ); echo '<pre>';print_r( $users ); die(); }

        $files=['navbar', 'buttons', 'search', 'list'];

        $this->template = _view($files, compact('page', 'users'));
    }





    /**
     * LOAD
     * 
     * Carica nel database i dati presi da un file json.
     *           
     * Il metodo loadUsers ritorna un valore integer 
     * del numero di righe caricate nel database
     * 
     * @access public
     * @global object GET
     * @return null
     */
    public function load() {

        $rowLoaded = $this->homeClass->loadUsers();


        if ( $rowLoaded ) {

            $message = "Sono state caricate ".$rowLoaded." righe";
           
            _redirect('/', $message);
        }
    }
    
    


    
    /**
     * RESET
     * 
     * Cancella tutti i dati presenti nel database.
     * Se la cancellazione è avvenuta
     * il metodo 'resetUsers' restituisce bool(true). 
     *  
     * A cancellazione avvenuta fa il redirect nella home con un messaggio
     * 
     * @access public
     * @global object GET
     * @return null
     */
    public function reset() {

        $success = $this->homeClass->resetUsers();

        if ( isset($success) ) {

            $message = "RESET";
           
            _redirect('/', $message);
       }
    }


  



} // Chiude la Classe



/**
 * die( $ );
 * die( '' );
 * var_dump( $ );
 * echo '<pre>';print_r( $ );
 * gettype( $ ));
 * if ( isset( $ )) { var_dump( $ ); echo '<pre>';print_r( $ ); die(); }
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