<?php
	
	if( $this->param('from') == 'ajax' )
	{
		if( ! $this->user->is_logged ) {
			echo 'ERROR';
			exit;
		}
		if( ! isset($_POST['tabs']) ) {
			echo 'ERROR';
			exit;
		}
		$tabs	= explode(',', $_POST['tabs']);
		$data	= array();
		foreach($tabs as $tb) {
			$t	= str_replace('usertab', '', $tb);
			$t	= str_replace('_', '', $t);
			$t	= trim($t);
			$r	= get_tab_state($this->user->id, $t);
			if( $r ) {
				$data[]	= $tb;
			}
		}
		header('Content-type: text/plain');
		echo 'OK:';
		echo implode(',', $data);
		exit;
	}
	
	$this->redirect( $this->get_lasturl() );
	
?>