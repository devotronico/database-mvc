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
     * Ma se in quel percorso il file non esiste allora gli viene assegnato 
     * il nome di immagine di default
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

        $user->birth = $user->birth ? date('d-m-Y', strtotime($user->birth)) : 'assente';
      
        $user->upd_date = _timeago_from_sql_datetime( $user->upd_date );
        
        $user->reg_date = date('d-m-Y H:i:s', strtotime($user->reg_date));
        
        $fn = "public/image/avatar/".$user->img;

        $user->img = !file_exists( $fn )? $this->setImageDefault($id) : "/image/avatar/".$user->img; ;
    
        return $user;
    }



    /**
     * SINGLE USER
     * 
     * Questo metodo viene richiamato quando non è stato trovato il file
     * che corrisponde al nome del file salvato nel database
     *
     * Quindi si sostituisce il vecchio nome del file con il nome di default 
     * che è:  'avatar__default.jpg'
     * 
     * poi viene ritornato il nuovo nome più il percorso del file
     * che è: "/image/avatar/avatar__default.jpg"
     * Il file di default è sempre presente in questo percorso
     * perchè l'utente non può cancellarlo
     * 
     * @access private
     * @author Daniele Manzi
     * @global object $conn
     * @param int $id 
     * @return string /image/avatar/avatar__default.jpg
     */
    private function setImageDefault($id) {
    
        $imageName = IMAGE_DEFAULT; // avatar__default.jpg
                            
        $sql = "UPDATE users SET img = :img WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
        $stmt->bindParam(':img', $imageName, PDO::PARAM_STR, 32);
    
        $stmt->execute();
        $stmt = null;
        
        return "/image/avatar/".$imageName;
    }





    private function convertDateBirth(string $datebirth){
        // BIRTH
        // dal form la data arriva in questo formato: 2000-12-30
        // ma la cambiamo in questo formato: 30-12-2000
        if ( empty($datebirth) ) {  return false; }
        // if ( empty($datebirth) ) {  return '00-00-0000'; }
    
        $exp = explode("-", $datebirth); // [0] = 1964   [1] = 09    [2] = 20
        $datebirth = $exp[2]."-".$exp[1]."-".$exp[0];
        return $datebirth;
    }


} // chiude classe


/*
    DEBUG 

    die( $ );
    die( '' );
    var_dump( $ );
    echo '<pre>';print_r( $ );
    if ( isset( $ )) { var_dump( $ ); echo '<pre>';print_r( $ ); die(); }
 
    $test = "";
    if ( isset( $ )) { $test .= "settata, "; }
    if ( is_null( $ )) {$test .= "null, ";}
    if ( !$ ) {$test .= "false, ";} 
    if ( empty( $ )) {$test .= "empty, ";}
    echo $test;

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


