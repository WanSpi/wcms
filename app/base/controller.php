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
	}
?>