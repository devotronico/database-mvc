
<main>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Gender</th>
      <th scope="col">Country</th>
      <th scope="col">Birth</th>
      <th scope="col">Reg_date</th>
    </tr>
  </thead>
  <tbody>
 
    <tr>
    <?php if (is_array($user)) :?>
      <th scope="row"><?=$user['id']?></th>
      <td><?=$user['name']?></td>
      <td><?=$user['gender']?></td>
      <td><?=$user['country']?></td>
      <td><?=$user['birth']?></td>
      <td><?=$user['reg_date']?></td>
      <?php elseif (is_object($user)) :?>
      <th scope="row"><?=$user->id?></th>
      <td><?=$user->name?></td>
      <td><?=$user->gender?></td>
      <td><?=$user->country?></td>
      <td><?=$user->birth?></td>
      <td><?=$user->reg_date?></td>
      <?php endif ;?>
    </tr>
   
  </tbody>
</table>
</main>

