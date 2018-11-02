<?php
// php -S localhost:3000 -t database-mvc/public

// DA LOCALE
// Considerato che vogliamo che il punto di ingresso deve essere nella sottoCartella:  'nomesito\public\index.php'

// apriamo il terminale spostiamoci nella cartella superiore del nostro progetto,
// dal terminale digitiamo il comando:   cd .. 
// se siamo in locale e utilizziamo xampp, la cartella superiore è /htdocs/
// A questo punto da terminale digitiamo il comando:  php -S localhost:3000 -t nomesito/public
// Nel browser digitiamo:   http://localhost:3000

// a questo punto essendo che abbiamo spostato il punto di ingresso nella sottocartella:   'nomesito\public\index.php'
// per caricare i file che si trovano nelle altre cartelle allo stesso livello di 'nomesito\public\' 
// come per esempio la cartella 'nomesito\app\' o la cartella 'nomesito\config\'
// dobbiamo prima uscire dalla cartella portandoci a un livello superiore e poi entrare nella cartella desiderata
// per fare ciò dobbiamo anteporre ad 'app/controller/Controller.php' questa stringa '../' 
// Esempio:   require_once '../app/controller/Controller.php';  
// ma per comodità vogliamo utilizzare la sintassi:   require_once 'app/controller/Controller.php'; 
// per fare ciò utilizzeremo il comando:   chdir(dirname(__DIR__))
// Con la funzione chdir(dirname(__DIR__)) ci posiziona nella cartella superiore di 'public' 
// Es:   dirname(__DIR__) = C:\xampp\htdocs\nomesito
// In questo modo se vogliamo accedere al file 'index.tpl.php' scriviamo 'layout/index.tpl.php' invece di '../layout/index.tpl.php';


chdir(dirname(__DIR__)); 


// lista di rotte suddivise per il tipo di richieste al server ('GET', 'POST')
// a loro volta suddivise in chiavi/rotte(es. "", "/", "home", "blog", "about", "contact") 
//che attivano le classi con i rispettivi metodi(VALORI) (es. "app\controller\Controller@home")
$listOfRoutes = [
    'GET'=>[
        "" => "app\controller\ListController@page",
        "/" => "app\controller\ListController@page",
        "#page/:id" => "app\controller\ListController@page",
        "load" => "app\controller\ListController@load",
        "reset" => "app\controller\ListController@reset",
        "create" => "app\controller\ListController@create",
        "#read/:id" => "app\controller\SingleController@read",
        "#update/:id" => "app\controller\SingleController@update",
      
        "#delete/:id" => "app\controller\SingleController@delete",
        "about" => "app\controller\Controller@about",
        "contact" => "app\controller\Controller@contact",
    ],
    'POST'=>[
        "new" => "app\controller\ListController@new",
        "#store/:id" => "app\controller\SingleController@store",
    ]
];

// CLASSI
require_once 'config/db.php';   
require_once 'core/Router.php';   
require_once 'app/models/Database.php';   
require_once 'app/models/Blog.php';   
require_once 'app/models/Single.php';   
require_once 'app/controller/Controller.php';   
require_once 'app/controller/ListController.php';   
require_once 'app/controller/SingleController.php';   
require_once 'helpers/functions.php';   

// Router è la prima classe che deve essere istanziata perchè deve leggere l'url e indirizzarci verso la pagina/azione da noi richiesta
$router = new Router();

// tramite il metodo loadRoutes carichiamo la lista di rotte all' interno della classe Router
$router->loadRoutes($listOfRoutes);

// tramite il metodo dispatch verrà istanziata la classe con il rispettivo metodo e argomento se presente che corrispondono all' url di navigazione
$controller = $router->dispatch(); 

// e alla fine verrà caricato il template di default dell'intera pagina che sarà lo stesso per tutte le pagine
$controller->display();



?>




