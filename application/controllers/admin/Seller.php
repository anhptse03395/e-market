<?php
Class Seller extends MY_Controller
{
    function __construct()
    {


        parent::__construct();
        $this->load->model('shop_model');
    }
    
    /*
     * Lay danh sach admin
     */

    function check_phone()
    {
        $phone = $this->input->post('phone');
        $where = array('phone' => $phone);
        $this->load->model('account_model');
        //kiêm tra xem username đã tồn tại chưa
        if($this->account_model->check_exists($where))
        {
            //trả về thông báo lỗi
            $this->form_validation->set_message(__FUNCTION__, 'Số điện thoại đã được đăng kí');
            return false;
        }
        return true;
    }
    
    function index($offset = null) 
    {

        $total_rows= count($this->shop_model->join_role());


        $this->data['total_rows'] = $total_rows;
        if($offset != null){
            $offset = $this->uri->segment(4);

        }
        $limit = 10;
        //load ra thu vien phan trang 
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $total_rows;//tong tat ca cac san pham tren website
        $config['base_url']   = admin_url('seller/index'); //link hien thi ra danh sach san pham
        $config['per_page']   = $limit;//so luong san pham hien thi tren 1 trang
        //$config['uri_segment'] = 4;//phan doan hien thi ra so trang tren url
        $config['next_link']   = 'Trang kế tiếp';
        $config['prev_link']   = 'Trang trước';
        //khoi tao cac cau hinh phan trang
        $this->pagination->initialize($config);
        
        $list = $this->shop_model->paging_shop($limit,$offset);

        $this->data['list'] = $list;
        
        $total = count($list);
        $this->data['total'] = $total;
        
        //lay nội dung của biến message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        
        $this->data['temp'] = 'admin/seller/index';
        $this->load->view('admin/main', $this->data);
    }
    
    function search()
    {
     $total_rows= count($this->shop_model->join_role());


     $this->data['total_rows'] = $total_rows;
     $input = array();
     $this->load->library('form_validation');
     $this->load->helper('form');
        //neu co gui form tim kiem

     $where =array();
     if ($this->input->post()) {
        $this->session->unset_userdata('phone');
        $this->session->unset_userdata('from_date');
        $this->session->unset_userdata('end_date');
        $this->session->unset_userdata('status');
        $this->session->unset_userdata('role_id');


        $this->session->set_userdata('phone', $this->input->post('phone'));

        if ($this->session->userdata('phone')) {
            $where['accounts.phone'] = $this->session->userdata('phone');

        }
        $this->session->set_userdata('status', $this->input->post('status'));

        if ($this->session->userdata('status')) {
            $where['accounts.active'] = $this->session->userdata('status');

        }
        $this->session->set_userdata('role_id', $this->input->post('role_id'));

        if ($this->session->userdata('role_id')) {
            $where['accounts.role_id'] = $this->session->userdata('role_id');

        }

        $this->session->set_userdata('from_date', $this->input->post('from_date'));
        $from_date =  $this->session->userdata('from_date');
        $this->session->set_userdata('end_date', $this->input->post('end_date'));
        $end_date= $this->session->userdata('end_date');
        if ($from_date &&$end_date='') {
            $time = get_time_between_day_admin($from_date,$end_date);
            //nếu dữ liệu trả về hợp lệ
            if(is_array($time))
            {   
                $where['shops.created >='] = $time['start'];

            }

        }
        if ($end_date &&$from_date='') {
            $time = get_time_between_day_admin($end_date,$from_date);
            //nếu dữ liệu trả về hợp lệ
            if(is_array($time))
            {   

                $where['shops.created <='] = $time['end'];
            }

        }


        if ($from_date && $end_date) {
            $time = get_time_between_day($from_date,$end_date);
            //nếu dữ liệu trả về hợp lệ
            if(is_array($time))
            {   
                $where['shops.created >='] = $time['start'];
                $where['shops.created <='] = $time['end'];
            }

        }

    }

    if ($this->session->userdata('phone')) {
        $where['accounts.phone'] = $this->session->userdata('phone');

    }


    if ($this->session->userdata('status')) {
        $where['accounts.active'] = $this->session->userdata('status');

    }
    if ($this->session->userdata('role_id')) {
        $where['accounts.role_id'] = $this->session->userdata('role_id');

    }


    if ($this->session->userdata('from_date') && ($this->session->userdata('end_date'))) {

        $from_date= $this->session->userdata('from_date');
        $end_date= $this->session->userdata('end_date');
        $time = get_time_between_day_admin($from_date,$end_date);
        if(is_array($time))
        {   
            $where['shops.created >='] = $time['start'];
            $where['shops.created <='] = $time['end'];
        }

    }

    if ($this->session->userdata('from_date') && ($this->session->userdata('end_date'))=='') {

        $from_date= $this->session->userdata('from_date');
        $end_date= $this->session->userdata('end_date');
        $time = get_time_between_day_admin($from_date,$end_date);
        if(is_array($time))
        {   
            $where['shops.created  >='] = $time['start'];

        }

    }
    if ($this->session->userdata('from_date')=='' && ($this->session->userdata('end_date'))) {

        $from_date= $this->session->userdata('from_date');
        $end_date= $this->session->userdata('end_date');
        $time = get_time_between_day_admin($end_date,$from_date);
        if(is_array($time))
        {   

            $where['shops.created <='] = $time['end'];
        }

    }

        // cu tim theo session da gui trc do

    $input['where'] = $where;


        //pre($from_date);
        // phân trang sau search
    $total_row = count($this->shop_model->join_shops_admin($input));
        //pre($total_rows);

                    // thu vien phan trang
    $this->load->library('pagination');
    $config = array();
    $config['total_rows'] = $total_row;
        // neu ko search thi de link phan trang nhu binh thuong
        //if(!isset($id) || !isset($name) )
        //{
            $config['base_url'] = admin_url('seller/search'); // link hien thi du lieu
            // }
            $config['per_page'] = 20;
            $config['uri_segment'] = 4;
           // $config['use_page_numbers'] = TRUE;
            $config['next_link']   = 'Trang kế tiếp';
            $config['prev_link']   = 'Trang trước';
            $config['first_link'] = 'Trang đầu';
            $config['last_link'] = 'Trang cuối';
                //khoi tao cac cau hinh phan trang
            $this->pagination->initialize($config);

            $segment = intval($this->uri->segment(4));

            $input['limit'] = array($config['per_page'], $segment);

            $list = $this->shop_model->join_shops_admin($input);

            $this->data['list'] =$list;
            //echo $this->db->last_query();

            

        // load filter list


        // gan thong bao loi de truyen vao view
            $this->data['message'] = $this->session->flashdata('message');
            $this->data['temp'] = 'admin/seller/index';
            $this->load->view('admin/main', $this->data);
        }
    /*
     * Kiểm tra username đã tồn tại chưa
     */
    // function check_username()
    // {
    //     $name = $this->input->post('name');
    //     $where = array('user_name' => $name);
    //     //kiêm tra xem username đã tồn tại chưa
    //     if($this->buyer_model->check_exists($where))
    //     {
    //         //trả về thông báo lỗi
    //         $this->form_validation->set_message(__FUNCTION__, 'Tài khoản đã tồn tại');
    //         return false;
    //     }
    //     return true;
    // }
    
    /*
     * Thêm mới quản trị viên
     */
    function add()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');


        $this->load->model('market_place_model');
        $this->load->model('province_model');
        $provinces = $this->province_model->get_list();
        $this->data['provinces'] = $provinces;


        $province_id = $this->input->post('province');
        if($province_id){ 
            $input['where']  = array('province_id' => $province_id);
            $market_places = $this->market_place_model->get_list($input);


            $this->data['market_places'] = $market_places;


        }
        //neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[10]|numeric|callback_check_phone|regex_match[/^[0-9]{10}$/]');
            $this->form_validation->set_rules('shop_name', 'Tên', 'required|min_length[2]');
            $this->form_validation->set_rules('address', 'Địa Chỉ', 'required|min_length[5]');
            $this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[6]');
            $this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'matches[password]');
            
            //nhập liệu chính xác
            if($this->form_validation->run())
            {
                //them vao csdl
                $role_id     = $this->input->post('role_id');
                //pre($role_id);
                $phone = $this->input->post('phone');
                $active     = $this->input->post('acitve');
                $password = $this->input->post('password');
                
                $data = array(

                    'role_id' => 3,
                    'phone' => $phone,
                    'password' => md5($password),
                    'active' => 1
                    
                    );
                $this->load->model('account_model');
                $this->account_model->create($data);

                // $account_id = $this->db->insert_id();
                // pre($accounts_id);


                $this->load->model('shop_model');


                

                //$market_id = $this->input->post('market_id');
                $shop_name     = $this->input->post('shop_name');
                $address     = $this->input->post('address');
                $data_shop = array(
                    'market_id' => $this->input->post('market_id'),
                    'account_id' => $this->db->insert_id(),
                    'shop_name'     => $shop_name,
                    'address'    => $address
                    );



                if($this->shop_model->create($data_shop))
                { 
                    //tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', 'Thêm mới dữ liệu thành công');
                    //pre($data_shop);
                    
                }
                else{
                    $this->session->set_flashdata('message', 'Không thêm được');
                }
                //chuyen tới trang danh sách quản trị viên
                redirect(admin_url('seller'));
            }
        }


        
        $this->data['temp'] = 'admin/seller/add';
        $this->load->view('admin/main', $this->data);
    }
    
    /*
     * Ham chinh sua thong tin nguoi dung
     */
    function view()
    {
        //lay id cua quan tri vien can chinh sua
        $account_id = $this->uri->rsegment('3');
        
        $account_id = intval($account_id);

        $this->load->library('form_validation');
        $this->load->helper('form');
        

        $info  = $this->shop_model->join_edit_seller($account_id);

        $shop_id = $info->shop_id;
        if(!$info)
        {
            $this->session->set_flashdata('message', 'Không tồn tại quản trị viên');
            redirect(admin_url('seller'));
        }

        $this->data['info'] = $info;
        $this->load->model('market_place_model');
        $this->load->model('province_model');
        $this->load->model('account_model');

        $market_places = $this->market_place_model->get_info($info->market_id);

        $this->data['market_places'] = $market_places;

        $provinces = $this->province_model->get_info($market_places->province_id);
        $this->data['provinces'] = $provinces;

        if($this->input->post())
        {       

            if($info->role_id==3){
             $role_id = 4;
         }else{
            $role_id =3;
        }

        $data = array(
            'role_id' => $role_id,
            );


        
        
        if($role_id==4){
            $this->account_model->update($account_id, $data);
            $this->session->set_flashdata('message', 'Cấm thành công cửa hàng này');
        }if($role_id==3){
          $this->account_model->update($account_id, $data);
          $this->session->set_flashdata('message', 'Mở lại cửa hàng thành công');
      }

      

      redirect(admin_url('seller'));

  }

  $this->data['temp'] = 'admin/seller/view';
  $this->load->view('admin/main', $this->data);
}

    /*
     * Hàm xóa dữ liệu
     */
    function delete()
    {
        $shop_id = $this->uri->rsegment('3');
        $shop_id = intval($shop_id);
        $this->_del($shop_id);
        $this->session->set_flashdata('message', 'Xóa dữ liệu thành công');
        redirect(admin_url('seller'));
    }



    private function _del($id, $rediect = true)
    {   

      $this->load->model('account_model');
      $info = $this->shop_model->get_info($id);

      $account = $this->account_model->get_info($info->account_id);
      if(!$info)
      {
            //tạo ra nội dung thông báo
        $this->session->set_flashdata('message', 'không tồn tại cửa hàng  này');
        if($rediect)
        {
            redirect(admin_url('seller'));
        }else{
            return false;
        }
    }

        //kiem tra xem danh muc nay co san pham khong
    $this->load->model('orders_model');
    $order = $this->orders_model->get_info_rule(array('shop_id' => $id), 'id');
    if($order)
    {
            //tạo ra nội dung thông báo
        $this->session->set_flashdata('message', 'cửa hàng '.$info->shop_name.' có chứa đơn hàng,bạn cần xóa các đơn hàng trước khi xóa cửa hàng này');
        if($rediect)
        {
            redirect(admin_url('seller'));
        }else{
            return false;
        }
    }

    $this->account_model->delete($account->id);
    $this->shop_model->delete($id);

}



}



