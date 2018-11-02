<?php
namespace app\controller;

use app\models\Blog;


class ListController extends Controller {


     private $listClass;


    public function __construct() {

        $this->listClass = new Blog;
        
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

        $users = $this->listClass->allUsers();
    
        $this->page = 'all';

        $this->template = _view($this->page, compact('users'));
    }








/***********************************************************************************************************************|
* GETPOSTS          metodo = GET    route = posts/page/id                                                               |
* Otteniamo tutti i post di una pagina                                                                                  |     
* Se ci sono i post allora viene caricato anche il template della paginazione                                           |   
* Spiegazione Paginazione                                                                                               |
* 'page' è la il numero della pagina in cui ci troviamo                                                                 |
* 'postForPage' è il numero di post che ci sono per ogni pagina                                                         |
* 'postStart' è uguale al numero precedente del primo post della pagina in cui ci troviamo                              |
* Se ci troviamo nella pagina 3 {'currentPage'=3} e abbiamo deciso che ogni pagina deve avere 2 post{'postForPage'=2}   |
* allora il primo post della terza pagina deve essere il post numero 4{'postStart'=4}                                   |
* 1  2  3 pagine {'currentPage'}                                                                                        |
* 12 34 56 il numero dei post che visualizza se abbiamo impostato {'postForPage'=2}                                     |
* 0  2  4 sono i valori che ci servono per cominciare a contare i post da visualizzare {'postStart'}                    |
************************************************************************************************************************/
public function page($currentPage=1){ 
   /*
    if ( isset($_COOKIE['user_id']) ) {
     
         $this->Blog->loginWithCookie(); 
    }*/

    $totalPosts = $this->listClass->totalPosts();
    $link="posts";
    if ( empty($totalPosts ) ) { 
        $this->page = 'empty';
        $files=[$this->device.'.navbar-blog', 'post.empty'];
        $this->content = View($this->device, 'blog', $files, compact('link', 'page')); 

    } else {

        $this->page = 'all';
        $postForPage = 5; // decidiamo quanti post caricare per pagina
        for ($i=0, $postStart=-$postForPage; $i<$currentPage; $postStart+=$postForPage, $i++);
        $users = $this->listClass->getpageUsers($postStart, $postForPage); 
        $pageLast = ceil($totalPosts / $postForPage);
        $activeLink = 4;
        $this->template = _view($this->page, compact('totalPosts', 'postForPage', 'pageLast','currentPage', 'activeLink', 'users'));
        // $dates = $this->listClass->getDates();
        // $this->content = View($this->device, 'blog', $files, compact('link', 'posts', 'dates', 'currentPage', 'totalPosts', 'postForPage')); 
    }
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

        $success = $this->listClass->loadUsers();
   
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

        $success = $this->listClass->resetUsers();
   
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

        $success = $this->listClass->createUser($_POST);

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