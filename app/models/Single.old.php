<?php
namespace app\models;

use app\models\Database;
use PDO; // importare la classe PDO per utilizzarla 

class Single {


    private $conn;


    public function __construct() {

        $db = new Database;
        $this->conn = $db->getConnection();
    }
   
    




  




    /**
     * RESET USERS
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
    public function resetUsers(){
        
        $sql = 'TRUNCATE TABLE users';

        $stmt = $this->conn->prepare($sql); 

        $stmt->execute();
        
        $this->conn = null;
    }







    /**
    * ALL USERS
    * 
    * Metodo `query()`: (http://php.net/manual/en/pdo.query.php) 
    * Il metodo `query()` di PDO esegue un'istruzione SQL di tipo SELECT  
    * e ritorna un oggetto PDOStatement del set di risultati.
    * Eseguendo un fetchAll sull' oggetto PDOStatement viene restituita
    * una matrice contenente tutte le righe del set di risultati
    *
    * @access private
    * @author Daniele Manzi
    * @return array di oggetti.
    */
    public function allUsers() {

        $sql = "SELECT * FROM users";

        if ($stmt = $this->conn->query($sql)) 
        {
        
            if ($stmt->execute()) 
            {
               
                $users = $stmt->fetchAll(PDO::FETCH_OBJ); // FETCH_ASSOC |  FETCH_OBJ
             

                return $users; // ritorna un array di oggetti
            } else {
                die("ERRORE");
            }
        }
    }



    private function getDatetimeLocal( string $type, string $datetime){

        // REG_DATE  2018-10-29T16:03 -> 29-10-2018 16:03
        switch ( $type ) {

            case 'create': // Elimina nella stringa il carattere 'T' per salvarla nel database e renderla leggibile dal utente
            if ( empty($datetime) ) { return false; }
            // if ( empty($datetime) ) { return 'yyyy-MM-dd hh:mm'; }
            // if ( empty($datetime) ) { return '00-00-0000 00:00'; }
                $expFirst = explode("T", $datetime); // $expFirst[0] = 2018-10-29      $expFirst[1] = 16:03
                $temp = $expFirst[0];
                $expSecond = explode("-", $temp); // [0] = 2018   [1] = 10    [2] = 29
                $datetime = $expSecond[2]."-".$expSecond[1]."-".$expSecond[0]." ".$expFirst[1];
            break;

            case 'update': // Inserisce nella stringa il carattere 'T' per renderla leggibile dal form
            if ( empty($datetime) ) { return false; }
            // if ( empty($datetime) ) { return 'yyyy-MM-ddThh:mm'; }
            // if ( empty($datetime) ) { return '00-00-0000T00:00'; }
                $expFirst = explode(" ", $datetime); // $expFirst[0] = 29-10-2018      $expFirst[1] = 16:03
                $temp = $expFirst[0];
                $expSecond = explode("-", $temp); // [0] = 29   [1] = 10    [2] = 2018
                $datetime = $expSecond[2]."-".$expSecond[1]."-".$expSecond[0]."T".$expFirst[1];
            break;

        }
        return $datetime;
    }



    private function getDateBirth(string $datebirth){
        // BIRTH
        // dal form la data arriva in questo formato: 2000-12-30
        // ma la cambiamo in questo formato: 30-12-2000
        if ( empty($datebirth) ) {  return false; }
        // if ( empty($datebirth) ) {  return '00-00-0000'; }

        $exp = explode("-", $datebirth); // [0] = 1964   [1] = 09    [2] = 20
        $datebirth = $exp[2]."-".$exp[1]."-".$exp[0];
        return $datebirth;
    }




    /**
     * CREATE USER
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
     * @return string 
     */
    public function createUser(array $data=[]) {

        $regdate = date('d-m-Y H:i');  // REG_DATE 

        foreach ( $data as $prop ) {

            if ( is_null($data[$prop]) ) {  

                $data[$prop] = false;
            }
        }

        $sql = 'INSERT INTO users (img, name, gender, email, country, color1, color2, level, look, birth, set_date, reg_date, cookie)
        VALUES (:img, :name, :gender, :email, :country, :color1, :color2, :level, :look, :birth, :set_date, :reg_date, :cookie)';

        $stmt = $this->conn->prepare($sql); 

        $stmt->bindParam(':img',        $data['imageName'], PDO::PARAM_STR, 32);
        $stmt->bindParam(':name',       $data['name'],      PDO::PARAM_STR, 32);
        $stmt->bindParam(':gender',     $data['gender'],    PDO::PARAM_STR, 32);
        $stmt->bindParam(':birth',      $data['birth'],     PDO::PARAM_STR, 32);
        $stmt->bindParam(':fiscalcode', $data['fiscalcode'],PDO::PARAM_STR, 16);
        $stmt->bindParam(':tel',        $data['tel'],       PDO::PARAM_STR, 16);
        $stmt->bindParam(':email',      $data['email'],     PDO::PARAM_STR, 32);
        $stmt->bindParam(':country',    $data['country'],   PDO::PARAM_STR, 32);
        $stmt->bindParam(':color1',     $data['color1'],    PDO::PARAM_STR, 16);
        $stmt->bindParam(':color2',     $data['color2'],    PDO::PARAM_STR, 16);
        $stmt->bindParam(':level',      $data['level'],     PDO::PARAM_STR, 16);
        $stmt->bindParam(':look',       $data['look'],      PDO::PARAM_STR, 16);
        $stmt->bindParam(':set_date',   $data['set_date'],  PDO::PARAM_STR, 32);
        $stmt->bindParam(':reg_date',   $regdate,           PDO::PARAM_STR, 32);
        $stmt->bindParam(':info',       $data['info'],      PDO::PARAM_STR, 16);
        $stmt->bindParam(':cookie',     $data['cookie'],    PDO::PARAM_STR, 32);

        return $stmt->execute();
    }
// END CREATE USER        








    /**
     * SINGLE USER
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
    public function singleUser($id, $type) {

        $sql = "SELECT * FROM users WHERE id = $id";

        if ($stmt = $this->conn->query($sql)) 
        {
            $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);

            if ($stmt->execute()) 
            {
                   
                $user = $stmt->fetch(PDO::FETCH_OBJ); // FETCH_ASSOC  |   FETCH_OBJ

                switch ( $type ) {

                    case "read":
                    //   
                    break;
                    case "update":

                        $user->birth = $this->getDateBirth($user->birth);

                        $user->set_date = $this->getDatetimeLocal('update', $user->set_date);
                        
                        $user->reg_date = $this->getDatetimeLocal('update', $user->reg_date);
                    break;
                   // case "delete":  break;
                }
           
                $user->img = "/image/avatar/".$user->img;
                return $user;

            } else {

                die("ERRORE");
            }
        }
    }







/***************************************************************************************|
* UPDATE                                                                                |
* Modifica un post creato in precedenza                                                 |
* image = COALESCE(NULLIF(:image, ''),image),
****************************************************************************************/
public function updateUser(int $id, array $data=[]){
        
    // CANCELLARE IMMAGINE
    //$data['imageName'] = !is_null($data['imageName']) ? $data['imageName'] : 'avatar__default.png';


    // DATE
    $data['birth'] = $this->getDateBirth($data['birth']);
    $data['set_date'] = $this->getDatetimeLocal('create', $data['set_date']);
    $data['reg_date'] = $this->getDatetimeLocal('create', $data['reg_date']);
                        

    // if ( isset( $data['imageName'] ))   { echo '<pre>';print_r( $data['imageName'] );'</pre>'; }
   

    $sql = "UPDATE users
    SET img = COALESCE(NULLIF(:img, ''),img), name = :name, gender = :gender, email = :email, country = :country,
    color = :color, level = :level, look = :look, birth = :birth, set_date = :set_date, reg_date = :reg_date, cookie = :cookie 
    WHERE id = :id";

    $stmt = $this->conn->prepare($sql);

    $stmt->bindParam(':id',         $id,                PDO::PARAM_INT, 255);
    $stmt->bindParam(':img',        $data['imageName'], PDO::PARAM_STR, 32);
    $stmt->bindParam(':name',       $data['name'],      PDO::PARAM_STR, 32);
    $stmt->bindParam(':gender',     $data['gender'],    PDO::PARAM_STR, 32);
    $stmt->bindParam(':email',      $data['email'],     PDO::PARAM_STR, 32);
    $stmt->bindParam(':country',    $data['country'],   PDO::PARAM_STR, 32);
    $stmt->bindParam(':color1',     $data['color1'],    PDO::PARAM_STR, 32);
    $stmt->bindParam(':color2',     $data['color2'],    PDO::PARAM_STR, 32);
    $stmt->bindParam(':level',      $data['level'],     PDO::PARAM_STR, 32);
    $stmt->bindParam(':look',       $data['look'],      PDO::PARAM_STR, 32);
    $stmt->bindParam(':birth',      $data['birth'],     PDO::PARAM_STR, 32);
    $stmt->bindParam(':set_date',   $data['set_date'],  PDO::PARAM_STR, 32);
    $stmt->bindParam(':reg_date',   $data['reg_date'],  PDO::PARAM_STR, 32);
    $stmt->bindParam(':cookie',     $data['cookie'],    PDO::PARAM_STR, 32);
    
    $stmt->execute();
    $stmt = null;
    return true;
 }




/***************************************************************************************|
* SET IMAGE DEFAULT                                                                                
* Assegna immagine di default                                                 
* 
****************************************************************************************/
public function setImageDefault(int $id){
        
    $imageName = 'avatar__default.png';
                           
    $sql = "UPDATE users SET img = :img WHERE id = :id";

    $stmt = $this->conn->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
    $stmt->bindParam(':img', $imageName, PDO::PARAM_STR, 32);
   
    $stmt->execute();
    $stmt = null;
    return true;
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

            if ( $user->img != 'avatar__default.png' ) {

                unlink("public/image/avatar/".$user->img);
            }
        $stmt = null; 
        }
    }



    /*******************************************************************************************************************|
    * CHECK IMAGE EXISTS     !!!! [METODO NON USATO]                                                                                          
    * Se durante lo sviluppo decidiamo di cancellare delle immagini dei post a mano                                     |
    * questo metodo in automatico si occupa di cancellare anche il nome del file che è memorizzato nel database         |
    ********************************************************************************************************************/
    public function checkImageExists($id) {
    
        $id = (int)$id;
        $sql = "SELECT img FROM users WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) { 

            $user = $stmt->fetch(PDO::FETCH_OBJ);

            if ( $user->img != 'avatar__default.png' ) {

                $filename = "/image/avatar/".$user->img;

                if (!file_exists($filename)) {
               
                    $sql = "UPDATE users SET img = null WHERE id = :id";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
        } 
    }
// CHIUDE UPDATE









 public function deleteUser(int $id){
        
    $sql = 'DELETE FROM users WHERE id = :id';
    $stmt = $this->conn->prepare($sql); 
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
    $stmt->execute(); 
    return $stmt->rowCount();
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


