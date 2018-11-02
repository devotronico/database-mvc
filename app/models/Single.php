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
     * LOAD USERS
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
    public function loadUsers(){


        $jsondata = file_get_contents('./public/data/sf.json');

        $data = json_decode($jsondata, true);

        // REG_DATE 
        $regdate = date('d-m-Y H:i');
        
        $sql = 'INSERT INTO users (img, name, gender, country, birth, move_1, move_2, move_3, super, reg_date) 
                VALUES (:img, :name, :gender, :country, :birth, :move_1, :move_2, :move_3, :super, :reg_date)';
        $stmt = $this->conn->prepare($sql); 

        foreach ( $data as $d ) {

            $stmt->bindParam(':img',      $d['img'],         PDO::PARAM_STR, 16);
            $stmt->bindParam(':name',     $d['name'],        PDO::PARAM_STR, 20);
            $stmt->bindParam(':gender',   $d['gender'],      PDO::PARAM_STR, 10);
            $stmt->bindParam(':country',  $d['country'],     PDO::PARAM_STR, 20);
            $stmt->bindParam(':birth',    $d['birth'],       PDO::PARAM_STR, 10);
            $stmt->bindParam(':move_1',   $d['move'][0],     PDO::PARAM_STR, 16);
            $stmt->bindParam(':move_2',   $d['move'][1],     PDO::PARAM_STR, 16);
            $stmt->bindParam(':move_3',   $d['move'][2],     PDO::PARAM_STR, 16);
            $stmt->bindParam(':super',    $d['super'],       PDO::PARAM_STR, 16);
            $stmt->bindParam(':reg_date', $regdate,          PDO::PARAM_STR, 19);

            $stmt->execute();
        }
        $this->conn = null;
        
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
     * @return object Photo
     */
    public function createUser(array $data=[]){


        // BIRTH
        // dal form la data arriva in questo formato: 2000-12-30
        // ma voglio cambiarla in questo formato: 30/12/2000
        $exp = explode("-", $data['birth']); // [0] = 1964   [1] = 09    [2] = 20
        $data['birth'] = $exp[2]."-".$exp[1]."-".$exp[0];

        // REG_DATE 


        $regdate = date('d-m-Y H:i');
        $sql = 'INSERT INTO users (name, gender, country, birth, reg_date) VALUES (:name, :gender, :country, :birth, :reg_date)';
        $stm = $this->conn->prepare($sql); 
        $stm->execute([ 
           
            'name'=> $data['name'], 
            'gender'=> $data['gender'], 
            'country'=>$data['country'], 
            'birth'=>$data['birth'], 
            'reg_date'=>$regdate,
     
        ]); 
        $conn = null;
        return $stm->rowCount();
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
                   
                    break;
                    case "update":

                         // BIRTH
                        $exp = explode("-", $user->birth); // [0] = 30  [1] = 12    [2] = 1950
                        $user->birth = $exp[2]."-".$exp[1]."-".$exp[0];

                        // REG_DATE  29-10-2018 16:03 ->  2018-10-29T16:03
                        $expFirst = explode(" ", $user->reg_date); // $expFirst[0] = 29-10-2018      $expFirst[1] = 16:03
                        $temp = $expFirst[0];
                        $expSecond = explode("-", $temp); // [0] = 29   [1] = 10    [2] = 2018
                        $user->reg_date = $expSecond[2]."-".$expSecond[1]."-".$expSecond[0]."T".$expFirst[1];
                    break;
                    case "delete":  break;
                }
           

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
        

     // BIRTH
     $exp = explode("-", $data['birth']); // [0] = 1964   [1] = 09    [2] = 20
     $data['birth'] = $exp[2]."-".$exp[1]."-".$exp[0];


    // REG_DATE  2018-10-29T16:03 -> 29-10-2018 16:03
    $expFirst = explode("T", $data['reg_date']); // $expFirst[0] = 2018-10-29      $expFirst[1] = 16:03
    $temp = $expFirst[0];
    $expSecond = explode("-", $temp); // [0] = 2018   [1] = 10    [2] = 29
    $data['reg_date'] = $expSecond[2]."-".$expSecond[1]."-".$expSecond[0]." ".$expFirst[1];


    $sql = "UPDATE users SET name = :name, gender = :gender, country = :country, birth = :birth, reg_date = :reg_date  WHERE id = :id";

    $stmt = $this->conn->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR, 255);
    $stmt->bindParam(':gender', $data['gender'], PDO::PARAM_STR, 255);
    $stmt->bindParam(':country', $data['country'], PDO::PARAM_STR, 255);
    $stmt->bindParam(':birth', $data['birth'], PDO::PARAM_STR, 255);
    $stmt->bindParam(':reg_date', $data['reg_date'], PDO::PARAM_STR, 255);
    
    $stmt->execute();
    $conn = null;
    return $stmt->rowCount();
 }






 public function deleteUser(int $id){
        
    $sql = 'DELETE FROM users WHERE id = :id';
    $stm = $this->conn->prepare($sql); 
    $stm->bindParam(':id', $id, PDO::PARAM_INT); 
    $stm->execute(); 
 }








} // chiude classe


/**
 * die( $ );
 * die( '' );
 * var_dump( $ );
 * echo '<pre>';print_r( $ );
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


