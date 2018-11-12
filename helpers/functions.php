<?php



function _view( array $files=[], array $data=[]) {
  extract($data);
  ob_start(); // catturiamo tutto nel buffer
  foreach ( $files as $file ) {require 'app/views/'.$file.'.tpl.php';}// i post andranno in questo file di template
  $template = ob_get_contents(); // nella variabile viene immagazzionato tutto il template catturato
  ob_end_clean(); // liberiamo la memoria | meglio disattivare altrimenti non ritorna $data
  return $template;
}




function _redirect($uri ='/', $message=''){

  $mess = !empty($message)?"?message=".urlencode($message):'';
  header("Location:".$uri.$mess);
  die(); // die è più veloce di exit
}





/**
 * $timestamp =  time();
 * echo "<br>";
 * echo $timestamp; // 1541839549
 * echo "<br>";
 * echo date('d-m-Y H:i:s', $timestamp); // 1970-01-18 20:17:19
 * echo "<br>";
 * echo get_time_ago( $timestamp ); // less than 1 second ago
 */
/*
function _get_time_ago( $time )
{
    $time_difference = time() - $time;

    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
}
*/



 

 /**
  * funzione che converte il tipo di dato DATETIME del database SQL ( 2018-11-11 16:56:59 )
  * nel formato stringa time ago ( 15 hours )
  * 
  * primo argomento:
  * accetta una stringa nel formato DATETIME del database SQL:  2018-11-11 16:56:59
  *
  * secondo argomento: 
  * se viene passato false o niente restituisce una stringa nel formato:  15 hours
  * se viene passato true restituisce una stringa nel formato:  15 hours, 36 minutes, 31 seconds ago
  */
function _timeago_from_sql_datetime($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}