<?php
namespace app\controller;

use app\models\Page;


class PageController extends Controller {


     private $pageClass;


    public function __construct() {

        $this->pageClass = new Page;
        
    }
   
   


// PAGE
/**
 * PAGE  
 * route: "#page/:id"
 * 
 * Il metodo 'page' suddivide tutto il database in pagine
 * Per ogni pagina specifica quante row ottenere                    
 *      
 * Spiegazione Paginazione           
 * 'currentPage' è il numero della pagina in cui ci troviamo 
 * 'totalPosts'  è il numero totale di row che ci sono nel database
 * 'postForPage' è il numero di row che ci sono per ogni pagina 
 * 'postStart' è uguale al numero precedente del primo row della pagina in cui ci troviamo 
 * Se ci troviamo nella pagina 3 {'currentPage'=3} e abbiamo deciso che ogni pagina deve avere 2 post{'postForPage'=2}    
 * allora il primo post della terza pagina deve essere il post numero 4{'postStart'=4}  
 * 1  2  3 pagine {'currentPage'}  
 * 12 34 56 il numero dei post che visualizza se abbiamo impostato {'postForPage'=2}     
 * 0  2  4 sono i valori che ci servono per cominciare a contare i post da visualizzare {'postStart'} 
 *         
 * @access public
 * @global object GET
 * @return null
 */
public function page($currentPage=1){ 
   
    $totalPosts = $this->pageClass->getTotalUsers();

    $page = 'home';

    if ( empty($totalPosts ) ) { 

        $files=['navbar', 'buttons'];
        $this->template = _view($files, compact('page'));

    } else {

        // Pagination var
        $postForPage = 5; // decidiamo quanti post caricare per pagina
        for ($i=0, $postStart=-$postForPage; $i<$currentPage; $postStart+=$postForPage, $i++);
        $pageLast = ceil($totalPosts / $postForPage);
        $activeLink = 4;


        $users = $this->pageClass->getpageUsers($postStart, $postForPage); 
        $files=['navbar', 'buttons', 'search', 'list', 'pagination'];
        $this->template = _view($files, compact('page', 'totalPosts', 'postForPage', 'pageLast','currentPage', 'activeLink', 'users'));
     
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