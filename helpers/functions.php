<?php

function _view(string $page, $data=[]) {
  extract($data);
  ob_start(); // catturiamo tutto nel buffer
  require "app/views/".$page.".tpl.php"; // template da catturare
  // require "app/views/blog.tpl.php"; // template da catturare
  $template = ob_get_contents(); // nella variabile viene immagazzionato tutto il template catturato
  ob_end_clean(); // liberiamo la memoria | meglio disattivare altrimenti non ritorna $data
  return $template;
}


function _redirect($uri ='/', $message=''){

  $mess = !empty($message)?"?message=".urlencode($message):'';
  header("Location:".$uri.$mess);
  die(); // die è più veloce di exit
}
