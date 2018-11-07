
<main>
  <div class="row">
    <div class="col-4">
      <div class='profile__img__box text-center'>
        <img class='profile__img' src="<?=$user->img?>" alt="avatar personale">
      </div>
      <div class='profile__buttons mt-5'>
        <a class="btn btn-warning form-btn" href="/update/<?=$user->id?>">&#128472;update</a>
        <a class="btn btn-danger form-btn" href="/delete/<?=$user->id?>">&#128473;delete</a>
      </div>
    </div>
    <div class="col-8">
      <table class="table table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">Proprietà</th>
            <th scope="col">Valore</th>
          </tr>
        </thead>
        <tbody>
      <tr>
        <th scope="row">id</th>
        <td scope="row"><?=$user->id?></td>
      </tr>
      <tr>
        <th scope="row">name</th>
        <td><?=$user->name?></td>
      </tr>
      <tr>
        <th scope="row">gender</th>
        <td><?=$user->gender?></td>
      </tr>
      <tr>
        <th scope="row">email</th>
        <td><?=$user->email?></td>
      </tr>
      <tr>
        <th scope="row">country</th>
        <td><?=$user->country?></td>
      </tr>
      <tr>
        <th scope="row">birth</th>
        <td><?=$user->birth?></td>
      </tr>
      <tr>
        <th scope="row">set_date</th>
        <td><?=$user->set_date?></td>
      </tr>
      <tr>
        <th scope="row">reg_date</th>
        <td><?=$user->reg_date?></td>
      </tr>
      </tbody>
      </table>
    </div>
  </div>
</main>

