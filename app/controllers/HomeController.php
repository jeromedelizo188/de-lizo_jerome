<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class HomeController extends Controller {
	public function landing_page(){
		$this ->call ->view('welcome_page');
	}
	
}
?>