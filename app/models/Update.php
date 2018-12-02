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
     * Otteniamo dal database tutti i valori dei campi di un singolo utente
     * 
     * BIRTH
     * La data di nascita è immagazzinata nel database nel campo birth nel formato 1983-10-15
     * Per renderla leggibile e modificabile nel form dove c'è un elemento input del tipo:
     * <input type="date" value="birth">
     * basta tenere salvato nel database il valore della data di nascita nel formato: 1983-10-15
     * e il campo input la visualizzerà nel formato.: 15/10/1983
     * 
     * 
     * DATE ( come rendere leggibile e modificabile il valore della data nell' elemento input del form )
     * La data è immagazzinata nel database in tipo di carattere VARCHAR e nel formato 2018-12-04 16:21:00
     * Per renderla leggibile e modificabile nel form dove c'è un elemento input del tipo:
     * <input type="datetime-local" value="set_date">
     * bisogna convertire la data 2018-12-04 16:21:00
     * in formato timestamp con la funzione strtotime e passarla come secondo parametro
     * nella funzione date() che deve avere come primo parametro una stringa nel formato: Y-m-d\TH:i  
     * Quindi la funzione date() andrà scritta in questo modo:  date('Y-m-d\TH:i', strtotime($data));  
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

                // $user->birth = $this->getDateBirth($user->birth);

                //dal db set_date: 2018-12-04 16:21:00
                //da: 2018-12-04 16:21:00 a: 04-12-2018T16:21:00
                //$user->set_date = $this->getDatetimeLocal('update', $user->set_date); 

                // da: 2018-12-04 16:21:00  a: 2018-12-04T16:21
                $user->set_date = date('Y-m-d\TH:i', strtotime($user->set_date));
          
              
                $user->img = "/image/avatar/".$user->img;
                return $user;

            } else {

                die("ERRORE");
            }
        }
    }






/**
* UPDATE    

* Modifica un utente creato in precedenza                                                 
* image = COALESCE(NULLIF(:image, ''),image),


*/


/**
* UPDATE
* Modifica un utente creato in precedenza  
*
* COOKIE
* 
* l'elemento input del cookie è di tipo checkbox 
* <input type="checkbox" name="cookie" value="SI"> 
* se non viene messa la spunta
* il valore [cookie] non viene passato nell'array data.
* Quindi se :cookie [cookie] è uguale a null
* gli viene assegnato di default il valore 'NO'
* attraverso il comando: COALESCE(:cookie, 'NO')
* 
*
* TODO
* nell' array $data viene passato il valore  [MAX_FILE_SIZE] => 500000
* anche se non è stata caricata un immagine
* trovare un modo per evitare di far passare anche il valore di: MAX_FILE_SIZE
*
* @access public
* @param int $id
* @param array $data
* @return bool true
*/

public function updateUser(int $id, array $data=[]) {

    $sql = "UPDATE users
    SET img = COALESCE(:img, img), name = :name, gender = :gender, birth = :birth, fiscalcode = :fiscalcode,
    tel = :tel, email = :email, street = :street, cap = :cap, city = :city, country = :country, color1 = :color1,
    color2 = :color2, level = :level, look = :look, set_date = :set_date, upd_date = NOW(), info = :info, cookie = COALESCE(:cookie, 'NO') 
    WHERE id = :id";


    $stmt = $this->conn->prepare($sql);

    $stmt->bindParam(':id',         $id,                PDO::PARAM_INT, 255);
    $stmt->bindParam(':img',        $data['imageName'], PDO::PARAM_STR, 32);//   [imageName] => 5c02ca9ee47985.97262647.png
    $stmt->bindParam(':name',       $data['name'],      PDO::PARAM_STR, 32); //  [name] => Daniele
    $stmt->bindParam(':gender',     $data['gender'],    PDO::PARAM_STR, 6); //   [gender] => male
    $stmt->bindParam(':birth',      $data['birth'],     PDO::PARAM_STR, 32); //  [birth] => 1983-10-15
    $stmt->bindParam(':fiscalcode', $data['fiscalcode'],PDO::PARAM_STR, 16); //  [fiscalcode] => mnzdnl83r15h931h
    $stmt->bindParam(':tel',        $data['tel'],       PDO::PARAM_STR, 15); //  [tel] => 3331060677
    $stmt->bindParam(':email',      $data['email'],     PDO::PARAM_STR, 255);//  [email] => dmanzi83@hotmail
    $stmt->bindParam(':street',     $data['street'],    PDO::PARAM_STR, 32); //  [street] => Sepe
    $stmt->bindParam(':cap',        $data['cap'],       PDO::PARAM_STR, 10); //  [cap] => 80035
    $stmt->bindParam(':city',       $data['city'],      PDO::PARAM_STR, 32); //  [city] => Nola
    $stmt->bindParam(':country',    $data['country'],   PDO::PARAM_STR, 32);//   [country] => Italy
    $stmt->bindParam(':color1',     $data['color1'],    PDO::PARAM_STR, 7); //   [color1] => #000000
    $stmt->bindParam(':color2',     $data['color2'],    PDO::PARAM_STR, 7);//    [color2] => #000000
    $stmt->bindParam(':level',      $data['level'],     PDO::PARAM_STR, 32); //  [level] => 5
    $stmt->bindParam(':look',       $data['look'],      PDO::PARAM_STR, 32); //  [look] => adult
    $stmt->bindParam(':set_date',   $data['set_date'],  PDO::PARAM_STR, 32); //  [set_date] => 2018-12-05T16:21
    $stmt->bindParam(':info',       $data['info'],      PDO::PARAM_STR, 32); //  [info] => Lorem Ipsum
    $stmt->bindParam(':cookie',     $data['cookie'],    PDO::PARAM_STR, 2); //   [cookie] => SI
    
    $stmt->execute();
    $stmt = null;
    return true;
 }






 
/**
 * DELETE IMAGE  
 * 
 * Questo metodo si occupa solo di eliminare file dell'immagine vecchia
 * 
 * Quando si vuole cambiare l'immagine (in questo caso l' immagine dell' avatar)    
 * dobbiamo prima eliminare il file immagine attuale che sta nella cartella: public/image/avatar/,  
 * per dare il comando per cancellare il file esatto dobbiamo prima ottenere il nome del file,
 * il nome del file è immagazzinato nel database, della tabella users, del campo img, della riga che ha il numero del id che abbiamo
 * 
 * una volta ottenuto il nome del file dell'immagine vecchia e se l'immagine vecchia è diversa dall' immagine di default
 * l' immagine di default non deve essere mai cancellata 
 * utilizzando la funzione builtin di php 'unlink()' passandoci come argomento il percorso del file più il nome del file    
 * file dell'immagine vecchia viene eliminato   
 * 
 * @access public
 * @global string IMAGE_DEFAULT
 * @param int $id user id
 * @return void
 */

    public function deleteImage(int $id) {
   
        $sql = "SELECT img FROM users WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) { 

            $user = $stmt->fetch(PDO::FETCH_OBJ);

            if ( $user->img != IMAGE_DEFAULT ) { // 'avatar__default.jpg'

                unlink("public/image/avatar/".$user->img);
            }
        $stmt = null; 
        }
    }




    



// chiude DATE


} // chiude classe


/**
 * echo '<br>';
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


