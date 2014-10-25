<?php
/**
 * The default template for displaying author content
 *
 * @package wpSight
 * @since 1.1
 */
 
/**
 * Check if author archive
 * and set $agent_id accordingly
 */
 
if( is_author() ) {
	$agent_id = false;
} elseif( is_singular() && get_post_type() == wpsight_listing_post_type() ) {
	$agent_id = get_the_author_meta( 'ID' );
} else {
	global $agent_id;
}
 
$args = array(
    'title'  => get_the_author(),
    'image'  => array(
    	'show' 	 => true,
    	'align'  => 'left',
    	'linked' => true
    ),
    'bio' 	 => true,
    'email'  => array(
    	'show' 	 => true,
    	'icon' 	 => '<i class="icon-envelope"></i> ',
    	'linked' => true
    ),
    'url' 	 => array(
    	'show' 	 => true,
    	'icon' 	 => '<i class="icon-external-link"></i> ',
    	'linked' => true
    ),
    'custom' => array(
    	'fields' => wpsight_profile_contact_fields(),
    	'icon' 	 => true,
    	'linked' => true
    ),
    'button' => true
);

$args = apply_filters( 'wpsight_listing_agent_info_args', $args );

// Extract $args
extract( $args, EXTR_SKIP );

// Create listing agent info

$listing_agent = '<div class="listing-agent author-info clearfix">';

if( $title && ! is_singular() ) {

    $listing_agent .= '<div class="title title-author clearfix">';
    $listing_agent .= '<h2>' . $title . '</h2>';
    $listing_agent .= '</div><!-- .title -->';

}			
    
// Get profile image or avatar

if( $image['show'] == true ) {

    $author_image = get_the_author_meta( 'profile_image', $agent_id );
    				
    if( ! empty( $author_image ) ) {					
    	$agent_image = '<img src="' . $author_image['url'] . '" class="avatar avatar-align-' . $image['align'] . '" />';
    } else {						
    	$agent_image = '<span class="avatar-align-' . $image['align'] . '">' . get_avatar( get_the_author_meta( 'email', $agent_id ), '80' ) . '</span>';
    }
    
    if( ! is_author() )
    	$listing_agent .= '<a href="' . get_author_posts_url( $agent_id ) . '" title="' . __( 'See my listings', 'wpsight' ) . '">';
    
    $listing_agent .= $agent_image;
    
    if( ! is_author() )
    	$listing_agent .= '</a>';

}

// Put text next to image in extra div

$listing_agent .= '<div class="listing-agent-info">';

// Display agent name on agent list
if( ! is_author() && ( is_singular() && get_post_type() != wpsight_listing_post_type() ) )
    $listing_agent .= '<h2>' . get_the_author_meta( 'display_name', $agent_id ) . '</h2>';

// Get profile description/bio

if( $bio == true ) {

    $listing_agent .= '<div class="listing-agent-bio">';
    
    $listing_agent .= apply_filters( 'the_content' , get_the_author_meta( 'description', $agent_id ) );
    $listing_agent .= '</div><!-- .listing-agent-bio -->';

}

// Get profile contact email

if( $email['show'] == true ) {

    $agent_email = get_the_author_meta( 'email', $agent_id );
    
    if( ! empty( $agent_email ) ) {

    	$listing_agent .= '<div class="listing-agent-email">';
    	
    	if( ! empty( $email['icon'] ) )
    		$listing_agent .= $email['icon'];
    		
    	$listing_agent .= '<strong>' . __( 'Email', 'wpsight' ) . ':</strong> ';
    	
    	if( $email['linked'] == true )
    		$listing_agent .= '<a href="mailto:' . antispambot( $agent_email ) . '">';
    		
    	$listing_agent .= antispambot( $agent_email );
    	
    	if( $email['linked'] == true )
    		$listing_agent .= '</a>';
    		
    	$listing_agent .= '</div><!-- .listing-agent-email -->';
    
    }

}

// Get profile contact website

if( $url['show'] == true ) {

    $agent_url = get_the_author_meta( 'url', $agent_id );
    
    if( ! empty( $agent_url ) ) {

    	$listing_agent .= '<div class="listing-agent-url">';
    	
    	if( ! empty( $url['icon'] ) )
    		$listing_agent .= $url['icon'];
    		
    	$listing_agent .= '<strong>' . __( 'Website', 'wpsight' ) . ':</strong> ';
    	
    	if( $url['linked'] == true )
    		$listing_agent .= '<a href="' . $agent_url . '" target="_blank">';
    		
    	$listing_agent .= $agent_url;
    	
    	if( $email['linked'] == true )
    		$listing_agent .= '</a>';
    		
    	$listing_agent .= '</div><!-- .listing-agent-url -->';
    
    }

}

// Get profile contact custom fields

foreach( $custom['fields'] as $k => $v ) {

    $agent_meta = get_the_author_meta( $k, $agent_id );

    if( ! empty( $agent_meta ) ) {

    	$listing_agent .= '<div class="listing-agent-' . $k . '">';
    	
    	if( ! empty( $v['icon'] ) )
    		$listing_agent .= $v['icon'];
    		
    	$listing_agent .= '<strong>' . $v['label'] . ':</strong> ';
    	
    	if( $custom['linked'] == true && $v['url'] != false )
    		$listing_agent .= '<a href="' . $v['url'] . $agent_meta . '" target="_blank">';
    		
    	$listing_agent .= $agent_meta;
    		
    	if( $custom['linked'] == true && $v['url'] != false )
    		$listing_agent .= '</a>';
    	
    	$listing_agent .= '</div><!-- .listing-agent-' . $k . ' -->';
    
    }

}

// Create author archive button

if( $button == true && ! is_author() ) {

    $listing_agent .= '<a href="' . get_author_posts_url( $agent_id ) . '" class="' . apply_filters( 'wpsight_button_class_agent', 'btn' ) . '">';
    $listing_agent .= __( 'See my listings', 'wpsight' );
    $listing_agent .= '</a>';

}

// Put text next to image in extra div

$listing_agent .= '</div><!-- .listing-agent-info -->';

// Create listing agent info

$listing_agent .= '</div><!-- .listing-agent -->';

// Filter and output

echo apply_filters( 'wpsight_listing_agent_info', $listing_agent );
