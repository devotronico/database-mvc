<form action="search" method="POST">

<div class="form-row mt-3 justify-content-center align-items-center">
  <!-- SELECT -->
    <div class="col-auto my-1">
      <label class="mr-sm-2" for="where">Select</label>
      <select class="custom-select mr-sm-2" id="where" name="where">
        <option value="<?=isset($data['where'])?$data['where']:'name'?>"><?=isset($data['where'])?$data['where']:'name'?></option>
        <option value="name">name</option>
        <option value="birth">birth</option>
        <option value="country">country</option>
      </select>
    </div>
  <!-- END SELECT -->

  <!-- LIKE -->
      <div class="col-auto my-1">
        <label class=" for="keyword">Like</label>
        <input type="text" class="form-control mr-sm-2" id="keyword" name="keyword" value="<?=isset($data['keyword'])?$data['keyword']:''?>" placeholder="keyword">
    </div>
  <!-- END LIKE -->

    <!-- TIME -->
    <div class="col-auto my-1">
      <label class="mr-sm-2" for="time">Last</label>
      <select class="custom-select mr-sm-2" id="time" name="time">
        <option value="<?=isset($data['time'])?$data['time']:'ever'?>"><?=isset($data['time'])?$data['time']:'ever'?></option>
        <option value="day">day</option>
        <option value="week">week</option>
        <option value="month">month</option>
        <option value="year">year</option>
        <option value="ever">ever</option>
      </select>
    </div>
  <!-- END TIME -->

  <!-- ORDER BY -->
  <div class="col-auto my-1">
      <label class="mr-sm-2" for="orderby">Order By</label>
      <select class="custom-select mr-sm-2" id="orderby" name="orderby">
      <option value="<?=isset($data['orderby'])?$data['orderby']:'name'?>"><?=isset($data['orderby'])?$data['orderby']:'name'?></option>
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
      <label class="mr-sm-2" for="dir">Direction</label>
      <select class="custom-select mr-sm-2" id="dir" name="dir">
      <?php if ( isset($data['dir']) ) :?>
        <?php if ( $data['dir']==="ASC" ) :?>
          <option value="ASC">ASC</option>
          <option value="DESC">DESC</option>
        <?php elseif ( $data['dir']==="DESC" ) :?>
          <option value="DESC">DESC</option>
          <option value="ASC">ASC</option>
        <?php endif;?>
      <?php else :?>
        <option value="ASC">ASC</option>
        <option value="DESC">DESC</option>
      <?php endif;?>
      </select>
    </div>
  <!-- END ASC-DESC -->


      <div class="col-auto my-1">
        <div class="custom-control custom-checkbox mr-sm-2">
          <input type="checkbox" class="custom-control-input" id="save" name="save">
          <label class="custom-control-label" for="save">save</label>
        </div>
      </div>
      <div class="col-auto my-1">
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
  </div>
</form>