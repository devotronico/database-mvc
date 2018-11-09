<?php
namespace app\models;

use app\models\Database;
use PDO; // importare la classe PDO per utilizzarla 

class Update {


    private $conn;


    public function __construct() {

        $db = new Database;
        $this->conn = $db->getConnection();
    }
   
    





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
    public function singleUser($id) {

        $sql = "SELECT * FROM users WHERE id = $id";

        if ($stmt = $this->conn->query($sql)) 
        {
            $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);

            if ($stmt->execute()) 
            {
                   
                $user = $stmt->fetch(PDO::FETCH_OBJ); // FETCH_ASSOC  |   FETCH_OBJ

                $user->birth = $this->getDateBirth($user->birth);

                $user->set_date = $this->getDatetimeLocal('update', $user->set_date);
                
                $user->reg_date = $this->getDatetimeLocal('update', $user->reg_date);
        
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
        

    // DATE
    $data['birth'] = $this->getDateBirth($data['birth']);
    $data['set_date'] = $this->getDatetimeLocal('create', $data['set_date']);
    $data['reg_date'] = $this->getDatetimeLocal('create', $data['reg_date']);
                        


    $sql = "UPDATE users
    SET img = COALESCE(NULLIF(:img, ''),img), name = :name, gender = :gender, birth = :birth, fiscalcode = :fiscalcode,
    tel = :tel, email = :email, street = :street, cap = :cap, city = :city, country = :country, color1 = :color1,
    color2 = :color2, level = :level, look = :look, set_date = :set_date, reg_date = :reg_date, info = :info, cookie = :cookie 
    WHERE id = :id";

    $stmt = $this->conn->prepare($sql);

    $stmt->bindParam(':id',         $id,                PDO::PARAM_INT, 255);
    $stmt->bindParam(':img',        $data['imageName'], PDO::PARAM_STR, 32);
    $stmt->bindParam(':name',       $data['name'],      PDO::PARAM_STR, 32);
    $stmt->bindParam(':gender',     $data['gender'],    PDO::PARAM_STR, 6);
    $stmt->bindParam(':birth',      $data['birth'],     PDO::PARAM_STR, 32);
    $stmt->bindParam(':fiscalcode', $data['fiscalcode'],PDO::PARAM_STR, 16);
    $stmt->bindParam(':tel',        $data['tel'],       PDO::PARAM_STR, 15);
    $stmt->bindParam(':email',      $data['email'],     PDO::PARAM_STR, 255);
    $stmt->bindParam(':street',     $data['street'],    PDO::PARAM_STR, 32);
    $stmt->bindParam(':cap',        $data['cap'],       PDO::PARAM_STR, 10);
    $stmt->bindParam(':city',       $data['city'],      PDO::PARAM_STR, 32);
    $stmt->bindParam(':country',    $data['country'],   PDO::PARAM_STR, 32);
    $stmt->bindParam(':color1',     $data['color1'],    PDO::PARAM_STR, 7);
    $stmt->bindParam(':color2',     $data['color2'],    PDO::PARAM_STR, 7);
    $stmt->bindParam(':level',      $data['level'],     PDO::PARAM_STR, 32);
    $stmt->bindParam(':look',       $data['look'],      PDO::PARAM_STR, 32);
    $stmt->bindParam(':set_date',   $data['set_date'],  PDO::PARAM_STR, 32);
    $stmt->bindParam(':reg_date',   $data['reg_date'],  PDO::PARAM_STR, 32);
    $stmt->bindParam(':info',       $data['info'],      PDO::PARAM_STR, 32);
    $stmt->bindParam(':cookie',     $data['cookie'],    PDO::PARAM_STR, 32);
    
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

            if ( $user->img != 'avatar-default.png' ) {

                unlink("public/image/avatar/".$user->img);
            }
        $stmt = null; 
        }
    }




    



    
// DATE
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
// chiude DATE


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

