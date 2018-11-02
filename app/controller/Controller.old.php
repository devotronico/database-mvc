<?php
namespace app\controller;

use app\models\Users;


class Controller{

  
    private $layout = 'layout/index.tpl.php';
 
    private $template;
    private $page;
    private $userClass;


    public function __construct() {

        $this->userClass = new Users;
        
    }
   
    
    /** 
    * DISPLAY
    * Il metodo display è l'ultimo metodo che verrà richiamato
    * esso caricherà il LAYOUT generale che sarà quello di default per ogni pagina del sito.
    * Nella variabile '$layout' abbiamo l'indirizzo del file che contiene il LAYOUT per tutte le pagine
    * All' interno del LAYOUT andremo a inserire i TEMPLATE che non sono altro che variabili che
    * al loro interno contengono codice html e altre variabili php
    * @access public
    * @return null
    */
    public function display(){
      
        require $this->layout;  
    }






    //-----------------------------------------------------------------------------|
    /**
     * LOAD
     * 
     *  Mostra la lista di tutti gli utenti presenti nel database
     *  `$users` è un array di oggetti:
     *      `$users[0]{"nome"=>foo, "age"=>20}` 
     *      `$users[1]{"nome"=>bar, "age"=>30}`
     * `_view`: è una funzione che carica codice html e variabili php 
     * insieme  all'interno di un template
     * `compact`: http://php.net/manual/en/function.compact.php
     * `extract`: http://php.net/manual/en/function.extract.php
     * 
     * @access public
     * @return null
     */
    public function load() {

        $success = $this->userClass->loadUsers();
    /*
        if ( $success ) {

            $message = "SUCCESS";
            $uri ='/list/';
            _redirect($uri, $message);
        }
        */
    }
    
    
    
    //-----------------------------------------------------------------------------|
    /**
     * RESET
     * 
     *  Mostra la lista di tutti gli utenti presenti nel database
     *  `$users` è un array di oggetti:
     *      `$users[0]{"nome"=>foo, "age"=>20}` 
     *      `$users[1]{"nome"=>bar, "age"=>30}`
     * `_view`: è una funzione che carica codice html e variabili php 
     * insieme  all'interno di un template
     * `compact`: http://php.net/manual/en/function.compact.php
     * `extract`: http://php.net/manual/en/function.extract.php
     * 
     * @access public
     * @return null
     */
    public function reset() {

        $success = $this->userClass->resetUsers();
    /*
        if ( $success ) {

            $message = "SUCCESS";
            $uri ='/list/';
            _redirect($uri, $message);
        }
        */
    }


    //-----------------------------------------------------------------------------|
    /**
     * LIST
     * 
     *  Mostra la lista di tutti gli utenti presenti nel database
     *  `$users` è un array di oggetti:
     *      `$users[0]{"nome"=>foo, "age"=>20}` 
     *      `$users[1]{"nome"=>bar, "age"=>30}`
     * `_view`: è una funzione che carica codice html e variabili php 
     * insieme  all'interno di un template
     * `compact`: http://php.net/manual/en/function.compact.php
     * `extract`: http://php.net/manual/en/function.extract.php
     * 
     * @access public
     * @return null
     */
    public function list() {

        $users = $this->userClass->allUsers();
    
        $this->page = 'all';

        $this->template = _view($this->page, compact('users'));
    }





    //-----------------------------------------------------------------------------|
    /**
     * CREATE  {Crud}
     * 
     *  Crea un nuovo utente all' interno di un form
     *  `create()`: Carica il template(solo html) del form il cui metodo è POST
     *  `new()`:    Immagazzina nel database i dati inseriti nei campi di input ->
     *              del form e riporta l' utente alla pagina della lista degli users
     * 
     * @access public
     * @return null
     */
    public function create() {

        $this->page = 'create';

        $this->template = _view($this->page);
    }

    public function new() {

        $success = $this->userClass->createUser($_POST);

        if ( $success ) {

            $message = "SUCCESS";
            $uri ='/list/';
            _redirect($uri, $message);
        }
    }



    //-----------------------------------------------------------------------------|
    /**
     * READ  {cRud}
     * 
     *  Mostra un solo utente con maggiori dettagli rispetto alla lista utenti
     *  `create()`: Carica il template(solo html) del form il cui metodo è POST
     *  `new()`:    Immagazzina nel database i dati inseriti nei campi di input ->
     *              del form e riporta l' utente alla pagina della lista degli users
     * 
     * @param int $id:      user ID
     * @param string $type: tipo di select da eseguire con il metodo `singleUser()`
     * @access public
     * @return null
     */
    public function read($id) {

        $user = $this->userClass->singleUser($id, "read");

        $this->page = 'read';

        $this->template = _view($this->page, compact('user'));
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
     * Mostra un solo utente ( una riga della tabella) con tutti i suoi -> 
     * dati ( tutti i campi della tabella ) che può essere eliminato
     * 
     * `update()`: Carica il template(html, php) del form il cui metodo è POST
     * `store()`:  Immagazzina nel database i dati modificati nei campi di input ->
     *              del form e riporta l' utente alla pagina della lista degli users
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









    //-----------------------------------------------------------------------------|
    /**
     * ABOUT    
     * 
     * Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus
     * @access public
     * @return null
     */
    public function about($arg1=3) {

        $this->page = 'about';
        $this->template = "<h1>".$this->page."</h1>";
    }


    
    //-----------------------------------------------------------------------------|
    /**
     * CONTACT    
     * 
     * Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus
     * @access public 
     * @return null
     */
    public function contact($arg1=3) {

        $this->page = 'contact';
    }


    
    //-----------------------------------------------------------------------------|
    /**
     * ERROR 404    
     * 
     * Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus
     * @access public
     * @return null
     */
    public function error(){
        
        $this->page = 'error';
    }

}



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