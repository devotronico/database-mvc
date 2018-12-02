<?php
namespace app\controller;

use app\models\Search;


class SearchController extends Controller {


     private $searchClass;


    public function __construct() {

        $this->searchClass = new Search;
        
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

        $users = $this->searchClass->getDataFiltered($data);

        $files=['navbar', 'buttons', 'search', 'list'];

        $this->template = _view($files, compact('page','data', 'users'));
    }

    

   
    




} // Chiude la Classe



/**
 * echo "<br>";
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