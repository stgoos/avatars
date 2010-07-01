<?php
/*
Plugin Name: Avatars (Comments)
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 3.4.0
Author URI: http://incsub.com
*/

/* 
Copyright 2007-2009 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/*
<?php avatar_display_comments(get_comment_author_email(),'48',''); ?>
*/
//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function avatar_display_comments($tmp_user_email, $tmp_size='32', $tmp_depricated=''){
	global $wpdb, $current_site;
	if ( !get_option('show_avatars') )
		return false;

	if ( avatar_email_exists($tmp_user_email) ) {
		//local user
		$tmp_user_ID = $wpdb->get_var("SELECT ID FROM " . $wpdb->base_prefix . "users WHERE user_email = '" . $tmp_user_email . "'");
		$tmp_blog_ID = get_usermeta( $tmp_user_ID, "primary_blog" );
		if ($tmp_blog_ID != '') {
			$tmp_blog_domain = $wpdb->get_var("SELECT domain FROM " . $wpdb->base_prefix . "blogs WHERE blog_id = '" . $tmp_blog_ID . "'");
			$tmp_blog_path = $wpdb->get_var("SELECT path FROM " . $wpdb->base_prefix . "blogs WHERE blog_id = '" . $tmp_blog_ID . "'");
		}
		if ($tmp_blog_ID != ''){
			echo '<a href="http://' . $tmp_blog_domain . $tmp_blog_path . '" style="text-decoration:none">' . get_avatar( $tmp_user_email, $tmp_size, get_option('avatar_default') ) . '</a>';
		} else {
			//no primary blog definued
			echo get_avatar( $tmp_user_email, $tmp_size, get_option('avatar_default') );
		}
	} else {
		//not a local user - just grab a gravatar
		echo get_avatar( $tmp_user_email, $tmp_size, get_option('avatar_default') );
	}
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

?>