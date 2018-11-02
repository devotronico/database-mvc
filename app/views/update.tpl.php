
<main>
<form action="/store/<?=$user->id?>" method="POST">
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"><label for="name">Name</label></th>
      <th scope="col"><label for="gender">Gender</label></th>
      <th scope="col"><label for="country">Country</label></th>
      <th scope="col"><label for="birth">Birth</label></th>
      <th scope="col"><label for="reg_date">Reg_date</label></th>
      <th scope="col">Update</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row"><?=$user->id?></th>
      <td><input type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?=$user->name?>" placeholder="<?=$user->name?>"></td>
      <td><select class="custom-select" id="gender" name="gender">
          <option selected><?=$user->gender?></option>
          <option value="male">Male</option>
          <option value="female">Female</option>
        </select></td>
      <td><input type="text" class="form-control" id="country" name="country" value="<?=$user->country?>" placeholder="<?=$user->country?>"></td>
      <td><input type="date" class="form-control" id="birth" name="birth" value="<?=$user->birth?>"></td>
      <td><input type="datetime-local" class="form-control" id="reg_date" name="reg_date" value="<?=$user->reg_date?>"></td>
      <td><button type="submit" class="btn btn-primary">Submit</button></td>
    </tr>
  </tbody>
</table>
</form>
</main>




 


  
     
     
       
       
    
    
      
    
      
       
     
      
      
       
     
     
    