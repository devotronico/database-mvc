<h3 class="text-center my-5"><?=isset($_GET['message'])? $_GET['message'] : 'Home'?></h3>
<div class="row mb-2 justify-content-center">
  <div class="col-auto ">
    <a class="btn btn-primary form-btn" href="/load">Carica Utenti <i class="fas fa-download"></i></a>
  </div>
  <div class="col-auto">
    <a class="btn btn-danger form-btn" href="/reset">Cancella tutto <i class="far fa-trash-alt"></i></a>
  </div>
  <div class="col-auto">
    <a class="btn btn-success form-btn" href="/create">Aggiungi Utente <i class="fas fa-plus"></i></a>
  </div>
</div>



