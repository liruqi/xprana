<?php

$html	= '';

if( $this->user->is_logged )
{
	$W	= get_user_watches($this->user->id);
	$html	.= '
		<hr/>
		<div id="ftrnav">
			<a href="'.SITEURL.$this->user->info->username.'/only:direct" accesskey="3">3.&nbsp;<b>'.$this->lang('MOBI_nav_dir').'</b></a>
			<a href="'.SITEURL.$this->user->info->username.'/if:mentioned" accesskey="4">4.&nbsp;@<b>'.$this->user->info->username.'</b></a>
			<a href="'.SITEURL.$this->user->info->username.'/watched/type:in" accesskey="5">5.&nbsp;<b>'.$this->lang('MOBI_nav_fol1').'</b>&nbsp;('.count($W->i_watch).')</a>
			<a href="'.SITEURL.$this->user->info->username.'/watched/type:out" accesskey="6">6.&nbsp;<b>'.$this->lang('MOBI_nav_fol2').'</b>&nbsp;('.count($W->watch_me).')</a>
			<a href="'.SITEURL.'all" accesskey="7">7.&nbsp;<b>'.$this->lang('MOBI_nav_all').'</b></a>
		</div>';
}

$html	.= '
		<hr />
		<div id="ftr">
			&copy; blurt.it
			'.($this->user->is_logged ? '&middot; <a href="'.SITEURL.'login/log:out">'.$this->lang('MOBI_logout').'</a>' : '').'
		</div>	
	</body>
</html>';

?>