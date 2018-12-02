


function inputFileImage(input) {


    const preview = document.querySelector('.preview'); // seleziona un contenitore vuoto     

  // Se trova elementi figli.
  // Del contenitore '.preview' elimina tutti gli elementi figli creati precedentemente.
  // Elimina la lista che contiene l'immagine e la descrizione del peso dell'immagine.
  // Vengono eliminati gli elementi:  ul > li > img , li > small
  while(preview.firstChild) { 

    preview.removeChild(preview.firstChild);
  }


  // curFiles è un oggetto 
  /*
  input.files è un oggetto con informazioni sul file come: size, name, type
   console.log(input.files);

  FileList
0: File(53051)
    lastModified: 1535095225579
    lastModifiedDate: Fri Aug 24 2018 09:20:25 GMT+0200 (Ora legale dell’Europa centrale) {}
    name: "grizzly_bear-8210.jpg"
    size: 53051
    type: "image/jpeg"
    length: 1

*/
const curFiles = input.files; 
 
  console.log(input.files[0].size);

  const list = document.createElement('ul');
    list.style.listStyleType = 'none';
    list.style.padding = '0';

    preview.appendChild(list); 

  const itemImage = document.createElement('li'); // contenitore  dell' immagine
  const itemSize = document.createElement('li');  // contenitore dell' informazioni sul peso del file
  const info = document.createElement('small');   // elemento dell' informazioni sul peso del file


      
    // Se il tipo di file caricato è valido...
    if ( validFileType(curFiles[0]) ) { 
      
      // assegniamo il valore del peso in megabytes e arrotondato a un elemento
      info.textContent = returnFileSize(curFiles[0].size); 

      // Crea il tag <img>
      const image = document.createElement('img');
      image.src = window.URL.createObjectURL(curFiles[0]);
      image.width = 280;

      itemImage.appendChild(image);
      itemSize.appendChild(info);

    } else {
      info.textContent = 'File name ' + curFiles[0].name + ': Il tipo di file non è valido.';
      itemSize.appendChild(info);
    }

    list.appendChild(itemImage);
    list.appendChild(itemSize);



}





//FUNZIONI DI SUPPORTO---------------------------------------

// CONTROLLO SUI TIPI DI FILE SUPPORTATI
const fileTypes = [
  'image/jpeg',
  'image/pjpeg',
  'image/png'
]

function validFileType(file) {
  for(let i = 0; i < fileTypes.length; i++) {
    if(file.type === fileTypes[i]) {
      return true;
    }
  }
  return false;
}



// ARROTONDAMENTO DELLE DIMENSIONI DEL FILE Per una migliore leggibilità del valore del peso del file.
// curFiles[0].size restituisce il valore del peso del file in Bytes(B)
// se un file pesa:  70000 Bytes(B) verrà convertito in 0.07000000000000000 Megabytes(MB)  
// 70000 Bytes(B) = 0.07000000000000000 Megabytes(MB)  
// per tenerci fino ai centesimi di Megabytes(MB) : cioè vogliamo ottenere 0.07 tagliando tutti i numeri che vengono dopo i centesimi
// eseguiamo la seguente espressione:  parseFloat(0.07000000000000000 * 0.000001).toFixed(2) 
// che restituirà:  0.07
//console.log(  parseFloat(curFiles[0].size * 0.000001).toFixed(2) ); //0.07
function returnFileSize(number) {
  if(number < 500000) {

    return 'dimensioni del file '+ parseFloat(number * 0.000001).toFixed(2) + ' megabytes';
  } 
  else {
   // return (number * 0.000001) + ' megabytes Le dimensioni del file superano il limite massimo di 1megabytes';
    return 'Le dimensioni del file superano il limite massimo di 0.5 megabytes';
  }
}
// ESEMPIO di questo script sta a questo indirizzo https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file 
//CHIUDE FUNZIONI DI SUPPORTO---------------------------------------





export {inputFileImage}