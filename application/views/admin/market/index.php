<?php $this ->load ->view('admin/market/head',$this->data);?>

<div class="line"></div>
<div class="wrapper">
	<?php $this->load->view('admin/message',$this->data); ?>
	<div class="widget">

		<div class="title">

			<h6>Danh sách chợ</h6>
			<div class="num f12">Tổng số: </div>
		</div>

		<table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
			<thead class="filter"><tr><td colspan="9">
				<form method="post" action="<?php echo admin_url('market/search')?>" class="list_filter form">
					<table width="80%" cellspacing="0" cellpadding="0"><tbody>

						<tr>							
							<td style="width:40px;text-align: right;" class="label"><label for="filter_id"><b>Tên chợ</b></label></td>
							<td style="width:155px;" class="item"><input style="width:125px; border: 2px ridge" type="text" style="width:155px;" id="filter_iname" value="" name="market_name"></td>

							<td style="width:40px;text-align: right" class="label"><label for="filter_id"><b>Tên Tỉnh</b></label></td>
							<td style="width:155px;" class="item"><input style="width:125px; border: 2px ridge" type="text" style="width:155px;" id="filter_iname" value="" name="local_name"></td>

							 
												
							<td style="width:150px">
								<input type="submit" value="Tìm Kiếm" class="button blueB">
							</td>
						</tr>
					</tbody></table>
				</form>
			</td></tr></thead>




			<thead>
				<tr>
					<td style="width:10px;"><img src="<?php echo public_url('admin') ?>/images/icons/tableArrows.png" /></td>
					<td style="width:80px;">Mã số</td>
					<td>Tên Tỉnh</td>
					<td>Tên Chợ</td>
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

							<td><span title="<?php echo $row->market_name ?>" class="tipS">
							<?php echo $row->market_name ?></span></td>


<!-- 							<td><span title="<?php echo $row->role_name ?>" class="tipS">
							<?php echo $row->role_name ?></span></td> -->


							
							<td class="option">
								<a href="<?php echo admin_url('market/edit/'.$row->market_id) ?>" title="Chỉnh sửa" class="tipS">
									<img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png" />
								</a>							


								<a  onclick="return confirmAction()" href="<?php echo admin_url('market/delete/'.$row->market_id)?>" title="Xóa" class="tipS verify_action">
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


