<?php
	
	$this->params->layout	= 4;
	
	$this->title	= $this->lang('faq_title');
	
	$FAQ	= $this->lang('faq_html');
	
	$replace	= array();
	$replace2	= array();
	if( $this->user->is_logged ) {
		$replace['<!--TB_OU-->']	= '<a href="'.SITEURL.'profile/only:user">';
		$replace['<!--/TB_OU-->']	= '</a>';
		$replace['<!--TB_WFR-->']	= '<a href="'.SITEURL.'profile/with:friends">';
		$replace['<!--/TB_WFR-->']	= '</a>';
		$replace['<!--TB_IFM-->']	= '<a href="'.SITEURL.'profile/if:mentioned">';
		$replace['<!--/TB_IFM-->']	= '</a>';
		$replace['<!--TB_FAV-->']	= '<a href="'.SITEURL.'profile/only:fav">';
		$replace['<!--/TB_FAV-->']	= '</a>';
		$replace['<!--TB_DIR-->']	= '<a href="'.SITEURL.'profile/only:direct">';
		$replace['<!--/TB_DIR-->']	= '</a>';
		$replace2['/\<\!\-\-R_NICKNAME\-\-\>(.*)\<\!\-\-\/R_NICKNAME\-\-\>/']	= $this->user->info->username;
	}
	else {
		$replace['<!--REGLINK-->']	= '<a href="'.SITEURL.'register">';
		$replace['<!--/REGLINK-->']	= '</a>';
	}
	if( count($replace) > 0 ) {
		$FAQ	= str_replace( array_keys($replace), array_values($replace), $FAQ );
		$FAQ	= preg_replace( array_keys($replace2), array_values($replace2), $FAQ );
	}
	

	$html	.= '
					<div class="whitepage">
						<div id="faqpage">';
	$html	.= $FAQ;
	$html	.= '
						</div>
					</div>';
	
?>