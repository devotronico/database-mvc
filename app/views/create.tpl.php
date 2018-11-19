
<main>
<form action="/store" method="POST" enctype="multipart/form-data">

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
    <input type="text" class="form-control" id="name" name="name" aria-describedby="name" placeholder="Enter Nome" maxlength="32">
  </div>
<!-- END NAME -->

<!--  GENDER -->
<div class="form-group">
  <label for="gender">Gender</label>
    <select class="custom-select" id="gender" name="gender">
      <option selected value="">Gender</option>
      <!-- <option selected value="<?=false?>">Gender</option> -->
      <option value="male">Male</option>
      <option value="female">Female</option>
    </select>
</div>
<!-- END GENDER -->

<!--  BIRTH -->
<div class="form-group">
  <label for="birth">Birth</label>    
  <input type="date" class="form-control" id="birth" name="birth" aria-describedby="birth">
</div>
<!-- END BIRTH -->

<!--  FISCALCODE -->
<div class="form-group">
  <label for="fiscalcode">Fiscalcode</label>    
  <input type="text" class="form-control" id="fiscalcode" name="fiscalcode" aria-describedby="fiscalcode" maxlength="16">
</div>
<!-- END FISCALCODE -->

<!--  TELEPHONE -->
<div class="form-group">
  <label for="tel">Telephone</label>    
  <input type="tel" class="form-control" id="tel" name="tel" aria-describedby="tel" maxlength="15">
</div>
<!-- END TELEPHONE -->

<!--  EMAIL -->
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="email" placeholder="Enter email" maxlength="32">
  </div>
<!-- END EMAIL -->

<!-- STREET -->
<div class="form-group">
  <label for="street">Street</label>
  <input type="text" class="form-control" id="street" name="street" aria-describedby="street" placeholder="Enter street" maxlength="32">
</div>
<!-- END STREET -->

<!--  CAP -->
<div class="form-group">
  <label for="cap">Cap</label>
  <input type="text" class="form-control" id="cap" name="cap" aria-describedby="cap" placeholder="Enter cap" maxlength="32">
</div>
<!-- END CAP -->

<!-- CITY -->
<div class="form-group">
  <label for="city">City</label>
  <input type="text" class="form-control" id="city" name="city" aria-describedby="city" placeholder="Enter city" maxlength="32">
</div>
<!-- END CITY -->

<!--  COUNTRY -->
<div class="form-group">
  <label for="country">Country</label>
  <input type="text" class="form-control" id="country" name="country" aria-describedby="country" placeholder="Enter country" maxlength="32">
</div>
<!-- END COUNTRY -->

<!--  COLOR 1 -->
<div class="form-group">
  <label for="color1">Color 1</label>
  <input type="color" class="form-control" id="color1" name="color1" aria-describedby="color1" placeholder="Enter color 1" maxlength="7">
</div>
<!-- END COLOR 1 -->

<!--  COLOR 2-->
<div class="form-group">
  <label for="color2">Color 2</label>
  <input type="color" class="form-control" id="color2" name="color2" aria-describedby="color2" placeholder="Enter color 2" maxlength="7">
</div>
<!-- END COLOR 2 -->

<!-- LEVEL -->
<label for="level">Level</label>
<input type="range" class="custom-range" min="0" max="100" id="level" name="level">
<p id="level-result"></p>
<!-- END LEVEL -->

<!-- LOOK [ RADIO ]-->
<div class="form-check">
  <input class="form-check-input" type="radio" name="look" id="child" value="child" checked>
  <label class="form-check-label" for="child">Child</label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="look" id="adult" value="adult">
  <label class="form-check-label" for="adult">Adult</label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="look" id="old" value="old">
  <label class="form-check-label" for="old">Old</label>
</div>
<!-- END LOOK -->

<!--  SETTING DATA -->
<div class="form-group">
  <label for="set_date">Set date</label>
  <input type="datetime-local" class="form-control" id="set_date" name="set_date" aria-describedby="set_date">
</div>
<!-- END SETTING DATA -->
  
<!-- INFO -->
<div class="form-group">
  <label for="info">Information</label>
  <textarea class="form-control" id="info" name="info" rows="3"></textarea>
</div>
<!-- END INFO -->

<!-- COOKIE -->
<div class="form-check">
  <input class="form-check-input" type="checkbox" name="cookie" value="SI" id="cookie">
  <label class="form-check-label" for="cookie">Accetti Cookie?</label>
</div>
<!-- END COOKIE -->

<button type="submit" class="btn btn-primary">Submit</button>
<input type="reset" class="btn btn-danger">

</form>
</main>






 


  
     
     
       
       
    
    
      
    
      
       
     
      
      
       
     
     
    