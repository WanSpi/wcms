<?php
	class Controller extends baseController {
		public $models = array(
			"images"
		);
		
		private function createPath() {
			$rand = rand(100000, 999999) . "";
			$l = strlen($rand);
			$url = "images/uploads/";
			for ($i = 0; $i < $l; $i++) {
				$url .= $rand[$i] . '/';
				if (!file_exists($url)) {
					mkdir($url, 0755);
				}
			}
			$uniqid = uniqid();
			
			return $url . $uniqid;
		}
		
		public function init() {
			$this -> view = false;
			$res = array();
			
			foreach($_FILES as $file) {
				preg_match ("/\/(.+)/" , $file["type"], $type);
				$url = $this -> createPath() . "." . $type[1];
				
				move_uploaded_file($file["tmp_name"], $url);
				
				$image = new images();
				
				$image -> url = $url;
				$image -> name = $file["name"];
				$image -> size = $file["size"];
				
				$image -> save();
				
				$img = images::findFirst(array(
					"where" => "url = '$url'"
				));
			}
			
			echo json_encode(array(
				"id" => $img -> id,
				"url" => $image -> url
			), JSON_FORCE_OBJECT);
		}
	}
?>