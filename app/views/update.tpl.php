<main>

  <div class="row">
    <div class="col-md-4">
        <div class='profile__img__box text-center'>
          <img class='profile__img' src="<?=$user->img?>" alt="avatar personale">
        </div>
          <a class="btn btn-danger form-btn btn-canc-img" href="/delete/image/<?=$user->id?>">&#128473;</a>
          <p id="status">Status</p>
      </div>
    <div class="col-md-8">
      <form action="/edit/<?=$user->id?>" method="POST" enctype="multipart/form-data">

        <!-- IMMAGINE -->
        <div class="form-group">
            <label for="image">Immagine</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
            <input type="file" class="form-control-file" name="file" id="image" size="500000" accept="jpg jpeg"> 
            <small class="form-create__info">il file deve essere minore di 0.5 megabytes</small>
            <div class="preview"></div>
        </div>
        <!-- END IMMAGINE -->

        <!--  NAME -->
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" name="name" aria-describedby="name" value="<?=$user->name?>" maxlength="32">
        </div>
        <!-- END NAME -->

        <!--  GENDER -->
        <div class="form-group">
        <label for="gender">Gender</label>
          <select class="custom-select" id="gender" name="gender">
            <option selected value="<?=$user->gender?>"><?=$user->gender?></option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
        <!-- END GENDER -->

        <!--  EMAIL -->
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" aria-describedby="email" value="<?=$user->email?>" maxlength="32">
        </div>
        <!-- END EMAIL -->

        <!--  COUNTRY -->
        <div class="form-group">
          <label for="country">Country</label>
          <input type="text" class="form-control" id="country" name="country" aria-describedby="country" value="<?=$user->country?>" maxlength="32">
        </div>
        <!-- END COUNTRY -->

        <!--  BIRTH -->
        <div class="form-group">
          <label for="birth">Birth</label>    
          <input type="date" class="form-control" id="birth" name="birth" value="<?=$user->birth?>" aria-describedby="birth">
        </div>
        <!-- END BIRTH -->

        <!--  SET DATA -->
        <div class="form-group">
          <label for="set_date">Set date</label>
          <input type="datetime-local" class="form-control" id="set_date" name="set_date" value="<?=$user->set_date?>" aria-describedby="set_date">
        </div>
        <!-- END SET DATA -->

        <!--  REGISTRATION DATA -->
        <div class="form-group">
          <label for="reg_date">Reg date</label>
          <input type="datetime-local" class="form-control" id="reg_date" name="reg_date" value="<?=$user->reg_date?>" aria-describedby="reg_date" readonly>
        </div>
        <!-- END REGISTRATION DATA -->

        <button type="submit" class="btn btn-primary">Submit</button>
        <input type="reset" class="btn btn-danger">
        <!-- <button type="resett" class="btn btn-danger">Reset</button> -->

      </form>
    </div>
  </div>

</main>







 


  
     
     
       
       
    
    
      
    
      
       
     
      
      
       
     
     
    