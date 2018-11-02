<?php
namespace app\models;

use app\models\Database;
use PDO; // importare la classe PDO per utilizzarla 

class Blog {


    private $conn;


    public function __construct() {

        $db = new Database;
        $this->conn = $db->getConnection();
    }
   
    


/*******************************************************************************************************|
* TOTAL POSTS                                                                                           |
* questo metodo verrà richiamato solo per la pagina posts/blog per creare la paginazione                |
* Otteniamo il numero totale in assoluto di tutti i post presenti nella tabella 'posts'                 |
* Lo scopo è quello di calcolare il numero di pagine per i post                                         |
* es. se abbiamo 30 post e vogliamo che vengano visualizzati 3 post ogni pagina                         |
* allora faremo 30post / 3 che ci darà 10 pagine. in questo modo potremo fare la paginazione            |
********************************************************************************************************/
public function totalPosts(){
    
    $sql = 'SELECT COUNT(*) FROM users';
    if ($res = $this->conn->query($sql)) {
        $rows = $res->fetchColumn();
        return $rows;
    }
}


/*******************************************************************************************************|
* PAGE POSTS                                                                                            |
* Facciamo una JOIN tra posts e users per ottenere tutti i posts con i dati dell' autore del post       |
* dalla tabella posts prendiamo [post_ID, title, datecreated, message]                                  |
* dalla tabella users prendiamo [user_email, user_name]                                                 |
* la relazione tra le tabelle posts e users è il campo posts.user_id e users.ID                         |
* in questo modo per ogni post abbiamo accesso ai dati dell'utente che ha scritto quel determinato post |                                              
********************************************************************************************************/
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

    public function getpageUsers($postStart=0, $postForPage=5) {

        $sql = "SELECT * FROM users LIMIT $postStart, $postForPage";

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





//---------------------------------------------------------------------------------------------------------------------------------------------------
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


