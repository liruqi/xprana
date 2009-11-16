<?php
	
	if( $this->user->is_logged && $this->param('log')=='out' ) {
		$this->user->logout();
		$this->redirect('home');
	}
	
	$this->redirect('home');
	
?>