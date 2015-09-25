<?php
	class mysql {
		
		public static $myslqi;
		public static function connect() {
			self::$myslqi = new mysqli("localhost", "root", "password", "db");
			mysqli_set_charset(self::$myslqi, "utf8");
		}
		public static function query($query) {
			return self::$myslqi -> query($query);
		}
		public static function inject($var, $type) {
			$len = strlen($var);
			$buf = "";
			
			switch($type) {
				case "int":
					for($i = 0; $i !== $len; $i++) {
						if($var[$i] >= '0' && $var[$i] <= '9') {
							$buf .= $var[$i];
						}
					}
					break;
				case "string":
					$buf = str_replace(array("'", "`", '"'), array("&#039;", "&#039;", "&quot;"), $var);
					break;
				default:
					$buf = $var;
			}
			
			return $buf;
		}
		
	}
?>