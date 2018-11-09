<?php
namespace app\models;

use app\models\Database;
use PDO; // importare la classe PDO per utilizzarla 

class Delete {


    private $conn;


    public function __construct() {

        $db = new Database;
        $this->conn = $db->getConnection();
    }
   
    



 public function deleteUser(int $id){
        
    $sql = 'DELETE FROM users WHERE id = :id';
    $stmt = $this->conn->prepare($sql); 
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
    $stmt->execute(); 
    return $stmt->rowCount();
 }





  /*********************************************************************************************************************|
    * DELETE IMAGE                                                                                                      |
    * quando vogliamo cambiare l'immagine di un post                                                                    |
    * dobbiamo prima eliminare il file immagine attuale che sta nella cartella dove è immagazzinato,                    |
    * Ci occorre il nome del'immagine il quale lo otteniamo facendo una select al database con l'id del post            |                 
    * Utilizziamo con la funzione builtin di php 'unlink' passandoci il percorso del file più il nome del file          |
    * l'immagine viene eliminata                                                                                        |
    ********************************************************************************************************************/
    public function deleteImage($id) {
    
        $id = (int)$id;
        $sql = "SELECT img FROM users WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) { 

            $user = $stmt->fetch(PDO::FETCH_OBJ);

            $stmt = null; 
            
            unlink("public/image/avatar/".$user->img); //elimina il file del'immagine attuale

            $this->setImageDefault($id); // Setta il nome dell' immagine di default
            
        }
    }



    

/***************************************************************************************|
* SET IMAGE DEFAULT                                                                                
* Assegna immagine di default                                                 
* 
****************************************************************************************/
private function setImageDefault(int $id){
        
    $imageName = 'avatar-default.png';
                           
    $sql = "UPDATE users SET img = :img WHERE id = :id";

    $stmt = $this->conn->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
    $stmt->bindParam(':img', $imageName, PDO::PARAM_STR, 32);
   
    $stmt->execute();
    $stmt = null;
   
 }



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


