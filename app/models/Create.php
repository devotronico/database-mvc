<?php
namespace app\models;

use app\models\Database;
use PDO; // importare la classe PDO per utilizzarla 

class Create {


    private $conn;


    public function __construct() {

        $db = new Database;
        $this->conn = $db->getConnection();
    }








    /**
     * CREATE USER
     * 
     * Questo metodo si occupa di immagazzinare dentro la tabella users una
     * nuova riga con tutti i dati che sono stati immessi nel form
     *  
     *
     * @access public
     * @param array $data
     * @return bool 
     */
    public function createUser(array $data=[]) {


  //  if ( isset( $data )) { var_dump( $data); echo '<pre>';print_r( $data ); die(); }

$sql = 'INSERT INTO users (img, name, gender, birth, fiscalcode,  tel, email, street, cap, city, country, color1, color2, level, look, set_date, upd_date, reg_date, info, cookie) 
VALUES (:img, :name, :gender, :birth, :fiscalcode, :tel, :email, :street, :cap, :city, :country, :color1, :color2, :level, :look, :set_date, NOW(), NOW(), :info, :cookie)';

        $stmt = $this->conn->prepare($sql); 

        $stmt->bindParam(':img',        $data['imageName'], PDO::PARAM_STR, 32);
        $stmt->bindParam(':name',       $data['name'],      PDO::PARAM_STR, 32);
        $stmt->bindParam(':gender',     $data['gender'],    PDO::PARAM_STR, 6);
        $stmt->bindParam(':birth',      $data['birth'],     PDO::PARAM_STR, 10);
        $stmt->bindParam(':fiscalcode', $data['fiscalcode'],PDO::PARAM_STR, 16);
        $stmt->bindParam(':tel',        $data['tel'],       PDO::PARAM_STR, 15);
        $stmt->bindParam(':email',      $data['email'],     PDO::PARAM_STR, 255);
        $stmt->bindParam(':street',     $data['street'],    PDO::PARAM_STR, 16);
        $stmt->bindParam(':cap',        $data['cap'],       PDO::PARAM_STR, 10);
        $stmt->bindParam(':city',       $data['city'],      PDO::PARAM_STR, 16);
        $stmt->bindParam(':country',    $data['country'],   PDO::PARAM_STR, 32);
        $stmt->bindParam(':color1',     $data['color1'],    PDO::PARAM_STR, 7);
        $stmt->bindParam(':color2',     $data['color2'],    PDO::PARAM_STR, 7);
        $stmt->bindParam(':level',      $data['level'],     PDO::PARAM_STR, 3);
        $stmt->bindParam(':look',       $data['look'],      PDO::PARAM_STR, 16);
        $stmt->bindParam(':set_date',   $data['set_date'],  PDO::PARAM_STR, 19);
        $stmt->bindParam(':info',       $data['info'],      PDO::PARAM_STR, 150);
        $stmt->bindParam(':cookie',     $data['cookie'],    PDO::PARAM_STR, 16);

        return $stmt->execute();
    }
// END CREATE USER        








} // chiude classe


/*
  die( $ );
  die( '' );
  var_dump( $ );
  echo '<pre>';print_r( $ );
  if ( isset( $ )) { var_dump( $ ); echo '<pre>';print_r( $ ); die(); }
 
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


