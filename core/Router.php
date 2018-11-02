<?php

class Router
{
   // protected $conn;

    protected $routes = [

        // 'GET'=>[],
        // 'POST'=>[],
    ];

  
    
   // public function __construct(\PDO $conn){ 
    public function __construct(){ 

      //  $this->conn = $conn;  

    }
    

    // $listOfRoutes = [ "test-1" => "ClassTest1@funcTest1", "test-2" => "ClassTest2@funcTest2",];

    public function loadRoutes(array $routes){ //  $routes=[]
        // inizializziamo l'array $routes con un array:
        // che ha per chiavi tutte le rotte attivabili tramite i link (es. <a href="/test">TEST</a> cambierà l'URL in http://miosito/test)
        // e come valori una stringa che comprende la classe e il metodo della classe (es. ClasseTest@funcTest)
        // esempio di un' accoppiata chiave e valore dell'array:  "test" => "ClassTest@funcTest" 
        $this->routes = $routes;
    }




    // questo metodo ci da GET/POST e la Path es. 'post/2'
    public function dispatch(){ 
        // LEGGIAMO l URL (es.  https://www.example.com/subFolder/yourfile.php?var=blabla#555)  
        // https://         = Protocollo
        // www.example.com  = Nome Host
        // /folder/file.php = Path
        // ?var=blabla#555  = Parametri
        // $_SERVER['REQUEST_URI'] restituisce la stringa che viene dopo il nome del Host (es. /subFolder/yourfile.php?var=blabla#555)  

        // Con parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) :
        //  tagliamo da /subFolder/yourfile.php?var=blabla#555 i parametri che iniziano dal simbolo '?' (es. /subFolder/yourfile.php)   
    
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // elimina Protocollo, Host e Parametri dall 'URL
        // $_SERVER["PHP_SELF"] è uguale a parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ? [!?]

        $uri = trim($uri, '/'); // elimina il carattere speciale '/' all'inizio e alla fine della stringa | es. '/post/2' diventa 'post/2'



        // la variabile superglobal $_SERVER['REQUEST_METHOD'] ci restituisce il metodo POST o GET
        return $this->processQueue($uri, $_SERVER['REQUEST_METHOD']);
    }

    
    protected function processQueue($uri, $method='GET'){

        $routes = $this->routes[$method]; // GET o POST

        
     
        foreach ( $routes as $route => $callback ) { // Cicla tutte le Chiavi di GET oppure di POST
            // $route = post/:id
            // $callback = App\Controllers\HomeController@home, App\Controllers\PostController@getPosts, App\Controllers\PostController@create,
            // $callback è il valore di $route    
            // Se $method è uguale a 'GET'  $route può essere le seguenti chiavi: "", posts, post/create, post/:id, post/:postid/edit
            // Se $method è uguale a 'POST' $route può essere le seguenti chiavi: post/save, post/:id/store, post/:id/delete, post/:id/comment

           
            // tutte chiavi dell' array che combaciano con le uri che passano valori dinamici (es. la chiave #post/:id corrisponde alle uri post/1, post/2, post/3, etc)
            // sono segnate con il primo carattere '#' (placeholder) 
            // queste chiavi fanno un controllo aggiuntivo per estrapolare il valore dinamico dall' uri 
            // (es. da post/2 verrà estrapolato il valore 2 che verrà passato come argomento al metodo che lo richiederà)
          
            if ( substr($route, 0, 1) == '#' ) { // controlla se il primo carattere è uguale a '#'
            
                $route = substr( $route, 1 ); // rimuove il carattere '#'
           
                // La funzione preg_quote fa l' escape ai caratteri come ':' in questo modo '\:'
                // I caratteri speciali per le espressioni regolari sono . + * ? [ ^ ] $ ( ) { } = ! < > | :
                // Es. la stringa 'post/:id' diventa 'post/\:id'
                // test preg_quote: https://paiza.io/projects/0xAhUJ5nlnp7fI8U4hDDYQ
                $route = preg_quote($route); 
            
                
                /* PREPARAZIONE DELLA CHIAVE DELL' ARRAY PER CONFRONTARLA CON LA URI */
                // ARGOMENTO 1 = Pattern di ricerca --------------> '/\\\:[a-zA-Z0-9\_\-]+/' 
                // (es. cerca nella stringa della chiave il carattere ':' seguito da minimo un carattere compreso tra 'a' a 'z', tra 'A' a 'Z', tra '0' a '9' e i caratteri '_' e '-'   )

                // ARGOMENTO 2 = una parte di stringa verrà sostituita con il secondo argomento -> '([a-zA-Z0-9\-\_]+)'
                // ARGOMENTO 3 = Chiave da modificare da -----------> es 'post/\:id', comment/\:id
            
                // La corrispondenza '\:id' in 'post/\:id' viene sostituita da '([a-zA-Z0-9\-\_]+) quindi diventa 'post/([a-zA-Z0-9\-\_]+)
                // se una parte della stringa nella varibile $route è riconosciuta dal primo argomento verrà sostituita dal secondo argomento
                // Es. Il primo argomento '/\\\:[a-zA-Z0-9\_\-]+/' , in $route = ''post/\:id', trova corrispondenza in '\:id'
                //       preg_replace( pattern di ricerca     ,  con cosa sostituire,  dove cercare )
                //       preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', 'post/\:id' );  diventa  'post/([a-zA-Z0-9\-\_]+)'
                $route = preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', $route); // $route = 'post/([a-zA-Z0-9\-\_]+)' 
            }

            // PREPARIAMO LA VARIABILE '$pattern' PER ESSERE CONFRONTATA CON LA VARIABILE $uri 
            // la stringa 'post/([a-zA-Z0-9\-\_]+)' non può avere come delimitatori il carattere '/' perchè lo stesso carattere è all'interno della stringa 
            // Quindi avvolgiamo la stringa 'post/([a-zA-Z0-9\-\_]+)' con un altro carattere non alfanumerico. es. il carattere '@'
            $route = "@^". $route. "$@"; // = @^post/([a-zA-Z0-9\_\-]+)$@
            
            
          
            // CONFRONTIAMO LA CHIAVE CON LA URI DELL'URL
            // argomento 1 = $pattern = Pattern di ricerca ---> '@^post/([a-zA-Z0-9\_\-]+)$@D'
            // argomento 2 = $uri     = La stringa dell' url -> 'post/2'
            // argomento 3 = $matches = Array di ritorno -----> [0 => 'post/2',   1 => '2']
            $matches = [];
          
            if (preg_match($route, $uri, $matches)) {  
               
       
                // rimuove il primo elemento dell'array {'post/2'} perchè non è utilizzabile per passarlo come parametro del metodo
                // ci teniamo il secondo elemento dell'array {'2'} per passarlo come parametro del metodo della classe che chiameremo
                // se il path è 'posts' allora $matches[0] = 'posts' e $matches[1] = null 
                // si può passare un argomento null anche se il metodo non vuole nessun argomento
                array_shift($matches); // elimina $matches[0] = 'post/2' e quindi rimane solo $matches[1] = '2'
                return $this->callMethod($callback, $matches); 
            }
        }

        // Se non è stata trovata nessuna chiave che corrisponde alla rotta da noi richiesta allora verremo indirizzati in una pagina di errore 404
        $callback = 'app\controller\Controller@error'; 
        return $this->callMethod($callback); 
    }





    protected function callMethod($callback, array $matches=[])
    {
        try {

            if ( is_callable($callback) ) { //se trova la funzione
            //  die('Errore in classe '.__CLASS__.' metodo '.__METHOD__);
              // al momento non si attiva mai perchè non esitono funzioni tipo come App\Controllers\PostController@getPosts'
              // dobbiamo spezzare dove sta il simbolo '@' per ricavarne il metodo     
                return call_user_func_array($callback, $matches);
            }


            // es. spezziamo dove c'è il carattere '@' la stringa 'folder\subfolder\Class@Method'
            // otteniamo un array che contiene due valori:
            // all' indice '0' c'è il valore 'folder\subfolder\Class' (namespace della classe che andremo a istanziare)
            // all' indice '1' c'è il valore 'Method'    (metodo della classe che andremo richiamare)                   
            $tokens = explode('@', $callback); 
           
           
          
            // CLASSE
            $controller = $tokens[0]; // assegniamo alla variabile $controller la stringa del percorso namespace della classe
            // la variabile $controller contiene una stringa del percorso namespace della classe
            // applicando il costrutto 'new' davanti a esso richiama la classe a cui la stringa fa riferimento
            $class = new $controller(); // creiamo un istanza della classe       
         
            // METODO DELLA CLASSE
            $method = $tokens[1]; // assegniamo a $method il metodo della classe


            // La funzione 'method_exists' controlla se i due argomenti che vengono passati siano il primo una classe e il secondo il metodo della classe del primo argomento
            // $controller(come argomento accetta una stringa del nome di una classe, oppure un' istanza di una classe)
            // $method(come argomento accetta una stringa del nome di un metodo della classe) e il suo 'metodo' sono richiamabili
            if(method_exists($class, $method)){ // Se il metodo trovato esiste
              
                call_user_func_array([$class, $method], $matches); //es. ([PostController, delete], 8)
           
                return $class;
            } else {
                throw new Exception('Il metodo '.$method.' non esiste nella classe '.$controller);
        }

        } catch (Exception $e){
            die($e->getMessage());
        }
    }
    
}  // chiude classe Router