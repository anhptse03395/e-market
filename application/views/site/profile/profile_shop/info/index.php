	
<link href="<?php echo public_url('user')?>/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo public_url('user')?>/css/profile.css" rel="stylesheet">

<div class="form_main col-md-4 col-sm-5 col-xs-7">
    <h4 class="heading" style="color: green"><strong style="color: blue">Thông tin </strong> cá nhân <span></span></h4>
    <div class="form">
    
    <?php  $message = $this->session->userdata('expire');
    ?>
    <?php if(isset($message) && $message):?>
      <div class="alert alert-info">
        <h3 style="text-align: center;"><strong> </strong><?php echo $message?></h3>
         <h3 class="text-center"><a href="<?php echo user_url('contact') ?>" > Vui lòng nạp tiền theo hướng dẫn ở đây</a></h3>
        


    </div>
<?php endif;?>

<?php  $message1 = $this->session->flashdata('message');
    ?>
    <?php if(isset($message1) && $message1):?>
      <div class="alert alert-info">
        <h3 style="text-align: center;"><strong> </strong><?php echo $message1?></h3>
      </div>
    <?php endif;?>

       <table class="table table-user-information"  style="width: 40%;">
        <tbody>
            <tr>
                <td >Tên của bạn:</td>
                <td><?php echo $info->shop_name ?></td>
            </tr>
            
            <tr>
                <td>Địa chỉ</td>
                <td><?php echo $info->address ?></td>
            </tr>
            <tr>
                <td>Số điện thoại</td>
                <td><?php echo '0'. $info->phone ?></td>    
            </tr>

        </tbody>
    </table>
    <h4>Đổi mật khẩu </h4> 
    <form action="" method="post">

        <input  placeholder=" Mật khẩu cũ" type="password" name="old_password">
        <div class="clear error" name="name_error"><?php echo form_error('old_password')?></div>
        <br>
        <input placeholder="Mật khẩu mới" type="password" name="new_password">
        <div class="clear error" name="name_error"><?php echo form_error('new_password')?></div>
        <br>
        
        <input placeholder="Nhap lai mật khẩu" type="password" name="repassword">
        <div class="clear error" name="name_error"><?php echo form_error('repassword')?></div>
        <br>

        <br>
        <button type="submit"  class="btn btn-primary">Xác nhận</button>
    </form>



</div>
</div>

