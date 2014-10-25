<?php
/**
 * Email HTML template for emails
 * sent through contact form on
 * contact page template
 *
 * @since 1.2
 */

// Get contact fields
$contact_fields = wpsight_contact_fields();

// Get contact labels
$contact_labels = wpsight_contact_labels(); ?>

<html>

	<head>
		<style type="text/css">	
			html, body{ width: 100% !important; margin-top: 0px !important; padding-top: 0px !important; }	
			body{ margin-top: 0px !important; padding-top: 0px !important; font-family:sans-serif; }	
			table{ margin-top: 0px !important; padding-top: 0px !important; }	
			td{ padding: 5px 0; vertical-align: top;}
        	a, img{ outline: none !important; border: none !important;}
        	img{ margin: 5px 0;}
        	h3,
        	#logo-text a { font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom: 15px; color:#ddd; font-weight:500; font-size: 27px; }
        	#logo-text a { color: #aaa; text-decoration: none; font-size: 48px; letter-spacing: -1px; }
		</style>	
	<head>
	
	<body style="margin: 0; padding: 0;">
	
		<table width="100%" style="background-color:#f4f4f4">
		
			<tr>
			    <td height="40"></td>
			</tr>
								
			<tr>
			    <td align="center">
			    	<div style="padding-left:5%; padding-right:5%; color:#aaa;">
			    		<?php do_action( 'wpsight_logo', 'email' ); ?>
			    	</div>
			    </td>
			</tr>
			
			<tr>
			    <td height="30"></td>
			</tr>

			<tr>
			
				<td align="center">

					<div style="width:90%; margin: 0 5%;">
					
						<div style="padding:50px; padding-top:40px; background-color:#FFFFFF; border:1px solid #DDDDDD; font-size: 14px;">
					
							<table border="0" width="100%">
							
								<tr>
									<td style="text-transform:uppercase; vertical-align:bottom; border-bottom: 1px solid #eeeeee;" colspan="2">
										<h3><?php _e( 'Contact', 'wpsight' ); ?></h3>
									</td>
								</tr>
								
								<tr>
									<td style="height:30px" colspan="2"></td>
								</tr><?php
							
								foreach( $contact_fields as $field => $v ) {
								
									if( empty( $v['id'] ) || $v['id'] == 'favorites' || ( $v['type'] == 'hidden' && $v['placeholder'] == false ) )
										continue; ?>
								
									<tr>
										<td style="width: 25%; color: #333; font-size: 14px;"><strong><?php echo $v['label_email']; ?>:</strong></td>
										<td style="width: 75%; color: #333; font-size: 14px;">[<?php echo $v['id']; ?>]</td>
									</tr><?php
								
								} ?>

							</table>
					
						</div>
					
					</div>
				
				</td>			
			
			</tr>
			
			<tr>
			    <td height="30"></td>
			</tr>
			
			<tr>
			    <td align="center">
			    	<div style="padding-left:5%; padding-right:5%; color:#aaa; font-size:12px">
			    		<?php printf( __( 'This email was sent through the contact form on <a href="%1$s">%2$s</a>', 'wpsight' ), home_url(), get_bloginfo( 'name' ) ); ?>
			    	</div>
			    </td>
			</tr>
			
			<tr>
			    <td height="60"></td>
			</tr>
		
		</table>

	</body>

</html>