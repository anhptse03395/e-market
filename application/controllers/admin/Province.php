<?php
Class Province extends MY_Controller
{
    function __construct()
    {
         

        parent::__construct();
        $this->load->model('province_model');
    }
    function removeURL($strTitle)
    {

       $strTitle=trim($strTitle);
       $strTitle= preg_replace("/ {2,}/", " ", $strTitle);
       return $strTitle;
   }
    
    /*
     * Lay danh sach admin
     */
    function index()
    {
        //$input = array();

        $input = array();
        $input['select']="local_name,country_name,provinces.id as province_id";

        $input['join'] = array('countries');



        $total_rows = count($this->province_model->join_country_admin($input));

        $this->data['total_rows'] = $total_rows;

        //load ra thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $total_rows;//tong tat ca cac san pham tren website
        $config['base_url']   = admin_url('province/index'); //link hien thi ra danh sach san pham
        $config['per_page']   = 10;//so luong san pham hien thi tren 1 trang
        $config['uri_segment'] = 4;//phan doan hien thi ra so trang tren url
        $config['next_link']   = 'Trang kế tiếp';
        $config['prev_link']   = 'Trang trước';
        //khoi tao cac cau hinh phan trang
        $this->pagination->initialize($config);
        
        $segment = $this->uri->segment(4);
        $segment = intval($segment);
        

        $input['limit'] = array($config['per_page'], $segment);

        $list = $this->province_model->join_country_admin($input);
        $this->data['list'] =$list;
        //$this->data['list'] = $list;

        
        
        //lay nội dung của biến message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        
        $this->data['temp'] = 'admin/provinces/index';
        $this->load->view('admin/main', $this->data);
    }
    


    function search()
    {
         $input = array();
        $this->load->library('form_validation');
        $this->load->helper('form');
        //neu co gui form tim kiem
         $input['where'] = array();
        if ($this->input->post()) {
            $this->session->unset_userdata('local_name');
           
            

            $local_name= $this->input->post('local_name');

            $this->session->set_userdata('local_name',$this->removeURL($local_name));
            if ($this->session->userdata('local_name')) {
                $input['like'] = array('local_name', $this->session->userdata('local_name'));
            }
            
        }
        // cu tim theo session da gui trc do
        if ($this->session->userdata('local_name')) {
            $input['where'] = array();
            
                $local_name =$this->session->userdata('local_name');
            if ($this->session->userdata('local_name')) {
                $input['like'] = array('local_name', $this->removeURL($local_name));
            }
        }
          
        
        
        // phân trang sau search
        //$input = array();
        $input['select']="local_name,country_name,provinces.id as province_id";
        $input['join'] = array('countries');
        $total_rows = count($this->province_model->join_country_admin($input));
        $this->data['total_rows'] =$total_rows;
        //pre($total_rows);

                    // thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $total_rows;
        // neu ko search thi de link phan trang nhu binh thuong
        //if(!isset($id) || !isset($name) )
        //{
            $config['base_url'] = admin_url('province/search'); // link hien thi du lieu
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

            $list = $this->province_model->join_country_admin($input);
            //pre($info);
            $this->data['list'] =$list;
            //pre($list);
           

            

        // load filter list
    
        
        // gan thong bao loi de truyen vao view
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['temp'] = 'admin/provinces/index';
        $this->load->view('admin/main', $this->data);
    }


    function add()
    {
        
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('local_name', 'Tên', 'required');
            $this->form_validation->set_rules('country_id', 'Mã Nước', 'required');

            
            //nhập liệu chính xác
            if($this->form_validation->run())
            {
                //them vao csdl
                $local_name     = $this->input->post('local_name');
                $country_id     = $this->input->post('country_id');

                $data = array(
                    'local_name'     => $local_name,
                    'country_id' => 1
                );
                if($this->province_model->create($data))
                { 
                    //tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', 'Thêm mới dữ liệu thành công');
                }else{
                    $this->session->set_flashdata('message', 'Không thêm được');
                }
                //chuyen tới trang danh sách quản trị viên
                redirect(admin_url('province'));
            }
        }
        
        $this->data['temp'] = 'admin/provinces/add';
        $this->load->view('admin/main', $this->data);
    }
    
    /*
     * Ham chinh sua thong tin quan tri vien
     */
    function edit()
    {
        //lay id cua quan tri vien can chinh sua
        $province_id = $this->uri->rsegment('3');
        
        $province_id = intval($province_id);

        // pre($id);
        
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //lay thong cua quan trị viên
        $info  = $this->province_model->get_info($province_id);
        
        //pre($info);
        if(!$info)
        {
            $this->session->set_flashdata('message', 'Không tồn tại quản trị viên');
            redirect(admin_url('province'));
        }
        //pre($info);
        $this->data['info'] = $info;
        //pre($info);
        
        
        if($this->input->post())
        {
            $this->form_validation->set_rules('local_name', 'Tên Tỉnh', 'required');
            

            if($this->form_validation->run())
            {
                //them vao csdl
                $local_name     = $this->input->post('local_name');
                $data = array(
                    'local_name'     => $local_name

                );

              
                
                if($this->province_model->update($province_id, $data))
                {
                    //tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', 'Cập nhật dữ liệu thành công');
                    //pre($local_name);
                }else{
                    $this->session->set_flashdata('message', 'Không cập nhật được');
                }
                //chuyen tới trang danh sách quản trị viên
                redirect(admin_url('province'));
            }
        }

        
        $this->data['temp'] = 'admin/provinces/edit';
        $this->load->view('admin/main', $this->data);
    }
    
    /*
     * Hàm xóa dữ liệu
     */
    function delete()
    {
        $province_id = $this->uri->rsegment('3');
        $province_id = intval($province_id);
        //lay thong tin cua quan tri vien
        $info = $this->province_model->join_role();

        if(!$info)
        {
            $this->session->set_flashdata('message', 'Không tồn tại quản trị viên');
            redirect(admin_url('admin'));
        }
        //thuc hiện xóa
        $this->province_model->delete($province_id);
        
        $this->session->set_flashdata('message', 'Xóa dữ liệu thành công');
        redirect(admin_url('province'));
    }

    
    
    
}
?>


