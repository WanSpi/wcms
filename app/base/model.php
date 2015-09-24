<?php
	class baseModel {
		
		public function __construct() {
			foreach($this as $key => $value) {
				$value = "a";
			}
			//print_r($this);
		}
		
		public function save() {
			$model = get_called_class();
			if($this -> id) {
				$col = "";
				foreach($this as $key => $value) {
					if($key !== "id") {
						$col .= ($col === "" ? "" : ",") . "`$key`='$value'";
					}
				}
				$sql = "UPDATE `$model` SET $col WHERE `id` = " . $this -> id;
			} else {
				$col = $val = "";
				
				foreach($this as $key => $value) {
					if($key !== "id") {
						$col .= ($col === "" ? "" : ",") . "`$key`";
						$val .= ($val === "" ? "" : ",") . "'$value'";
					}
				}
				
				$sql = "INSERT INTO `$model` ($col) values ($val)";
			}
			mysql::query($sql);
		}
		
		public function delete() {
			$model = get_called_class();
			$sql = "DELETE FROM `$model` WHERE `id` = " . $this -> id;
			mysql::query($sql);
		}
		
		private static function query($arrSea, $isFind) {
			$model = get_called_class();
			
			$limit = isset($arrSea["limit"]) ? "LIMIT " . $arrSea["limit"] : "";
			if(!$isFind) {
				$limit = "LIMIT 1";
			}
			
			$order = isset($arrSea["order"]) ? "ORDER BY " . $arrSea["order"] : "";
			$where = isset($arrSea["where"]) ? "WHERE " . $arrSea["where"] : "";
			
			$sql = "SELECT * FROM `$model` $where $order $limit";
			$res = mysql::query($sql);
			
			if($res) {
				$findArr = array();
				
				for($i = 0; $i !== $res -> num_rows; $i++) {
					$res -> data_seek($i);
					$row = $res -> fetch_assoc();
					
					$class = new $model();
					
					foreach($class as $key => &$val) {
						$val = $row[$key];
					}
					
					if(!$isFind) {
						return $class;
					}
					
					array_push($findArr, $class);
				}
				
				return $findArr;
			} else {
				return false;
			}
		}
		
		public static function find($arrSea) {
			return self::query($arrSea, true);
		}
		
		public static function findFirst($arrSea) {
			return self::query($arrSea, false);
		}
		
	}
?>