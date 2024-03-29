<?php
Class Product_model extends MY_Model
{
  var $table = 'products';


  function join_shop($input = array())
  {

 /*   $status = array(1,2,3,4);
$this->db->where_in('status', $status);*/   
 $this->get_list_set_input($input);
    $this->db->select('products.id as product_id,product_name,shop_name,products.created as product_created, image_link,image_list,image_shop,shops.id as shop_id,shops.created as shop_created');
    $this->db->from('products');
    $this->db->join('shops','shops.id = products.shop_id','left');
  $this->db->join('accounts', 'accounts.id = shops.account_id','left');
  $this->db->where('role_id =3');
    $query = $this->db->get();
    return $query->result(); 

  }
  function join_shop_imp($input = array())
  {

    $this->get_list_set_input_impression($input);
//nếu có join tới bảng khác
     $this->db->select('products.id as product_id,product_name,shop_name,products.created as product_created, image_link,image_list,image_shop,shops.id as shop_id,shops.created as shop_created');
    $this->db->from('products');
    $this->db->join('shops','shops.id = products.shop_id','left');
     $this->db->join('accounts', 'accounts.id = shops.account_id','left');
       $this->db->where('role_id =3');
    $query = $this->db->get();
//tra ve du lieu
    return $query->result(); 

  }
  


  function search_listpost($input= array(),$shop_id){
    $this->get_list_set_input($input);
    $this->db->select('id,product_name,created ,image_link,image_list,description');
    $this->db->from('products');
    $this->db->where('products.shop_id',$shop_id);
    $query = $this->db->get();
    return $query->result();


  }


  function join_detail ($id){


    $this->db->select('products.id as product_id,product_name,shop_name,products.created as product_created, image_link,image_list,shops.address as address,phone,description,shops.id as shop_id,category_id,market_id,suppliers.id as supplier_id');
    $this->db->from('products');
    $this->db->join('shops', 'products.shop_id = shops.id','left');
    $this->db->join('suppliers', 'products.supplier_id = suppliers.id','left');
    $this->db->join('accounts', 'accounts.id = shops.account_id','left');
    $this->db->where('products.id', $id);

    $query = $this->db->get();
    return $query->row();

  }

/*  function list_product_shop($id,$page){

    $query = $this->db->get('products', $id, $page);
    return $query->result();

  }*/

  function list_product_shop($shop_id,$limit,$offset){

    $this->db->select('*');
    $this->db->from('products');
   // $this->db->join('shops', 'products.shop_id = shops.id','left');

    $this->db->where('products.shop_id', $shop_id);
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
  }


  function category_list($category_id,$limit,$offset){

    $this->db->select('products.id as product_id,product_name,shop_name,products.created as product_created, image_link,image_list,image_shop,shops.id as shop_id,shops.created as shop_created');
    $this->db->from('products');
    $this->db->join('shops', 'products.shop_id = shops.id','left');
    $this->db->where('products.category_id', $category_id);
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
  }

  /*hàm của Đức*/
 function  view_product(){

        $this->db->select('products.id as product_id,shop_name,phone,description,product_name,image_link,products.created as created');
        $this->db->from('products');
        $this->db->join('shops', 'products.shop_id = shops.id','left');
        $this->db->join('suppliers', 'products.supplier_id = suppliers.id','left');
        $this->db->join('accounts','shops.account_id = accounts.id');
        // $this->db->where('product_name like "%xà lách%"');
        $this->db->order_by('product_id',"asc");

        $query = $this->db->get();
        return $query->result();
      }

        function  paging_product($limit,$offset){

        $this->db->select('products.id as product_id,shop_name,phone,description,product_name,image_link,products.created as created');
        $this->db->from('products');
        $this->db->join('shops', 'products.shop_id = shops.id','left');
        $this->db->join('suppliers', 'products.supplier_id = suppliers.id','left');
        $this->db->join('accounts','shops.account_id = accounts.id');
         //$this->db->where('product_name like "%xà lách%"');
        $this->db->order_by('product_id',"asc");
        $this->db->limit($limit,$offset);

        $query = $this->db->get();
        return $query->result();
      }

      function  search_product($input = array())
      {
        $this->get_list_set_input($input);
        $this->db->select('products.id as product_id,shop_name,phone,description,product_name,image_link,category_id,products.created as created');
        $this->db->from('products');
        $this->db->join('shops', 'products.shop_id = shops.id','left');
        $this->db->join('suppliers', 'products.supplier_id = suppliers.id','left');
        $this->db->join('accounts','shops.account_id = accounts.id');
        $this->db->order_by('product_id',"asc");
        //$this->db->where('products.id',$product_id);

        $query = $this->db->get();
        return $query->result();
      }


}