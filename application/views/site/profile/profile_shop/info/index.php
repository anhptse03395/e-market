	
<link href="<?php echo public_url('user')?>/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo public_url('user')?>/css/profile.css" rel="stylesheet">

<div class="form_main col-md-4 col-sm-5 col-xs-7">
    <h4 class="heading"><strong>Thông tin </strong> cá nhân <span></span></h4>
    <div class="form">

       <table class="table table-user-information" style="width: 100%">
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
                <td><?php echo $info->phone ?></td>    
            </tr>

        </tbody>
    </table>
    <h4>Đổi mật khẩu </h4> 
    <form action="" method="post">

        <input placeholder="Password cu" type="password" name="old_password">
        <div class="clear error" name="name_error"><?php echo form_error('old_password')?></div>
        <br>
        <input placeholder="New password" type="password" name="new_password">
        <div class="clear error" name="name_error"><?php echo form_error('new_password')?></div>
        <br>
        
        <input placeholder="Nhap lai password" type="password" name="repassword">
        <div class="clear error" name="name_error"><?php echo form_error('repassword')?></div>
        <br>

        <br>
        <button type="submit"  class="btn btn-default">Gui</button>
    </form>

</div>
</div>
