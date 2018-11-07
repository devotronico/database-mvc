console.log('CREATE');
 /*
 * ESEMPIO di questo script sta a questo indirizzo https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file
 */   
var input = document.querySelector('#image');
var preview = document.querySelector('.preview');

//input.style.opacity = 0;
//input.style.display = 'none';
input.addEventListener('change', updateImageDisplay);

function updateImageDisplay() {

  // fintanto preview.firstChild = true 
  while(preview.firstChild) {
    preview.removeChild(preview.firstChild);
  }

  var curFiles = input.files;

    var list = document.createElement('ul');
    list.style.listStyleType = 'none';
    preview.appendChild(list); 
  //  for(var i = 0; i < curFiles.length; i++) { // verificare se si può eliminare il ciclo //console.log( curFiles.length);
      var listItem = document.createElement('li');
      var para = document.createElement('small');

      console.log(  parseFloat(curFiles[0].size * 0.000001).toFixed(2) );

      if(validFileType(curFiles[0])) {
        para.textContent = returnFileSize(curFiles[0].size);
        // para.textContent = 'File name ' + curFiles[0].name + ' - file size ' + returnFileSize(curFiles[0].size) + '.';
        var image = document.createElement('img');
        image.src = window.URL.createObjectURL(curFiles[0]);
        image.width = 280;

        listItem.appendChild(image);
        listItem.appendChild(para);

      } else {
        para.textContent = 'File name ' + curFiles[0].name + ': Il tipo di file non è valido.';
        listItem.appendChild(para);
      }

      list.appendChild(listItem);
}


// CONTROLLO SUI TIPI DI FILE SUPPORTATI
var fileTypes = [
  'image/jpeg',
  'image/pjpeg',
  'image/png'
]

function validFileType(file) {
  for(var i = 0; i < fileTypes.length; i++) {
    if(file.type === fileTypes[i]) {
      return true;
    }
  }
  return false;
}


function returnFileSize(number) {
  if(number < 500000) {

    return 'dimensioni del file '+ parseFloat(number * 0.000001).toFixed(2) + ' megabytes';
  } 
  else {
   // return (number * 0.000001) + ' megabytes Le dimensioni del file superano il limite massimo di 1megabytes';
    return 'Le dimensioni del file superano il limite massimo di 0.5 megabytes';
  }
}


