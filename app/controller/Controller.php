<?php
namespace app\controller;



class Controller{

  
    protected $layout = 'layout/index.tpl.php';
 
    protected $template;
    protected $page;
   


    public function __construct() {

        
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
     * ERROR 404    
     * 
     * Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus
     * @access public
     * @return null
     */
    public function error(){
        
        $this->page = 'error';
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