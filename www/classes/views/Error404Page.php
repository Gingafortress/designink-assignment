<?php
class Error404Page extends Page {

	public function contentHTML() {
		include 'templates/search/searchform.php';
		echo '<br><br><br><br><br>Error 404';
	}

}