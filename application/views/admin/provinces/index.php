<?php $this ->load ->view('admin/provinces/head',$this->data);?>

<div class="line"></div>
<div class="wrapper">
	<?php $this->load->view('admin/message',$this->data); ?>
	<div class="widget">

		<div class="title">

			<h6>Danh sách tỉnh</h6>
			<div class="num f12">Tổng số: <b> <?php echo  $total ?></b></div>
		</div>

		<table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
			<thead>
				<tr>
					<td style="width:10px;"><img src="<?php echo public_url('admin') ?>/images/icons/tableArrows.png" /></td>
					<td style="width:80px;">Mã số</td>
					<td>Province Name</td>
					<td>Quốc Gia</td>
					<!-- <td>Chức vụ</td> -->
					<td style="width:100px;">Hành động</td>
				</tr>
			</thead>
			
			<tfoot>


				<tr>
					<td colspan="7">

						<div class="pagination">
							<?php echo $this->pagination->create_links()?>
						</div>
					</td>
				</tr>
			</tfoot>
			<?php foreach ($list as $row):  ?>
				<tr>
					<td><input type="checkbox" name="id[]" value="<?php echo $row->province_id ?>" /></td>

					<td class="textC"><?php echo $row->province_id ?></td>


						<td><span title="<?php echo $row->local_name ?>" class="tipS"> 
							<?php echo $row->local_name ?></span></td>

							<td><span>
							Việt Nam</span></td>


<!-- 							<td><span title="<?php echo $row->role_name ?>" class="tipS">
							<?php echo $row->role_name ?></span></td> -->


							
							<td class="option">
								<a href="<?php echo admin_url('province/edit/'.$row->province_id) ?>" title="Chỉnh sửa" class="tipS">
									<img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png" />
								</a>

							


								<a  onclick="return confirmAction()" href="<?php echo admin_url('province/delete/'.$row->province_id)?>" title="Xóa" class="tipS verify_action">
									<img src="<?php echo public_url('admin')?>/images/icons/color/delete.png" />
								</a>


							</td>
						</tr>
					<?php endforeach ;?>
					<tbody>
					</table>

				</div>
			</div>
			<div class="clear mt30"></div>

