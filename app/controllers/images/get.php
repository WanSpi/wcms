<?php
	class Controller extends baseController {
		public $models = array(
			"images"
		);
		
		public function init() {
			$this -> view = false;
			$url = $this -> getUrl();
			$id = $url[count($url) - 1];
			
			$image = images::findFirst(array(
				"where" => "id = $id"
			));
			
			$file_extension = strtolower(substr(strrchr($image -> url,"."),1));

			switch( $file_extension ) {
				case "gif": $ctype="image/gif"; break;
				case "png": $ctype="image/png"; break;
				case "jpeg":
				case "jpg": $ctype="image/jpeg"; break;
				default:
			}
			header('Content-type: ' . $ctype);
			echo file_get_contents($image -> url);
			
			return false;
		}
	}
?>