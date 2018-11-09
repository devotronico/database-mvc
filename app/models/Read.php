<?php
namespace app\models;

use app\models\Database;
use PDO; // importare la classe PDO per utilizzarla 

class Read {


    private $conn;


    public function __construct() {

        $db = new Database;
        $this->conn = $db->getConnection();
    }
   
    

    /**
     * SINGLE USER
     * 
     * Questo metodo si occupa di prelevare dal database tutti i dati di una singola riga
     * la select utilizza il campo id che ha un valore univoco per 
     * ottenere i dati di tutti i campi di una singola riga
     * 
     * alla proprità $user->img che contiene solo il nome dell' immagine
     * aggiungiamo il percorso dove si trova il file dell'immagine
     * per assegnarlo all'attributo src del tag html img 
     *
     * @access public
     * @author Daniele Manzi
     * @global object $conn
     * @param int $id 
     * @return object user
     */
    public function singleUser(int $id) { 

        $sql = "SELECT * FROM users WHERE id = :id";
     
        $stmt = $this->conn->prepare($sql);
     
        $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
        
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_OBJ); 
        
        $user->img = "/image/avatar/".$user->img;

        return $user;
    }



/***************************************************************************************|
* SET IMAGE DEFAULT                                                                                
* Assegna immagine di default                                                 
* 
****************************************************************************************/
/*
private function setImageDefault($id) {
  
    $imageName = 'avatar-default.png';
                           
    $sql = "UPDATE users SET img = :img WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    
    $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
    $stmt->bindParam(':img', $imageName, PDO::PARAM_STR, 32);
   
    $stmt->execute();
    $stmt = null;
    return "/image/avatar/".$imageName;
 }
*/


/*
 public function deleteUser(int $id){
        
    $sql = 'DELETE FROM users WHERE id = :id';
    $stmt = $this->conn->prepare($sql); 
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
    $stmt->execute(); 
    return $stmt->rowCount();
 }
*/







} // chiude classe


/**
 * die( $ );
 * die( '' );
 * var_dump( $ );
 * echo '<pre>';print_r( $ );
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


