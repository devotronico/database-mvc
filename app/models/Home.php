<?php
namespace app\models;

use app\models\Database;
use PDO; // importare la classe PDO per utilizzarla 

class Home {


    private $conn;


    public function __construct() {

        $db = new Database;
        $this->conn = $db->getConnection();
    }
   
    

  /**
    * ALL
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

    public function getAllUsers() {


        $sql = "SELECT *, TIMESTAMPDIFF(DAY, set_date, CURDATE()) AS days FROM users";

        $stmt = $this->conn->query($sql);
        
            if ($stmt->execute()) 
            {
               
                $users = $stmt->fetchAll(PDO::FETCH_OBJ); // FETCH_ASSOC |  FETCH_OBJ
             
                return $users; // ritorna un array di oggetti
            } else {
                die("ERRORE");
            }
    }

  /**
    * SEARCH
    * 
    * Metodo `query()`: (http://php.net/manual/en/pdo.query.php) 
    * Il metodo `query()` di PDO esegue un'istruzione SQL di tipo SELECT  
    * e ritorna un oggetto PDOStatement del set di risultati.
    * Eseguendo un fetchAll sull' oggetto PDOStatement viene restituita
    * una matrice contenente tutte le righe del set di risultati
    * passare variabili come valore di colonna: `{$data['column']}`   {$data['column']}   ".$data['column']." 
    * @access private
    * @author Daniele Manzi
    * @return array di oggetti.
    */

    public function getDataFiltered(array $data) {


        switch ($data['time']) {
            case 'day':  $data['time'] = 2; break;
            case 'week': $data['time'] = 8; break;
            case 'month':$data['time'] = 32; break;
            case 'year': $data['time'] = 365; break;
            case 'ever': $data['time'] = 10000; break;
        }

        if ( empty( $data['keyword'] )) {

            $sql = "SELECT *, TIMESTAMPDIFF(DAY, set_date, CURDATE()) AS days FROM `users` 
            WHERE TIMESTAMPDIFF(DAY, set_date, CURDATE( )) < :time
            ORDER BY `{$data['orderby']}` {$data['dir']}"; 
        } else {

            $sql = "SELECT *, TIMESTAMPDIFF(DAY, set_date, CURDATE()) AS days FROM `users` 
            WHERE `{$data['where']}` LIKE :keyword AND TIMESTAMPDIFF(DAY, set_date, CURDATE( )) < :time
            ORDER BY `{$data['orderby']}` {$data['dir']}"; 
        }

        
        
        $stmt = $this->conn->prepare($sql);
      
      //  $data['keyword'] = "%{$data['keyword']}%";
       // $stmt->bindParam(':keyword', $data['keyword'], PDO::PARAM_STR, 20);
        $stmt->bindParam(':time', $data['time'], PDO::PARAM_STR, 20);

        if ($stmt->execute()) 
        {
        
            $users = $stmt->fetchAll(PDO::FETCH_OBJ); 
          
            return $users; // ritorna un array di oggetti
        } else {
            die("ERRORE");
        }
    }


    public function getTimeDiff(array $data) {

      //  $sql = "SELECT *,TIMESTAMPDIFF(DAY, set_date, CURDATE()) AS days ,TIMESTAMPDIFF(MONTH, set_date, CURDATE()) AS months, TIMESTAMPDIFF(YEAR, set_date, CURDATE()) AS years FROM users";

        $sql = "SELECT * 
        ,TIMESTAMPDIFF(DAY, set_date, CURDATE()) AS days ,TIMESTAMPDIFF(MONTH, set_date, CURDATE()) AS months, TIMESTAMPDIFF(YEAR, set_date, CURDATE()) AS years 
        FROM users WHERE TIMESTAMPDIFF(DAY, set_date, CURDATE( )) < :time ORDER BY level DESC";

        // $sql = "SELECT * FROM users WHERE DATEDIFF(set_date, CURDATE()) > 0";

        $stmt = $this->conn->prepare($sql);
        
        //$data['keyword'] = "%{$data['keyword']}%";
        
        $stmt->bindParam(':time', $data['time'], PDO::PARAM_STR, 20);

        if ($stmt->execute()) 
        {
        
            $users = $stmt->fetchAll(PDO::FETCH_OBJ); 
            if ( isset( $users )) {  echo '<pre>';print_r( $users );  }

            return $users; // ritorna un array di oggetti
        } else {
            die("ERRORE");
        }

    }

    // TIMESTAMPDIFF(MONTH, data_nascita, CURDATE( )) AS mesi,
    // TIMESTAMPDIFF(DAY, data_nascita, CURDATE( )) AS giorni






// PAGE =========================    

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




/*
MySQL comes with the following data types for storing a date or a date/time value in the database:

    DATE - format YYYY-MM-DD
    DATETIME - format: YYYY-MM-DD HH:MI:SS
    TIMESTAMP - format: YYYY-MM-DD HH:MI:SS
    YEAR - format YYYY or YY
*/

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
    
        // DATE
        //$upddate = time(); // da fixare
        //$regdate = date('d-m-Y H:i');
      
        
        $sql = 'INSERT INTO users (img, name, gender, birth, fiscalcode, tel, email, street, cap, city, country, color1, color2, level, look, upd_date, reg_date, info) 
                VALUES (:img, :name, :gender, :birth, :fiscalcode, :tel, :email, :street, :cap, :city, :country, :color1, :color2, :level, :look, NOW(), NOW(), :info)';
        $stmt = $this->conn->prepare($sql); 

        $num = 0;
        foreach ( $datas as $data) {

      
            $stmt->bindParam(':img',        $data['img'],         PDO::PARAM_STR, 32);
            $stmt->bindParam(':name',       $data['name'],        PDO::PARAM_STR, 20);
            $stmt->bindParam(':gender',     $data['gender'],      PDO::PARAM_STR, 10);
            $stmt->bindParam(':birth',      $data['birth'],       PDO::PARAM_STR, 10); //COLONNA TIPO DATE 0000-00-00
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
            $stmt->bindParam(':look',       $data['look'],        PDO::PARAM_STR, 16); //COLONNA TIPO VARCHAR 
           // $stmt->bindParam(':upd_date',   $upddate,             PDO::PARAM_STR, 19); //COLONNA TIPO DATETIME -> 0000-00-00 00:00:00
           // $stmt->bindParam(':reg_date',   $regdate,             PDO::PARAM_STR, 19); //COLONNA TIPO VARCHAR 
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
     * Svuota il database
     *
     * @access private
     * @author Daniele Manzi
     * @global object GET
     * @return bool true
     */
    public function resetUsers(){
        
        $sql = 'TRUNCATE TABLE users';

        $stmt = $this->conn->prepare($sql); 

        $res = $stmt->execute();
        
        $this->conn = null;

        return $res;
    }




} // chiude classe


/*
die( $ );
die( '' );
var_dump( $ );
echo '<pre>';print_r( $ );
var_export( $ );
if ( isset( $users )) { var_dump( $users ); echo '<pre>';print_r( $users ); var_export( $ ); die(); }

$test = "";
if ( is_null( $var )) {$test .= "null, ";}
if ( isset( $var )) { $test .= "settata, "; }
if ( !$var ) {$test .= "false, ";} 
if ( empty( $var )) {$test .= "empty, ";}
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


