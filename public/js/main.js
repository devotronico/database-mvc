document.addEventListener('DOMContentLoaded', function() {
console.log('0');


// window.onbeforeunload
// Viene richiamato prima di uscire dalla pagina 
// se facciamo un refresh o cambiamo pagina 
window.onbeforeunload = function () { 
    //prima di caricare una nuova pagina lo scroll viene portato in cima
    window.scrollTo(0, 0);
 //return "Write something clever here...";
}




if (window.addEventListener) {
    console.log('LOAD');
window.addEventListener ("load", downloadJSAtOnload, false);
}
else if (window.attachEvent) {
    console.log('ONLOAD');
window.attachEvent ("onload", downloadJSAtOnload);
}
else { 
    console.log('ELSE');
window.onload = downloadJSAtOnload;
}




// Al ogni pagina viene caricato un file js specifico
// PATH DELL URL
console.log('window.location.pathname = ' + window.location.pathname);
const pathname = window.location.pathname;
const tokens = pathname.split('/');
const path = tokens[1]
console.log(path);



function downloadJSAtOnload () {

    let element = document.createElement("script"); // crea elemento link

    // setta il file js da caricare in base all'url
    switch (path) { 
        
        case '' : 
        case 'page' : 
        console.log('HOME');

        //element.setAttribute('type', 'module');   // element.src = " example.js" ;
        //element.setAttribute('src', '/js/home.js');   // element.src = " example.js" ;
        break;

        case 'create':
        case 'update':
            element.setAttribute('src', '/js/create.js'); 
        break;

        default : 

            //var mystr = window.location.pathname;
            //var myarr = mystr.split('/');
            //var myvar = myarr[0] + ":" + myarr[1];
            //console.log(myarr[0]);
            //console.log(myarr[1]);
            //console.log(myarr[2]);
            // element.setAttribute('src', '/js/desktop/blog.js');   
    }

    document.body.appendChild (element); // appendiamo il nuovo file js al body 
}






}); // chiude DOMContentLoaded
     








