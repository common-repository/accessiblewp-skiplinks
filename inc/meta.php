<?php

/**
 * Adds a meta box to all post types
 */
function acwp_skiplinks_metabox() {
	$hide_meta = sanitize_text_field( get_option('acwp_skiplinks_nometa') );
	
	if( $hide_meta != 'yes' ){
		add_meta_box( 
	    	'acwp_skiplinks_meta', 
	    	__( 'Skiplinks', 'accessiblewp-skiplinks' ), 
	    	'acwp_meta_panel',
	    	get_post_types( array('public' => true) )
	    );
	}
}
add_action( 'add_meta_boxes', 'acwp_skiplinks_metabox' );

/**
 * Meta box callback
 */
function acwp_meta_panel($post) {
	$skiplinks_meta = get_post_meta($post->ID, 'acwp_skiplinks', true);
	wp_nonce_field( 'accessiblewp-skiplinks', 'skiplinks' );
	?>
<script type="text/javascript">
var row;
function acwp_skiplinks_start(){
  row = event.target.parentNode;
}
function acwp_skiplinks_dragover(){
	var e = event;
	e.preventDefault();
	
	let children = Array.from( e.target.parentNode.parentNode.children );
	if( 
		children.indexOf( e.target.parentNode.parentNode ) > children.indexOf( row ) )
		e.target.parentNode.after(row);
	else
		e.target.parentNode.before(row);
}

jQuery(document).ready(function( $ ){
	$( '#add-row' ).on('click', function() {
		var row = $( '.empty-row.custom-repeter-text' ).clone(true);
		row.removeClass( 'empty-row custom-repeter-text' ).css('display','table-row');
		row.insertBefore( '#acwp-skiplinks-fieldset tbody>tr:last' );
		return false;
	});

	$( '.remove-row' ).on('click', function() {
		$(this).parents('tr').remove();
		return false;
	});
});
</script>
<p><?php _e('The skiplinks allow the user to skip between page sections. In order to define unique skiplinks to this specific page, you need to set the ID of the section and a label.', 'accessiblewp-skiplinks');?></p>
<p><?php _e('For example:', 'accessiblewp-skiplinks');?></p>
<ul>
	<li><?php _e('Under "Section ID"', 'accessiblewp-skiplinks');?>: <b>section-420</b></li>
	<li><?php _e('Under "Skiplink Label"', 'accessiblewp-skiplinks');?>: <b><?php _e('Meet Our Team', 'accessiblewp-skiplinks'); ?></b></li>
</ul>
<table id="acwp-skiplinks-fieldset" width="100%">
	<thead>
		<tr>
			<th> </th>
			<th><?php _e('Section ID', 'accessiblewp-skiplinks'); ?></th>
			<th><?php _e('Skiplink Label', 'accessiblewp-skiplinks'); ?></th>
			<th> </th>
		</tr>
	</thead>
	<tbody>
		<?php if ( $skiplinks_meta ) : ?>
		<?php foreach ( $skiplinks_meta as $field ) : ?>
		<tr>
			<td draggable='true' ondragstart='acwp_skiplinks_start()' ondragover='acwp_skiplinks_dragover()' aria-label="<?php _e('Drag this to reorder the skiplinks', 'accessiblewp-skiplinks');?>" style="cursor: pointer; display: flex;
justify-content: center;
align-items: center;
height: 21px;
padding-top: 10px;">
				<img src="<?php echo AWP_SKIPLINKS_DIR;?>/assets/icons/drag.svg" style="pointer-events:none;" alt="<?php _e('Drag Icon', 'accessiblewp-skiplinks');?>" />
			</td>
			<td><input type="text"  style="width:98%;" name="section_id[]" value="<?php if(esc_html($field['section_id']) != '') echo esc_html( $field['section_id'] ); ?>" placeholder="section-id" /></td>
			<td><input type="text"  style="width:98%;" name="label[]" value="<?php if (esc_html($field['label']) != '') echo esc_html( $field['label'] ); ?>" /></td>
			<td><a class="button remove-row" href="#1"><?php _e('Remove skiplink', 'accessiblewp-skiplinks');?></a></td>
		</tr>
		<?php endforeach; ?>
		<?php else : ?>
		<tr>
			<td><input type="text" style="width:98%;" name="section_id[]" placeholder="section-id"/></td>
			<td><input type="text" style="width:98%;" name="label[]" value="" /></td>
			<td><a class="button  cmb-remove-row-button button-disabled" href="#"><?php _e('Remove skiplink', 'accessiblewp-skiplinks');?></a></td>
		</tr>
		<?php endif; ?>
		<tr class="empty-row custom-repeter-text" style="display: none">
			<td><input type="text" style="width:98%;" name="section_id[]" placeholder="section-id"/></td>
			<td><input type="text" style="width:98%;" name="label[]" value="" /></td>
			<td><a class="button remove-row" href="#"><?php _e('Remove skiplink', 'accessiblewp-skiplinks');?></a></td>
		</tr>
			
	</tbody>
</table>
<p><a id="add-row" class="button" href="#"><?php _e('Add another skiplink', 'accessiblewp-skiplinks');?></a></p>
<?php
}

// Save Meta Box values.
function acwp_skiplinks_single_skiplinks_meta_box_save($post_id) {

	if (!isset($_POST['skiplinks']) && !wp_verify_nonce($_POST['skiplinks'], 'accessiblewp-skiplinks'))
		return;

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;

	if (!current_user_can('edit_post', $post_id))
		return;

	$old = get_post_meta($post_id, 'acwp_skiplinks', true);

	$new = array();
	$titles = sanitize_text_field($_POST['section_id']);
	$tdescs = sanitize_text_field($_POST['label']);
	$count = count( $titles );
	for ( $i = 0; $i < $count; $i++ ) {
		if ( $titles[$i] != '' ) {
			$new[$i]['section_id'] = stripslashes( strip_tags( $titles[$i] ) );
			$new[$i]['label'] = stripslashes( $tdescs[$i] );
		}
	}

	if ( !empty( $new ) && $new != $old ){
		update_post_meta( $post_id, 'acwp_skiplinks', $new );
	} elseif ( empty($new) && $old ) {
		delete_post_meta( $post_id, 'acwp_skiplinks', $old );
	}
}
add_action('save_post', 'acwp_skiplinks_single_skiplinks_meta_box_save');
