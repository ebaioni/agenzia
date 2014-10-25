<?php

/*
Plugin Name: Rms User Metadata
Version: 0.1
Author: Rameshwor Maharjan
Description: Additional User Metadata
URL: flicknepal.com
*/

if ( ! class_exists( 'RmsUser' ) ) :
 
class RmsUser
{ 
 
	function RmsUser()
	{
 
		add_action( 'show_user_profile', array( &$this,'my_show_extra_profile_fields' ) );
		add_action( 'edit_user_profile', array( &$this,'my_show_extra_profile_fields' ) );
		add_action( 'personal_options_update', array( &$this,'my_save_extra_profile_fields' ) );
		add_action( 'edit_user_profile_update', array( &$this,'my_save_extra_profile_fields' ) );
 
	}
	
	function get_author_profile_image( $user_ID )
	{
	 
		$author_data = get_the_author_meta( 'profile_image' , $user_ID );
		$uploads = wp_upload_dir();
		if( isset( $author_data["file"] ) )
			$author_data["file"] = $uploads["baseurl"] . $author_data["file"];
		return $author_data;
	} 
 
	function my_show_extra_profile_fields( $user ) { ?>
 
		<script type="text/javascript">
			var form = document.getElementById('your-profile');
			form.encoding = "multipart/form-data";
			form.setAttribute('enctype', 'multipart/form-data');
		</script>
		
		<table class="form-table">
		
		    <tr>
		    	<th><label for="profile_image"><?php _e( 'Profile Image', 'wpsight' ); ?></label></th>
		
		    	<td>
		    		<?php
		    		$author_profile_image = $this->get_author_profile_image( $user->ID );
		    		if( is_array( $author_profile_image ) ) :
		    		?>
		    		<p><span class="description">
		    		<img src="<?php echo $author_profile_image["file"];?>" />
		    		</span></p>
		    		<p><label><input type="checkbox" name="remove_image" id="remove_image" style="margin-right:5px" /><?php _e( 'Remove image', 'wpsight' ); ?></label></p>
		    		<?php
		    		endif;
		    		?>
		    		<p><input type="file" name="profile_image" id="profile_image" class="regular-text" /></p>
		    	</td>
		    </tr>
		    
		</table>
 
	<?php } 
 
	function my_save_extra_profile_fields( $user_id ) {
 
		if ( ! current_user_can( 'edit_user', $user_id ) )
			return false;
 
		$upload = $_FILES['profile_image'];
		$uploads = wp_upload_dir();
		if ( $upload['tmp_name'] && file_is_displayable_image( $upload['tmp_name'] ) )
		{ 
			// handle the uploaded file
			$overrides = array( 'test_form' => false );
			$file = wp_handle_upload( $upload, $overrides );
			$file["file"] = $uploads["subdir"] . "/" . basename( $file["url"] );
			
			if ( $file )
			{			
			    //remove previous uploaded file
			    $author_profile_image = $this->get_author_profile_image( $user_id );
			    @unlink( $author_profile_image["file"] );			
			    update_user_meta( $user_id, 'profile_image', $file ); 			
			}
 		}
		
		if ( isset( $_POST['remove_image'] ) )
		{		
		    $author_profile_image = $this->get_author_profile_image( $user_id );
		    @unlink( $author_profile_image["file"] );
		    update_user_meta( $user_id, 'profile_image', false );
		}
	}
}
 
	if ( class_exists('RmsUser') ) :
		$RmsUser = new RmsUser();
	endif;
	
endif;