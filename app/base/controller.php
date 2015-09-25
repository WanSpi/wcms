<?php
	class baseController {
		public $view = true;
		public $models = array();
		public $modules = array();
		public $template = "index";
		public function init() {}
		
		protected function isPost() {
			return $_SERVER["REQUEST_METHOD"] === "POST" ? true : false;
		}
		
		protected function getData() {
			return empty($_POST) ? json_decode(file_get_contents("php://input")) : $_POST;
		}
		
		protected function getUrl() {
			return preg_split("/[\/]+/", $_GET['url']);
		}
		
		protected function uploadImage($image) {
			preg_match ("/\/(.+)/" , $image["type"], $type);
			
			$rand = rand(100000, 999999) . "";
			$l = strlen($rand);
			$url = "images/uploads/";
			for ($i = 0; $i < $l; $i++) {
				$url .= $rand[$i] . '/';
				if (!file_exists($url)) {
					if(!mkdir($url, 0755)) {
						return false;
					}
				}
			}
			
			$url = $url . uniqid() . "." . $type[1];
			
			move_uploaded_file($file["tmp_name"], $url);
			
			return $url;
		}
		
	}
?>