<?php
namespace app\models;

use app\models\Database;
use PDO; // importare la classe PDO per utilizzarla 

class Search {


    private $conn;


    public function __construct() {

        $db = new Database;
        $this->conn = $db->getConnection();
    }








/**
 * GET DATA FILTERED
 * 
 * 
 *
 * @access public
 * @param array $data
 * @return array di stdClass Object: $users
 */

    public function getDataFiltered(array $data) {

      
        switch ($data['time']) {
            case 'day':  $data['time'] = 2; break;
            case 'week': $data['time'] = 8; break;
            case 'month':$data['time'] = 32; break;
            case 'year': $data['time'] = 366; break;
            case 'ever': $data['time'] = 10000; break;
        }

        if ( empty( $data['keyword'] )) {

            return $this->noKeyword($data);

        } else {

            return $this->withKeyword($data);
   
        }
    }





    
/**
 * NO KEYWORD
 * 
 * Seleziona{SELECT} e ottiene il valore di:
 *  tutti i campi
 *  e del tempo trascorso in giorni da set_date{data di partenza} a CURDATE(){data attuale} 
 *
 * Dove{WHERE} il tempo trascorso è minore di $data['time']: day, week, month, year, ever
 * 
 * Ordinato{ORDER By} per un campo specifico
 * 
 * Direzione{ASC}{DESC} ascendente oppure discendente
 * @access private
 * @param array $data
 * @return array di stdClass Object: $users
 */
    private function noKeyword(array $data) {

        $sql = "SELECT *, TIMESTAMPDIFF(DAY, set_date, CURDATE()) AS days FROM `users` 
        WHERE TIMESTAMPDIFF(DAY, set_date, CURDATE( )) < :time
        ORDER BY `{$data['orderby']}` {$data['dir']}"; 

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':time', $data['time'], PDO::PARAM_STR, 20);

        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_OBJ); 

        return $users; // ritorna un array di oggetti
    }



    private function withKeyword(array $data) {

        $sql = "SELECT *, TIMESTAMPDIFF(DAY, set_date, CURDATE()) AS days FROM `users` 
        WHERE `{$data['where']}` LIKE :keyword AND TIMESTAMPDIFF(DAY, set_date, CURDATE( )) < :time
        ORDER BY `{$data['orderby']}` {$data['dir']}"; 

        $stmt = $this->conn->prepare($sql);
      
        $data['keyword'] = "%{$data['keyword']}%";
        $stmt->bindParam(':keyword', $data['keyword'], PDO::PARAM_STR, 20);
        $stmt->bindParam(':time', $data['time'], PDO::PARAM_STR, 20);

        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_OBJ); 

        return $users; // ritorna un array di oggetti
    }







/*
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
*/




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