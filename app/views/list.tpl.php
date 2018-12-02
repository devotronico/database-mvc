<main class="mt-3">
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Level</th>
      <th scope="col">Country</th>
      <th scope="col">Birth</th>
      <th style="background-color:#333;" scope="col">Set_date</th>
      <th style="background-color:#333;" scope="col">days</th>
      <th scope="col">Upd_date</th>
      <th scope="col">Read</th>
      <th scope="col">Update</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
      <?php foreach ($users as $user) : ?> 
      <tr>
        <th scope="row"><a href="/read/<?=$user->id?>"><?=$user->id?></a></th>
        <td><?=$user->name?></td>
        <td><?=$user->level?></td>
        <td><?=$user->country?></td>
        <td><?=$user->birth?></td>
        <td style="background-color:#333;"><?=$user->set_date?></td>
        <td style="background-color:#333;"><?=$user->days?></td>
        <td><?= $user->upd_date ?></td>
        <td><a class="btn btn-success form-btn" href="/read/<?=$user->id?>"><i class="fas fa-eye"></i></a></td>
        <td><a class="btn btn-warning form-btn" href="/update/<?=$user->id?>"><i class="fas fa-pencil-alt"></i></a></td>
        <td><a class="btn btn-danger form-btn" href="/delete/<?=$user->id?>"><i class="far fa-trash-alt"></i></a></td>
      </tr>
      <?php endforeach; ?>
  </tbody>
</table>
</main>

