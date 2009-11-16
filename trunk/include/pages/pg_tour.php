<?php
	
	$pages	= 4;
	
	$pg	= $this->param('pg');
	$pg	= intval($pg);
	$pg	= max($pg, 1);
	$pg	= min($pg, $pages);
	
	$title	= $this->lang('tour_title_'.$pg);
	$content	= $this->lang('tour_content_'.$pg);
	$image	= $this->lang('tour_image_'.$pg);
	$imagedsc	= $this->lang('tour_imagedsc_'.$pg);
	
	$this->title	= $title;
	
	$html	.= '
						<div id="tourtop">
							<strong>'.$this->lang('tour_title').'</strong>
							<div>'.$this->lang('tour_stepnm').$pg.$this->lang('tour_stepof').$pages.'</div>
							<div class="klear" style="float: none;"></div>
						</div>
				
						<div id="tourpage">
							<div id="tourpage_text">
								<h1>'.$title.'</h1>
								<p>'.$content.'</p>';
	if( $pg < $pages ) {
		$html	.= '
								<a href="'.SITEURL.'tour/pg:'.($pg+1).'" id="tour_nextpage">&raquo; <span><b>'.$this->lang('tour_nextstep').'</b></span></a>';
	}
	$html	.= '
							</div>
							<div id="tourpage_image">
								<img src="'.$image.'" style="width: 0px; height: 0px; display: none;" alt="" width="0" height="0" />
								<div id="immg" style="background-image:url(\''.$image.'\');">
									<strong>'.$imagedsc.'</strong>
								</div>
							</div>
							<div class="klear"></div>
						</div>
						
						<div id="tourpaging">
							<div id="pagez">';
	for($i=1; $i<=$pages; $i++) {
		$html	.= '
								<a href="'.SITEURL.'tour/pg:'.$i.'" class="'.($i==$pg?'ontourpage':'').'">'.$i.'</a>';
	}
	$html	.= '
			</div>';
	if( 0 == $this->user->is_logged ) {
		$html	.= '
							<a href="'.SITEURL.'register" id="tour_regnow">'.$this->lang('tour_register').'</a>';
	}
	$html	.= '
						</div>';
	
?>