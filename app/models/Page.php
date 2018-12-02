<?php
namespace app\models;

use app\models\Database;
use PDO;

class Page {


    private $conn;


    public function __construct() {

        $db = new Database;
        $this->conn = $db->getConnection();
    }








/**
 * GET TOTAL USERS  
 * 
 * Ritorna il numero totale di tutte le righe della tabella users
 * 
 * Lo scopo è quello di calcolare il numero di pagine
 * es. se abbiamo 30 righe nella tabella users e
 * vogliamo che vengano visualizzati 3 righe per ogni pagina
 * allora faremo 30 user / 3 che ci darà 10 pagine. in questo modo potremo fare la paginazione
 *
 * @access public
 * @return int $rows numero righe della tabella users
 */
public function getTotalUsers(){
    
    $sql = 'SELECT COUNT(*) FROM users';
    if ($res = $this->conn->query($sql)) {
        $rows = $res->fetchColumn();
        return $rows;
    }
}








    /**
    * GET PAGE USERS
    * 
    *
    * @access public
    * @return array di oggetti.
    */

    public function getpageUsers($postStart=0, $postForPage=5) {

        $sql = "SELECT *, TIMESTAMPDIFF(DAY, set_date, CURDATE()) AS days FROM users LIMIT $postStart, $postForPage";

        if ($stmt = $this->conn->query($sql)) 
        {
        
            if ($stmt->execute()) 
            {
               
                $users = $stmt->fetchAll(PDO::FETCH_OBJ); 

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
    }





} // chiude classe


/**
 * die( $ );
 * die( '' );
 * var_dump( $ );
 * echo '<pre>';print_r( $ );
 * var_export( $ );
 *  // if ( isset( $users )) { var_dump( $users ); echo '<pre>';print_r( $users ); var_export( $ ); die(); }

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


