<main>

  <div class="row my-5">
    <div class="col-md-4">
     <!-- IMMAGINE -->
        <div class='profile__img__box'>
        <?php if ( $user->img !== "/image/avatar/avatar-default.png") : ?>
          <a class="btn btn-danger form-btn btn-canc-img" href="/delete/image/<?=$user->id?>">&#128473;</a>
        <?php endif ;?>
          <img class='profile__img' src="<?=$user->img?>" alt="avatar personale">
        </div>
        <div class='profile__buttons text-center'>
          <a class="btn btn-success my-2 form-btn" href="/read/<?=$user->id?>">&#128472;read</a>
          <a class="btn btn-danger my-2 form-btn" href="/delete/<?=$user->id?>">&#128473;delete</a>
      </div>
          <!-- END IMMAGINE -->
      </div>




    <div class="col-md-8">
      <form action="/edit/<?=$user->id?>" method="POST" enctype="multipart/form-data">

        <!-- FILE IMMAGINE -->
      <div class="custom-file mb-5">
        <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
        <input type="file" class="custom-file-input" id="image" name="file">
        <label class="custom-file-label" for="image">image file...</label>
        <small class="form-create__info">il file deve essere minore di 0.5 megabytes</small>
        <div class="preview"></div>
      </div>
        <!-- END FILE IMMAGINE -->

    <div class="form-row">
      <div class="form-group col-md-4">
        <!--  NAME -->
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" name="name" aria-describedby="name" value="<?=$user->name?>" maxlength="32">
        </div>
        <!-- END NAME -->
      </div>
      <div class="form-group col-md-4">
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
      </div>
      <div class="form-group col-md-4">
        <!--  BIRTH -->
        <div class="form-group">
          <label for="birth">Birth</label>    
          <input type="date" class="form-control" id="birth" name="birth" value="<?=$user->birth?>" aria-describedby="birth">
        </div>
        <!-- END BIRTH -->
      </div>
    </div>


    <div class="form-row">
      <div class="form-group col-md-4">
        <!--  FISCALCODE -->
        <div class="form-group">
          <label for="fiscalcode">Fiscalcode</label>
          <input type="text" class="form-control" id="fiscalcode" name="fiscalcode" aria-describedby="fiscalcode" value="<?=$user->fiscalcode?>" maxlength="16">
        </div>
        <!-- END FISCALCODE -->
      </div>
        <div class="form-group col-md-4">
        <!-- TELEPHONE -->
        <div class="form-group">
          <label for="tel">Telephone</label>
          <input type="tel" class="form-control" id="tel" name="tel" aria-describedby="tel" value="<?=$user->tel?>" maxlength="16">
        </div>
        <!-- END TELEPHONE -->
        </div>
        <div class="form-group col-md-4">
        <!--  EMAIL -->
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" aria-describedby="email" value="<?=$user->email?>" maxlength="32">
        </div>
        <!-- END EMAIL -->
      </div>
    </div>


    <div class="form-row">
      <div class="form-group col-md-3">
        <!--  STREET -->
        <div class="form-group">
          <label for="street">Street</label>
          <input type="text" class="form-control" id="street" name="street" aria-describedby="street" value="<?=$user->street?>" maxlength="32">
        </div>
        <!-- END STREET -->
      </div>
      <div class="form-group col-md-3">
        <!--  CAP -->
        <div class="form-group">
          <label for="cap">cap</label>
          <input type="text" class="form-control" id="cap" name="cap" aria-describedby="cap" value="<?=$user->cap?>" maxlength="10">
        </div>
        <!-- END CAP -->
      </div>
      <div class="form-group col-md-3">
        <!--  CITY -->
        <div class="form-group">
          <label for="city">City</label>
          <input type="text" class="form-control" id="city" name="city" aria-describedby="city" value="<?=$user->city?>" maxlength="32">
        </div>
        <!-- END CITY -->
      </div>
      <div class="form-group col-md-3">
        <!--  COUNTRY -->
        <div class="form-group">
          <label for="country">Country</label>
          <input type="text" class="form-control" id="country" name="country" aria-describedby="country" value="<?=$user->country?>" maxlength="32">
        </div>
        <!-- END COUNTRY -->
      </div>
    </div>


    <div class="form-row">
      <div class="form-group col-md-6">
        <!--  COLOR 1 -->
        <div class="form-group">
          <label for="color1">Color 1</label>
          <input type="color" class="form-control" id="color1" name="color1" value="<?=$user->color1?>" aria-describedby="color1" placeholder="Enter color 1" maxlength="32">
        </div>
        <!-- END COLOR 1 -->
      </div>
      <div class="form-group col-md-6">
        <!--  COLOR 2-->
        <div class="form-group">
          <label for="color2">Color 2</label>
          <input type="color" class="form-control" id="color2" name="color2" value="<?=$user->color2?>" aria-describedby="color2" placeholder="Enter color 2" maxlength="32">
        </div>
        <!-- END COLOR 2 -->
      </div>
    </div>

        <!-- LEVEL -->
        <label for="level">Level</label>
        <input type="range" class="custom-range" min="0" max="100" id="level" name="level" value="<?=$user->level?>">
        <p id="level-result"></p>
        <!-- END LEVEL -->

        <!-- LOOK [ RADIO ]-->
        <div class="form-check">
          <input class="form-check-input" type="radio" name="look" id="child" value="child" <?=$user->look=='child'? 'checked' : '' ?>>
          <label class="form-check-label" for="child">Child</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="look" id="adult" value="adult" <?=$user->look=='adult'? 'checked' : '' ?>>
          <label class="form-check-label" for="adult">Adult</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="look" id="old" value="old" <?=$user->look=='old'? 'checked' : '' ?>>
          <label class="form-check-label" for="old">Old</label>
        </div>
        <!-- END LOOK -->

    <div class="form-row">
      <div class="form-group col-md-4">
        <!--  SET DATA -->
        <div class="form-group">
          <label for="set_date">Setting date</label>
          <input type="datetime-local" class="form-control" id="set_date" name="set_date" value="<?= date('Y-m-d\TH:i', strtotime($user->set_date)) ?>" aria-describedby="set_date">
          <!-- <input type="datetime-local" class="form-control" id="set_date" name="set_date" value="<?php echo date('Y-m-d\TH:i', strtotime($user->set_date)); ?>" aria-describedby="set_date"> -->
        </div>
        <!-- END SET DATA -->
      </div>
      <div class="form-group col-md-4">
        <!--  UPDATE DATA -->
        <!-- <div class="form-group">
          <label for="upd_date">Update date</label>
          <input type="datetime-local" class="form-control" id="upd_date" name="upd_date" value="<?=$user->upd_date?>" aria-describedby="upd_date" readonly>
        </div> -->
        <!-- END UPDATE DATA -->
      </div>
      <div class="form-group col-md-4">
        <!--  REGISTRATION DATA -->
        <!-- <div class="form-group">
          <label for="reg_date">Registration date</label>
          <input type="datetime-local" class="form-control" id="reg_date" name="reg_date" value="<?=$user->reg_date?>" aria-describedby="reg_date" readonly>
        </div> -->
        <!-- END REGISTRATION DATA -->
      </div>
    </div>
    
        <!-- INFO -->
        <div class="form-group">
          <label for="info">Information</label>
          <textarea class="form-control" id="info" name="info" placeholder="<?=$user->info?>" rows="3"></textarea>
        </div>
        <!-- END INFO -->

        <!-- COOKIE -->
        <div class="form-check">
          <?php if ( $user->cookie === 'SI' ) : ?>
          <input class="form-check-input" type="checkbox" name="cookie" value="SI" id="cookie" checked> 
          <?php else : ?>
          <input class="form-check-input" type="checkbox" name="cookie" value="SI" id="cookie"> 
          <?php endif ; ?>
          <label class="form-check-label" for="cookie">Accetti Cookie?</label>
        </div>
        <!-- END COOKIE -->

        <button type="submit" class="btn btn-primary">Submit</button>
        <input type="reset" class="btn btn-danger">


      </form>
    </div>
  </div>

</main>







 


  
     
     
       
       
    
    
      
    
      
       
     
      
      
       
     
     
    