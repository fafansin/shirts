<?php
	/*
	*	Database functions
	*/

	require_once dirname(__FILE__) . "/config.php";
	
    function open_connection(){
		global $db;
		$db = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
		$db->set_charset("utf8");

		if($db->connect_errno > 0){
	 		die('Unable to connect to database [' . $db->connect_error . ']');
		}
    }
	
	function get_results($query){
		open_connection();
		global $db;
		//
		$result = $db->query($query);
		if(!$result){
			die('There was an error running the query [' . $db->error . ']');
		}
		
		$list = array();
		while($row = $result->fetch_assoc()){
			$item = new stdClass();
			foreach($row as $key => $value){
				$item->$key = $value;
			}
			array_push($list, $item);
		}
		$db->close();
		return $list;
	}
	
	function get_row($query){
		open_connection();
		global $db;
		//
		$result = $db->query($query. " LIMIT 1");
		if(!$result){
			die('There was an error running the query [' . $db->error . ']');
		}
		$item = NULL;
		if($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$item = new stdClass();
			foreach($row as $key => $value){
				$item->$key = $value;
			}
		}
		$db->close();
		//
		return $item;
	}
	/*
	* data structure 
	* 	example:
	* 		array('fieldname'=>'value');
	*/
	function insert($table, $data){
		global $db;
		open_connection();
		//
		$fields = array();
		$values = array();
		foreach($data as $key => $value){
			array_push($fields, $key);
			array_push($values, "'$value'");
		}
		$sql = "INSERT INTO $table (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $values). ")";
		//
		$ref = NULL;
		if ($db->query($sql) === TRUE) {
			$ref = $db->insert_id;
		} else {
			$ref = FALSE;
		}
		$db->close();
		return $ref;
	}
	
	function query($sql){
		global $db;
		open_connection();
		$ref = $db->query($sql);
		//
		if($ref !== TRUE){
			tracer($ref = $db->error);
		}
		
		$db->close();
		return $ref;
	}
	
	/*, 
	*	Application functions
	*/
    
    function get_parent_id($path){
		$result = get_results("SELECT ID FROM books WHERE path = '$path'");
        
        $total = count($result);
        $id = 0;
        if($total == 0){
            $id = 0;
        }else if($total == 1){
            $id = $result[0]->ID;
        }else{
            $id = -1;
        }
		
        return $id;
    }
    function insert_record($parent_id, $name, $type, $path, $desc){
        $result = get_results("SELECT ID, path FROM books WHERE path = '$path' LIMIT 0, 1");
        //
        if(count($result) < 1){
			$id = insert('books', array("parent_id" => $parent_id,
								"name" => $name,
								"type" => $type,
								"description" => $desc,
								"path" => $path));
            
        }else{
            $id = $result[0]->ID;
            var_dump("This record already exists");
        }
        //var_dump($result[0]['ID']);
        if($type == 'book_pdf'){
            move_file($id, $path, $type);
        }
    }
    
    
    function move_file($id, $path){
        echo "<br/>Path: " . $path;
        echo "<br/>Target: files/target/$id" . ".pdf<br/>";
		//
        rename($path, "files/target/$id" . ".pdf");
    }

	
	
	function books_get_children($id){
		//$children = get_results("SELECT ID, name, type, description FROM books WHERE parent_id = $id order by order_display asc, ID asc");
		//$children = get_results("SELECT  ID, name, type, description FROM books where parent_id = $id ORDER BY order_display ASC, CAST(name AS SIGNED) ASC");
		$children = get_results("select ID, name, type, description, has_pages from books where parent_id = $id order by order_display asc, if(cast(name as unsigned) < 1, 9999, cast(name as unsigned)) asc");
		//
		$list = array();
		foreach($children as $child){
			$item = new stdClass();
			//
			$item->key = $child->ID;
			$item->title = $child->name;
			$item->tooltip = $child->name;
			$item->isFolder = $child->type == 'folder';
			$item->has_pages = (int)$child->has_pages;
			if($child->type == 'folder'){
				$item->isLazy = true;
			}else{
				$item->link = "http://google.com";
				$item->description = $child->description;
			}
			
			array_push($list, $item);
		}
		return $list;
	}	
	
	function date_formater($date){
		$d = new DateTime($date);
		return $d->format('m/d/Y');

	}
	
	function tracer($obj){
		echo "<pre>";
		print_r($obj);
		echo "</pre>";
	}
	function add_log($book_id, $type){
		$IP = get_IP();
		$location = get_location($IP);
		$id = insert('books_logs', 
					  array("book_id" => $book_id,
							"type" => $type,
							"IP" => $IP,
							"country_code" => $location->countryCode,
							"country_name" => $location->countryName));
	}
	
	function get_IP(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
			//check ip from share internet
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//to check ip is pass from proxy
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
	
		return $ip;
	}
	
	function get_location($IP){
		//$xml = simplexml_load_file("http://api.hostip.info/?ip=123.125.114.144", null, null, 'gml',true);
		//$homepage = file_get_contents('http://api.hostip.info/?ip=123.125.114.144');
		//$xml = new SimpleXMLElement($homepage);
		$xml =  simplexml_load_file("http://api.ipinfodb.com/v3/ip-country/?key=".API_KEY."&ip=". $IP . "&format=xml");
		//$xml =  @file_get_contents('http://api.hostip.info/?ip=123.125.114.144');
		return $xml;
	}
	
	function insert_data($parent_id, $name, $type, $desc){
		global $wpdb;
		//
		$wpdb->insert('books', 
					array('parent_id' => $parent_id, 
						'name' => $name,
						'type' => $type,
						'description' => $desc));
		return $wpdb->insert_id;
	}
	
?>