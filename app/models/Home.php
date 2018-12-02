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
    * 
    *
    * @access public
    * @return array di oggetti $users
    */

/**
 * GET ALL USERS
 * 
 * l'array  $users contiene al suo interno tutte le righe della tabella users
 * ogni riga corrisponde a un oggetto stdClass Object 
 * $users[0] => ( [id] => 0, [name] => 'doe', [age] => 17 )
 * $users[1] => ( [id] => 1, [name] => 'foo', [age] => 85 )
 * ...
 * ogni riga è composta da più valori
 * 
 * Per ottenere il valore di $users[5][days]:
 *  [days] non è presente nella tabella users ma
 *  viene calcolato con il comando sql: TIMESTAMPDIFF
 *  funzionamento di TIMESTAMPDIFF: https://www.w3resource.com/mysql/date-and-time-functions/mysql-timestampdiff-function.php
 *  Calcola il tempo trascorso tra due date e restituisce il suo valore
 *  Parametro 1: restituisce la differenza tra due date nel tipo di unità scelto (nel nostro caso è DAY, ovvero numeri di giorni) 
 *    Il tipo di unità sono: FRAC_SECOND (microseconds), SECOND, MINUTE, HOUR, DAY, WEEK, MONTH, QUARTER, or YEAR.<br>
 *  Parametro 2: la data da cui comincia a contare 
 *  Parametro 3: la data in cui smette di contare. CURDATE() restituisce la data attuale in formato: 0000-00-00
 *    I paramametri 2 e 3 possono essere in formato date{es.: 0000-00-00} oppure datetime{es.: 0000-00-00 00:00:00}
 *    ma vengono sempre considerati datetime in quanto il comando TIMESTAMPDIFF aggiunge al formato date la parte time{00:00:00}
 *  Con il comando AS days gli diciamo che deve restituire il calcolo nella variabile days
 *
 * @access public
 * @return array di stdClass Object: $users
 */
    public function getAllUsers() {


        $sql = "SELECT *, TIMESTAMPDIFF(DAY, set_date, CURDATE()) AS days FROM users";

        $stmt = $this->conn->query($sql);
        
            if ($stmt->execute()) 
            {
               
                $users = $stmt->fetchAll(PDO::FETCH_OBJ); // FETCH_ASSOC | FETCH_OBJ
                
                foreach ( $users as $user) {
                  
                    $user->birth = $user->birth ? date('d-m-Y', strtotime($user->birth)) : 'assente';
                    $user->days = !is_null($user->days) ? $user->days : 'assente';
                    $user->upd_date = _timeago_from_sql_datetime($user->upd_date);
                }

                return $users; // ritorna un array di oggetti
            } else {
                die("ERRORE");
            }
    }








   










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
                    [name] => Rog
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
            $stmt->bindParam(':country',    $data['address']['country'],   PDO::PARAM_STR, 16);
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
     * @access public
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
echo "<br>";
die( $ );
die( '' );
var_dump( $ );
echo '<pre>';print_r( $ );
echo '<pre>';var_dump( $ );
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


/*
    MySQL viene fornito con i seguenti tipi di dati per la memorizzazione di una data o una data / ora nel database:
    DATE - format YYYY-MM-DD
    DATETIME - format: YYYY-MM-DD HH:MI:SS
    TIMESTAMP - format: YYYY-MM-DD HH:MI:SS
    YEAR - format YYYY or YY
*/


    // TIMESTAMPDIFF(MONTH, data_nascita, CURDATE( )) AS mesi,
    // TIMESTAMPDIFF(DAY, data_nascita, CURDATE( )) AS giorni