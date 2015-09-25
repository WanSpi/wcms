<?php
	class Controller extends baseController {
		// Connects models
		public $models = array(
			"model" // Model name
		);
		
		public function init() {
			$this -> view = false; // Views disabled
			
			$model = new model();
			
			$model -> name = "name";
			$model -> size = 321;
			$model -> url = "http://example.com";
			
			$model -> save();
			
			$model2 = model::findFirst(array(
				"where" => "name = 'name'"
			));
			
			$model2 -> name = "New name for old model";
			
			$model -> save();
			
			return false;
		}
	}
?>