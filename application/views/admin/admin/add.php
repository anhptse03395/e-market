<?php $this ->load->view('admin/admin/head',$this->data) ?>
<div class="line"></div>

<div class="wrapper">

	<div class="widget">

		<div class="title">
			
			<h6>Them moi thanh vien</h6>

		</div>

		<form class="form" id="form" action="" method="post" enctype="multipart/form-data">
			<fieldset>
				<div class="formRow">
					<label for="param_name" class="formLeft">Tên:<span class="req">*</span></label>
					<div class="formRight">
						<span class="oneTwo"><input type="text" _autocheck="true" id="param_name" value="<?php echo set_value('name')?>" name="name"></span>
						<span class="autocheck" name="name_autocheck"></span>
						<div class="clear error" name="name_error"><?php echo form_error('name')?></div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label for="param_username" class="formLeft">Username:<span class="req">*</span></label>
					<div class="formRight">
						<span class="oneTwo"><input type="text" _autocheck="true" value="<?php echo set_value('username')?>" id="param_username" name="username"></span>
						<span class="autocheck" name="name_autocheck"></span>
						<div class="clear error" name="name_error"><?php echo form_error('username')?></div>
					</div>
					<div class="clear"></div>
				</div>
		


				<div class="formRow">
					<label for="param_name" class="formLeft" >PassWord:<span class="req">*</span></label>
					<div class="formRight">
						<span class="oneTwo"><input type="password" _autocheck="true" id="param_password"  name="password"></span>
						<span name="name_autocheck" class="autocheck"></span>
						<div class="clear error" name="name_error" ><?php echo form_error('password') ?></div>
					</div>
					<div class="clear"></div>
				</div>

				<div class="formRow">
					<label class="formLeft" for="param_name">Nhap lai mk:<span class="req">*</span></label>
					<div class="formRight">
						<span class="oneTwo"><input name="re_password" id="param_re_password" _autocheck="true" type="password"></span>
						<span name="name_autocheck" class="autocheck"></span>
						<div class="clear error" name="name_error"> <?php echo form_error('re_password'); ?> </div>
					</div>
					<div class="clear"></div>
				</div>

				<div class="formRow">
					<label class="formLeft" for="param_name">Phan Quyen:<span class="req">*</span></label>
					<div class="formRight">
						<?php foreach ($config_permissions  as $controller => $action):?> 
							<div>
								<label><b><?php echo $controller?>:</b></label>
								<?php foreach ($action as $action):?>
								<label><input type="checkbox" name="permissions[<?php echo $controller?>][]" value="<?php echo $action?>" /><?php echo $action?></label>
								<?php endforeach;?>
							</div>
							<div class="clear"></div>
						<?php endforeach;?>
													
					</div>
					<div class="clear"></div>
					
				</div>

				<div class="formSubmit">
					<input type="submit" value="Thêm mới" class="redB">

				</div>

			</fieldset>
		</form>
	</div>

</div>