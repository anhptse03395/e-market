
<script src="<?php echo public_url('user/home') ?>/js/main.js"></script>
<script type="text/javascript" src="<?php echo public_url('user/home') ?>/js/moment-2.4.0.js"></script>
<script src="<?php echo public_url('user/home') ?>/js/bootstrap-datetimepicker.min.js"></script>
<link href="<?php echo public_url('user/home')?>/css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="<?php echo public_url('user/home') ?>/js/bootstrap.min.js"></script>


<script type="text/javascript">
  $(function() {              
           // Bootstrap DateTimePicker v4
           $('#datePicker').datetimepicker({
             format: 'DD/MM/YYYY',


           });
           $('#datePicker1').datetimepicker({
             format: 'DD/MM/YYYY',


           });

         });      
       </script>


       <div class="col-md-9" id="customer-orders" style="width: 100%">
        <div class="box">
          <h3>Đơn hàng của tôi</h3>

          <form id="eventForm" action="<?php echo user_url('profile/search_order_buyer') ?>" method="post" class="form-horizontal">

            <div class="form-group" style="width: 40%;float: left; margin-right: 10%" >
              <label class="col-xs-3 control-label">Mã đơn hàng </label>
              <div class="input-group"> 
                <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span>
              </span>
              <input  type="text" class="form-control" value="<?php echo set_value('order_id') ?>"  name="order_id"  />
            </div>
          </div>

          <div class="form-group" style="width: 40%;float: left;">
           <label class="col-xs-3 control-label">Trạng thái </label>
           <div class="input-group"> 
            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span>
          </span>
          <select onchange="this.form.submit();" name="status" class="form-control">
           <option value="">Tất cả</option>
           <option value="1" <?php echo ($this->input->post('status') == 1) ? 'selected' : ''?> >Đơn hàng mới</option>
           <option value="2" <?php echo ($this->input->post('status') == 2) ? 'selected' : ''?>>Đang đàm phán</option>
           <option value="3" <?php echo ($this->input->post('status') == 3) ? 'selected' : ''?>>Đang xử lý</option>
           <option value="4" <?php echo ($this->input->post('status') == 4) ? 'selected' : ''?>>Đã gủi hàng</option>
           <option value="7" <?php echo ($this->input->post('status') == 7) ? 'selected' : ''?>>Đơn bị hủy</option>

         </select>
       </div>
     </div>


     <div class="form-group" style="float: left;width: 50%">
      <label class="col-xs-3 control-label">Từ ngày</label>
      <div class="col-xs-5 date" >
        <div class="input-group input-append date" id="datePicker" >
          <input  type="text" class="form-control" value="<?php echo set_value('from_date') ?>"  name="from_date"  />
          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar " ></span></span>
        </div>


      </div>
    </div> 


    <div class="form-group" style="float: left;width: 50%">
      <label class="col-xs-3 control-label">Đến ngày</label>
      <div class="col-xs-5 date" >
        <div class="input-group input-append date" id="datePicker1">
          <input  type="text" class="form-control" value="<?php echo set_value('end_date') ?>"  name="end_date" />
          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>

      </div>
    </div>


    <div class="form-group">
      <div class="col-xs-6 col-xs-offset-4">
        <button type="submit" class="btn btn-default">Tìm kiếm</button>
      </div>
    </div>
  </form>


  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th class="description" style="color: blue">Mã đơn hàng</th>
          <th class="description" style="color: blue">Ngày đặt hàng</th>
          <th class="description" style="color: blue">Ngày nhận hàng </th>
          <th class="description" style="color: blue">Tổng số tiền</th>
          <th class="description" style="color: blue">Nội dung</th>
          <th class="description" style="color: blue">Trạng thái</th>
          <th class="text-center" style="color: blue">Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($list as $row):?>
          <tr>
            <th><?php echo $row->order_id?></th>
            <td> <?php echo mdate('%d-%m-%Y',$row->date_order)?></td>
            <td> <?php echo mdate('%d-%m-%Y',$row->date_receive)?></td>
            <td> <?php if (isset($row->total_price)) {?>
              <?php if($row->total_price==0) { ?>
              <?php echo '<strong style="color:#fe950f">'.'Thương lượng'.'</strong>' ?>
              <?php } ?>

              <?php if($row->total_price>0) { ?>
              <?php echo  number_format($row->total_price, 0, '.', ',') ?>
              <?php } ?>
              <?php } ?>
            </td>

            <td> <?php echo $row->description?> </td>
            <td >


              <?php if (isset($row->status)) {?>
              
              <span class="label label-warning"> <?php if($row->status==1){echo 'Đơn hàng mới';}?></span>
              <span class="label label-success"><?php if($row->status==4){echo "Đã gửi hàng";}?></span>
              <span class="label label-danger"><?php if($row->status==7){echo "Đơn hàng bị hủy";}?></span>  <span class="label label-success"><?php if($row->status==5){echo "Đã nhận hàng";}?></span>
              <span class="label label-success"><?php if($row->status==6){echo "Đã hoàn thành";}?></span>
              <span class="label label-info"> <?php if($row->status==2){echo "Đang đàm phán";}?></span>
              <span class="label label-success"> <?php  if($row->status==3){echo "Đang xử lý";}?></span>

              <?php } ?>
            </td>

            <td><a href="<?php echo user_url('profile/list_order_details/'.$row->order_id) ?>" class="btn btn-info btn-sm">Xem</a>
            </td>
            
             <!--     <td>
              <?php if ( $row->status ==1|| $row->status==2)  {?>
              <a href="<?php echo user_url('profile/list_order_details/'.$row->order_id) ?>" class="btn btn-warning btn-sm">Sửa</a>
              <?php } ?>
             
            </td> -->
          </tr>

        <?php endforeach;?> 

      </tbody>
    </table>
    <div class="clearfix"></div>
    <ul class="pagination pull-right">
      <li><?php echo $this->pagination->create_links();?></li>
    </ul>
  </div>
</div>
</div>
