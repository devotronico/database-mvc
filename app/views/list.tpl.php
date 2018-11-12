<main class="mt-3">
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Gender</th>
      <th scope="col">Country</th>
      <th scope="col">Birth</th>
      <th scope="col">Set_date</th>
      <th scope="col">Upd_date</th>
      <th scope="col">Reg_date</th>
      <th scope="col">Read</th>
      <th scope="col">Update</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
      <?php foreach ($users as $user) : ?> 
      <tr>
        <th scope="row"><a href="/post/<?=$user->id?>"><?=$user->id?></a></th>
        <td><?=$user->name?></td>
        <td><?=$user->gender?></td>
        <td><?=$user->country?></td>
        <td><?=date('d-m-Y', strtotime($user->birth))?></td>
        <td><?= $user->set_date != '0000-00-00 00:00:00' ?  date('d-m-Y H:i', strtotime($user->set_date)) : $user->set_date ?></td>
        <td><?=_timeago_from_sql_datetime($user->upd_date)?></td>
        <td><?=date('d-m-Y H:i', strtotime($user->reg_date))?></td>
        <td><a class="btn btn-success form-btn" href="/read/<?=$user->id?>">&#128463;</a></td>
        <td><a class="btn btn-warning form-btn" href="/update/<?=$user->id?>">&#128472;</a></td>
        <td><a class="btn btn-danger form-btn" href="/delete/<?=$user->id?>">&#128473;</a></td>
      </tr>
      <?php endforeach; ?>
  </tbody>
</table>
</main>

