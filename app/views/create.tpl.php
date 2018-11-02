
<main>
<form action="/new" method="POST">
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"><label for="name">Name</label></th>
      <th scope="col"><label for="gender">Gender</label></th>
      <th scope="col"><label for="country">Country</label></th>
      <th scope="col"><label for="birth">Birth</label></th>
      <!-- <th scope="col"><label for="reg_date">Reg_date</label></th> -->
      <th scope="col">Update</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">#</th>
      <td><input type="text" class="form-control" id="name" aria-describedby="name" name="name" placeholder="Nome"></td>
      <td><select class="custom-select" id="gender" name="gender">
          <option selected>Scegli</option>
          <option value="male">Male</option>
          <option value="female">Female</option>
        </select></td>
      <td><input type="text" class="form-control" id="country" name="country" placeholder="Paese"></td>
      <td><input type="date" class="form-control" id="birth" name="birth" placeholder="Data di nascita"></td>
      <!-- <td><input type="datetime-local" class="form-control" id="reg_date" name="reg_date" placeholder="Data di registrazione"></td> -->
      <td><button type="submit" class="btn btn-primary">Submit</button></td>
    </tr>
  </tbody>
</table>
</form>
</main>




 


  
     
     
       
       
    
    
      
    
      
       
     
      
      
       
     
     
    