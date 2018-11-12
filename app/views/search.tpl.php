<form action="search" method="POST">

<div class="form-row mt-3 justify-content-center align-items-center">
  <!-- SELECT -->
    <div class="col-auto my-1">
      <label class="mr-sm-2 sr-only" for="where">Select</label>
      <select class="custom-select mr-sm-2" id="where" name="where">
        <option value="where">Category</option>
        <option value="name">name</option>
        <option value="birth">birth</option>
        <option value="country">country</option>
      </select>
    </div>
  <!-- END SELECT -->

  <!-- LIKE -->
      <div class="col-auto my-1">
        <label class="sr-only" for="keyword">Like</label>
        <input type="text" class="form-control mr-sm-2" id="keyword" name="keyword" placeholder="keyword">
    </div>
  <!-- END LIKE -->

  <!-- ORDER BY -->
  <div class="col-auto my-1">
      <label class="mr-sm-2 sr-only" for="orderby">Order By</label>
      <select class="custom-select mr-sm-2" id="orderby" name="orderby">
        <option value="orderby">Order by</option>
        <option value="name">name</option>
        <option value="country">country</option>
        <option value="birth">birth</option>
        <option value="set_date">set_date</option>
        <option value="upd_date">upd_date</option>
        <option value="reg_date">reg_date</option>
      </select>
    </div>
  <!-- END ORDER BY -->

  <!-- ASC-DESC -->
  <div class="col-auto my-1">
      <label class="mr-sm-2 sr-only" for="direction">Direction</label>
      <select class="custom-select mr-sm-2" id="direction" name="direction">
        <option value="direction">Direction</option>
        <option value="ASC">ASC</option>
        <option value="DESC">DESC</option>
      </select>
    </div>
  <!-- END ASC-DESC -->


      <div class="col-auto my-1">
        <div class="custom-control custom-checkbox mr-sm-2">
          <input type="checkbox" class="custom-control-input" id="save" name="save">
          <label class="custom-control-label" for="save">save search</label>
        </div>
      </div>
      <div class="col-auto my-1">
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
  </div>
</form>