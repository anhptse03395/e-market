<div class="table-responsive" style="margin-top: 5%">

    <?php  $message = $this->session->flashdata('message');
    ?>
    <?php if(isset($message) && $message):?>
        <div class="alert alert-success">
            <h3 style="text-align: center;"><strong> </strong><?php echo $message?></h3>
        </div>
    <?php endif;?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="well well-sm">
                    <form action="<?php echo user_url('post') ?>"  method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subject">
                                        Danh Mục Sản Phẩm</label>
                                    <div class="input-group">
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span>
                                </span>
                                        <select  name="catalog" class="form-control">
                                            <option value="">Danh mục</option>
                                            <?php foreach ($catalogs as $row):?>
                                                <?php if(count($row->subs) > 1):?>
                                                    <optgroup label="<?php echo $row->category_name?>">
                                                        <?php foreach ($row->subs as $sub):?>
                                                            <option  value="<?php echo $sub->id?>" <?php echo ($this->input->post('catalog') == $sub->id) ? 'selected' : ''?>> <?php echo $sub->category_name?> </option>
                                                        <?php endforeach;?>
                                                    </optgroup>
                                                <?php else:?>
                                                    <option value="<?php echo $row->id?>" <?php echo ($this->input->post('catalog') == $row->id) ? 'selected' : ''?>><?php echo $row->category_name?></option>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">
                                        Tên sản phẩm</label>
                                    <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-text-height"></span>
                                </span>
                                        <input type="text" class="form-control"  placeholder=" Tên sản phẩm" name="p_product_name" value="<?php echo set_value('p_product_name')?>" required="required" /></div>
                                    <div class="clear error" name="name_error"><?php echo form_error('p_product_name')?></div>
                                </div>
                                <div class="form-group">
                                    <label for="email">
                                        Số lượng/Kg</label>
                                    <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hdd"></span>
                                </span>
                                        <input type="text" style="width: 50%" class="form-control"  placeholder="Số lượng/kg" name="p_number" value="<?php echo set_value('p_number')?>" required="required" /></div>
                                    <div class="clear error" name="name_error"><?php echo form_error('p_number')?></div>
                                </div>

                                <div class="form-group">
                                    <label for="email">
                                        Hình ảnh</label>
                                    <div class="input-group">
                                <span class="input-group-addon"><span class="	glyphicon glyphicon-picture"></span>
                                </span>
                                        <input type="file" class="form-control" name="image" id="image" size="10" required="required"  value="<?php echo set_value('image'); ?>" />
                                    </div>
                                    <div class="clear error" name="image_error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="email">
                                        Hình ảnh kèm theo</label>
                                    <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span>
                                </span>
                                        <input type="file" class="form-control" multiple="" name="image_list[]" id="image_list" size="40"></div>
                                    <div class="clear error" name="image_list_error"></div>
                                </div>


                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">
                                        Nội Dung</label>
                                    <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span>
                                </span>
                                        <textarea type="text" class="form-control" rows="9" cols="25" name="p_content" required="required" placeholder="Nội Dung Đăng Bài"><?=set_value('p_content')?></textarea>

                                    </div>
                                    <div class="clear error" name="name_error"><?php echo form_error('p_content')?></div>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary pull-right" >
                                    Đăng Tin</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>