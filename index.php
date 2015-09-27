<?php
	define("app_path", $_SERVER["DOCUMENT_ROOT"]);
	
	function error($num) {
		echo $num;
	}
	
	if(isset($_GET['error'])) {
		error($_GET['error']);
	}
	
	function getController() {
		if(isset($_GET['url'])) {
			$url = $_GET['url'];
			while(true) {
				if(file_exists(app_path . "/app/controllers/" . $url . ".php")) {
					return array(
						"controller" => $url,
						"dir" => "/" . $url
					);
				}
				if(file_exists(app_path . "/app/controllers/" . $url . "/index.php")) {
					return array(
						"controller" => $url . "/index",
						"dir" => "/" . $url
					);
				}
				if(!isset($urlArr)) {
					$urlArr = preg_split("/[\/]+/", $url);
				}
				$count = count($urlArr);
				if($count === 1) {
					if(file_exists(app_path . "/app/controllers/index.php")) {
						return array(
							"controller" => "index",
							"dir" => "/"
						);
					}
				}
				unset($urlArr[$count - 1]);
				$url = "";
				for($i = 0; $i != $count - 1; $i++) {
					$url .= ($i === 0 ? "" : "/") . $urlArr[$i];
				}
			}
		}
		
		if(file_exists(app_path . "/app/controllers/index.php")) {
			return array(
				"controller" => "index",
				"dir" => "/"
			);
		}
	}
	
	$path = getController();
	define("controller", $path["controller"]);
	define("controller_path", $path["dir"]);
	
	if(!controller) {
		error(404);
	} else {
		include app_path . "/app/base/myslq.php";
		include app_path . "/app/base/controller.php";
		include app_path . "/app/base/model.php";
		include app_path . "/app/base/filters.php";
		
		mysql::connect();
		
		include app_path . "/app/controllers/" . controller . ".php";
		$ctrl = new Controller();
		foreach($ctrl -> models as $val) {
			include app_path . "/app/models/" . $val . ".php";
		}
		$data = $ctrl -> init();
		if($ctrl -> view) {
			function content($data) {
				include app_path . "/views/" . controller . ".html";
			}
			include app_path . "/templates/" . $ctrl -> template . ".html";
		}
	}
?>