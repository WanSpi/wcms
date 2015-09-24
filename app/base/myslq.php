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
		
	}
?>