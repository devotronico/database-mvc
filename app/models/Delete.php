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








/**
 * DELETE USER
 * 
 *
 * @access public
 * @param int $id user id
 * @return int 
 */
public function deleteUser(int $id){
        
    $sql = 'DELETE FROM users WHERE id = :id';
    $stmt = $this->conn->prepare($sql); 
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
    $stmt->execute(); 
    return $stmt->rowCount(); // integer
}





/**
 * DELETE IMAGE  
 * 
 * Questo metodo si occupa solo di eliminare file dell'immagine vecchia
 * 
 * Quando si vuole cambiare l'immagine (in questo caso l' immagine dell' avatar)    
 * dobbiamo prima eliminare il file immagine attuale che sta nella cartella: public/image/avatar/,  
 * per dare il comando per cancellare il file esatto dobbiamo prima ottenere il nome del file,
 * il nome del file è immagazzinato nel database, della tabella users, del campo img, della riga che ha il numero del id che abbiamo
 * 
 * una volta ottenuto il nome del file dell'immagine vecchia e se l'immagine vecchia è diversa dall' immagine di default
 * l' immagine di default non deve essere mai cancellata 
 * utilizzando la funzione builtin di php 'unlink()' passandoci come argomento il percorso del file più il nome del file    
 * file dell'immagine vecchia viene eliminato   
 * 
 * @access public
 * @global string IMAGE_DEFAULT
 * @param int $id user id
 * @return void
 */
    public function deleteImage(int $id) {
    
        $sql = "SELECT img FROM users WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) { 

            $user = $stmt->fetch(PDO::FETCH_OBJ);

            $stmt = null; 
            if ( $user->img != IMAGE_DEFAULT ) { // 'avatar__default.jpg'
                
                unlink("public/image/avatar/".$user->img); //elimina il file del'immagine attuale
            }
           // $this->setImageDefault($id); // Setta il nome dell' immagine di default
            
        }
    }





/**
 * SET IMAGE DEFAULT
 * 
 * Questo metodo viene richiamato perchè è stata eliminata l' immagine di avatar di un user
 * Quindi setta il nome dell' immagine di default all'inteno del database nella
 * tabella users, nel campo img, della riga che ha il numero del id del parametro di questo metodo
 *
 * @access public
 * @global string IMAGE_DEFAULT
 * @param int $id user id
 * @return void 
 */
public function setImageDefault(int $id){
        
    $imageName = IMAGE_DEFAULT; // 'avatar__default.jpg';
                           
    $sql = "UPDATE users SET img = :img WHERE id = :id";

    $stmt = $this->conn->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
    $stmt->bindParam(':img', $imageName, PDO::PARAM_STR, 32);
   
    $stmt->execute();
    $stmt = null;
    }
} // chiude classe


/**
 * echo '<br>';
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


