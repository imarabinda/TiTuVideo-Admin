

    <div class="row">
    <div class="col-md-12">
                <h4>Settings</h4>
                <div class="card">
                  <div class="card-body">
                  <?php
                  foreach($settings as $row_value){
                      if($row_value['settings_id'] == 'video_reward_limit'){
                    ?>

                    <div class="section-title">Per day video upload reward limit</div>
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" data-for="<?php echo $row_value['settings_id'];?>" placeholder="Enter video upload reward limit" aria-label="" value="<?php echo $row_value['settings_value'];?>">
                        <div class="input-group-append">
                          <button class="btn btn-primary save_settings" type="button">Change</button>
                        </div>
                      </div>
                    </div>

                    <?php
                        }
                    }
                    ?>
                  </div>
                </div>


</div>
</div>

<script>
    $('.save_settings').each(function(){
        $(this).click(function(){
            var input = $(this).parent().prev('input');
            var for_ = $(input).attr('data-for');
            var value  =$(input).val();
             $.ajax({
                    url: base_url + "admin/Settings/manage_change",
                    data: { for: for_, value: value },
                    type: "POST",
                    success: function (data) {
                        if(data){
                            swal("Settings updated.", "success");    
                        }else{
                            swal("Settings change failed.", "error");
                                
                        }
                        }
            });
        });
    });
</script>