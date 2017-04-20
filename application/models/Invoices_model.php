<?php 




/*$sql = "select * from products where shop_id=$id limit ".$config['per_page']." offset ".(($page-1)*$config['per_page']);*/


Class Invoices_model extends MY_Model{

	var $table ='invoices';


	function count_debt_shop($shop_id){

		$query =	$this->db->query('SELECT t1.order_id, t1.buyer_name,t1.shop_id, t1.total_price, t2.total_paid, t1.total_price - t2.total_paid AS debt
			FROM (SELECT o.id as order_id,o.shop_id ,COUNT(od.order_id) AS OrderDetail,b.buyer_name ,SUM(od.price * od.quantity) AS total_price
			FROM orders o
			JOIN order_details od ON o.id = od.order_id 
			LEFT JOIN buyers b on o.buyer_id =b.id
			GROUP BY o.id
			) AS t1
			JOIN 
			(SELECT iv.order_id AS Id2, 
			SUM(iv.amount) AS total_paid FROM invoices iv 
			JOIN orders o2 ON o2.id = iv.order_id 
			GROUP BY O2.id) AS t2 

			ON t1.order_id = t2.Id2
			where t1.shop_id=' .$shop_id.'
			');


		return $query->result();

	}
	function list_debt_shop($shop_id,$limit=0,$offset=0){




		$query =	$this->db->query('SELECT * from ((SELECT t1.status, t1.order_id, t1.buyer_name,t1.shop_id, t1.total_price, t2.total_paid, t1.total_price - t2.total_paid AS debt
			FROM (SELECT o.id as order_id, o.status,o.shop_id ,COUNT(od.order_id) AS OrderDetail,b.buyer_name ,SUM(od.price * od.quantity) AS total_price
			FROM orders o
			JOIN order_details od ON o.id = od.order_id 
			JOIN buyers b on o.buyer_id =b.id
			GROUP BY o.id

			) AS t1
			JOIN 
			(SELECT iv.order_id AS Id2, 
			SUM(iv.amount) AS total_paid FROM invoices iv 
			JOIN orders o2 ON o2.id = iv.order_id 
			GROUP BY O2.id) AS t2 
			ON t1.order_id = t2.Id2
			WHERE t1.shop_id ='.$shop_id.     
			') as T3)
			limit '.$offset.','.$limit.'		
			');



		return $query->result();

	}

	function detail_debt_shop($order_id){

		$query=	$this->db->query('SELECT * from 
			orders o left JOIN invoices iv on o.id = iv.order_id 
			LEFT join buyers b on o.buyer_id = b.id
			LEFT join accounts a on b.account_id = a.id
			where o.id ='.$order_id.'
			');

		return $query->result();

	}


	function count_debt_buyer($buyer_id){

		$query =	$this->db->query('SELECT t1.order_id,t1.buyer_id ,t1.shop_name,t1.shop_id, t1.total_price, t2.total_paid, t1.total_price - t2.total_paid AS debt  
			FROM (SELECT o.id as order_id,o.buyer_id,o.shop_id ,COUNT(od.order_id) AS OrderDetail,s.shop_name ,SUM(od.price * od.quantity) AS total_price
			FROM orders o
			JOIN order_details od ON o.id = od.order_id 
			LEFT JOIN shops s on o.shop_id =s.id
			GROUP BY o.id
			) AS t1
			JOIN 
			(SELECT iv.order_id AS Id2, 
			SUM(iv.amount) AS total_paid FROM invoices iv 
			JOIN orders o2 ON o2.id = iv.order_id 
			GROUP BY O2.id) AS t2 

			ON t1.order_id = t2.Id2
			where t1.buyer_id=' .$buyer_id.'
			');


		return $query->result();

	}
	function list_debt_buyer($buyer_id,$limit=0,$offset=0){

		$query =	$this->db->query('SELECT * from ((SELECT t1.status,t1.order_id, t1.shop_name,t1.buyer_id, t1.total_price, t2.total_paid, t1.total_price - t2.total_paid AS debt 
			FROM (SELECT o.id as order_id,o.buyer_id ,o.status, COUNT(od.order_id) AS OrderDetail,s.shop_name ,SUM(od.price * od.quantity) AS total_price
			FROM orders o
			JOIN order_details od ON o.id = od.order_id 
			LEFT JOIN shops s on o.shop_id =s.id
			GROUP BY o.id
			) AS t1
			JOIN 
			(SELECT iv.order_id AS Id2, 
			SUM(iv.amount) AS total_paid FROM invoices iv 
			JOIN orders o2 ON o2.id = iv.order_id 
			GROUP BY O2.id) AS t2
			ON t1.order_id = t2.Id2
			WHERE t1.buyer_id ='.$buyer_id. 

			') as T3)

			limit '.$offset.','.$limit.'
			');
		return $query->result();
	}

	function search_debt_buyer($buyer_id,$order_id,$shop_name){
		if(!isset($shop_name)){
			$shop_name = '';

		}
		if(!isset($order_id)){
			$order_id = '';

		}
		$query =	$this->db->query('SELECT * from ((SELECT t1.status,t1.order_id, t1.shop_name,t1.buyer_id, t1.total_price, t2.total_paid, t1.total_price - t2.total_paid AS debt 
			FROM (SELECT o.id as order_id,o.buyer_id ,o.status, COUNT(od.order_id) AS OrderDetail,s.shop_name ,SUM(od.price * od.quantity) AS total_price
			FROM orders o
			JOIN order_details od ON o.id = od.order_id 
			LEFT JOIN shops s on o.shop_id =s.id
			GROUP BY o.id
			) AS t1
			JOIN 
			(SELECT iv.order_id AS Id2, 
			SUM(iv.amount) AS total_paid FROM invoices iv 
			JOIN orders o2 ON o2.id = iv.order_id 
			GROUP BY O2.id) AS t2
			ON t1.order_id = t2.Id2
			WHERE t1.buyer_id ='.$buyer_id. 

			') as T3)
		
			where T3.order_id  = '.$order_id.'				
		
			');
		return $query->result();
	}


	function detail_debt_buyer($order_id){

		$query=	$this->db->query('SELECT * from 
			orders o left JOIN invoices iv on o.id = iv.order_id 
			LEFT join shops s on o.shop_id = s.id
			LEFT join accounts a on s.account_id = a.id
			where o.id ='.$order_id.'
			');

		return $query->result();

	}




}
?>
