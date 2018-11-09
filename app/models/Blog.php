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
public function getTotalPosts(){
    
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
    * Carica i dati da un file JSON 
    * Li converte in array di array Array
    * Esempio
        Array
        (
            [0] => Array
                (
                    [name] => Balrog
                    [birth] => 27-01-1967
                    [move] => Array
                        (
                            [0] => Rolling Crystal Claw
                            [1] => Flying Barcellona Attack
                        )
                )
            [1] => Array (...)
        )
    *
    * 'regdate' è una variabile che contiene la data attuale di creazione di ogni riga
    * che è uguale per tutte le righe perchè sono create nello stesso momento
    *
    * @access private
    * @author Daniele Manzi
    * @return int
    */
    public function loadUsers(){


        $jsondata = file_get_contents('./public/data/data.json');

        $datas = json_decode($jsondata, true);
    
        // REG_DATE 
        $regdate = date('d-m-Y H:i');
        
        $sql = 'INSERT INTO users (img, name, gender, birth, fiscalcode,  tel, email, street, cap, city, country, color1, color2, level, look, reg_date, info) 
                VALUES (:img, :name, :gender, :birth, :fiscalcode, :tel, :email, :street, :cap, :city, :country, :color1, :color2, :level, :look, :reg_date, :info)';
        $stmt = $this->conn->prepare($sql); 

        $num = 0;
        foreach ( $datas as $data) {

     /*       foreach($data as $prop ) {

                if ( is_null($data[$prop]) ) {  
    
                    $data[$prop] = false;
                }
            }*/
            
      
            $stmt->bindParam(':img',        $data['img'],         PDO::PARAM_STR, 32);
            $stmt->bindParam(':name',       $data['name'],        PDO::PARAM_STR, 20);
            $stmt->bindParam(':gender',     $data['gender'],      PDO::PARAM_STR, 10);
            $stmt->bindParam(':birth',      $data['birth'],       PDO::PARAM_STR, 10);
            $stmt->bindParam(':fiscalcode', $data['fiscalcode'],  PDO::PARAM_STR, 16);
            $stmt->bindParam(':tel',        $data['tel'],         PDO::PARAM_STR, 16);
            $stmt->bindParam(':email',      $data['email'],       PDO::PARAM_STR, 16);
            $stmt->bindParam(':street',     $data['address']['street'],    PDO::PARAM_STR, 16);
            $stmt->bindParam(':cap',        $data['address']['cap'],       PDO::PARAM_STR, 16);
            $stmt->bindParam(':city',       $data['address']['city'],      PDO::PARAM_STR, 16);
            $stmt->bindParam(':country',    $data['address']['country'],   PDO::PARAM_STR, 20);
            $stmt->bindParam(':color1',     $data['colors'][0],   PDO::PARAM_STR, 16);
            $stmt->bindParam(':color2',     $data['colors'][1],   PDO::PARAM_STR, 16);
            $stmt->bindParam(':level',      $data['level'],       PDO::PARAM_STR, 16);
            $stmt->bindParam(':look',       $data['look'],       PDO::PARAM_STR, 16);
            $stmt->bindParam(':reg_date',   $regdate,          PDO::PARAM_STR, 19);
            $stmt->bindParam(':info',       $data['info'],        PDO::PARAM_STR, 150);

            $stmt->execute();

            $num ++;
        }
        $this->conn = null;

        return $num;
        
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

        $res = $stmt->execute();
        
        $this->conn = null;

        return $res;

        // return $stmt->rowCount();

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


