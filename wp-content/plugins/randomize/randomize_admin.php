<?php

$undefinederror = __( 'An undefined error has occured. ', 'randomize' );
$errorpagetitle = __( ' - Error', 'randomize' );

$randomize_adminurl = admin_url().'options-general.php?page=randomize';

add_action('admin_menu', 'randomize_menu');

function randomize_menu() {
  add_options_page('Randomize', 'Randomize', 'update_plugins', 'randomize', 'randomize_options');
}

// Add settings link on plugin page
function randomize_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=randomize">'.__( 'Settings', 'randomize' ).'</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
add_filter("plugin_action_links_$plugin_basename", 'randomize_settings_link' );


function randomize_options() {
	if($_POST) {
		// process the posted data and display summary page - not pretty :(
		randomize_save($_POST);
	}

	$action = isset($_GET['action']) ? $_GET['action'] : false;
	switch($action){
		case 'new' :
			randomize_edit();
			break;
		case 'edit' :
			$id = intval($_GET['id']);
			randomize_edit($id);
			break;
		case 'delete' :
			$id = intval($_GET['id']);
			check_admin_referer('randomize_delete'.$id);
			randomize_delete($id);
			// now display summary page
			randomize_list();
			break;
		default:
			randomize_list();
	}
}

function randomize_pagetitle($suffix='') {
 return '
 <div id="icon-options-general" class="icon32"><br/></div><h2>Randomize '.$suffix.'</h2>
 ';
}

function randomize_error($undefinederror) {
	echo '<div class="wrap">'.$errorpagetitle.'<h3>'.$text.'</h3></div>';
}
 
function randomize_list() {
	global $wpdb, $user_ID, $randomize_adminurl;
	$table_name = $wpdb->prefix . 'randomize';
	$pageURL = $randomize_adminurl;
	$cat = isset($_GET['cat']) ? $_GET['cat'] : false;
	$author_id = isset($_GET['author_id']) ? intval($_GET['author_id']) : 0;
	$where = $page_params = '';

	if($cat) {
		$where = " WHERE category = '$cat'";
		$page_params = '&cat='.urlencode($cat);
	}
	if($author_id) {
		$where = " WHERE user_id = $author_id";
		$page_params .= '&author_id='.$author_id;
	}
	
	// pagination related

	$item_count = $wpdb->get_row("Select count(*) items FROM $table_name $where");
	if(isset($item_count->items)) {
		$totalrows = 	$item_count->items;
	} else {
		echo '<h3>'.__( 'Caution! The expected database table ', 'randomize' ) .'"<i>'.$table_name.'</i>"'.__( ' does\'t seem to exist', 'randomize' ).'</h3>';
	}
	
	$perpage = 20;
	$paged = isset($_GET['paged']) ? intval($_GET['paged']) : 0;
	$paged = $paged ? $paged : 1;

	$num_pages = 1+floor($totalrows/$perpage);

	if($paged > $num_pages) { $paged = $num_pages; }
	
	$del_paged = ($paged > 1) ? '&paged='.$paged : '';	 // so we stay on the current page if we delete an item
	
	$paging = paginate_links( array(
		'base' => $pageURL.$page_params.'%_%', // add_query_arg( 'paged', '%#%' ),
		'format' => '&paged=%#%',
		'prev_text' => __('Previous', 'randomize'),
		'next_text' => __('Next', 'randomize'),
		'total' => $num_pages,
		'current' => $paged
		));
	
	// now load the data to display

	$startrow = ($paged-1)*$perpage;	
	$rows = $wpdb->get_results("SELECT * FROM $table_name $where ORDER BY randomize_id LIMIT $startrow, $perpage");
	$item_range = count($rows);
	if($item_range>1) {
		$item_range = ($startrow+1).' - '.($startrow+$item_range);
	}
	
	$author = array();

	?>
<div class="wrap">
	<?php echo randomize_pagetitle(); ?>
	<div class="tablenav">
		<div class="alignleft actions">
			<input type="submit" class="button-primary action" id="randomize_add" name="randomize_add" value="+" onclick="location.href='options-general.php?page=randomize&action=new'"/>
			<?php __( 'Category', 'randomize' ); ?><select id="randomize_category" name="randomize_category" onchange="javascript:window.location='<?php echo $pageURL.'&cat='; ?>'+(this.options[this.selectedIndex].value);">
			<option value=""><?php __( 'View all categories', 'randomize' ); ?></option>
			<?php echo randomize_get_category_options($cat); ?>
			</select>
		</div>
		<div class="tablenav-pages">
			<span class="displaying-num"><?php __( 'Displaying ', 'randomize' ); ?> <?php echo $item_range.' of '.$totalrows; ?></span>
			<?php echo $paging; ?>
		</div>
	</div>

	<table class="widefat">
	<thead><tr>
		<th width="5%"><?php _e( '#', 'randomize' ); ?></th>
		<th width="60%"><?php _e( 'Text', 'randomize' ); ?></th>
		<th width="10%"><?php _e( 'Category', 'randomize' ); ?></th>
		<th width="10%"><?php _e( 'Author', 'randomize' ); ?></th>
		<th width="15%"><?php _e( 'Action', 'randomize' ); ?></th>
	</tr></thead>
	<tbody>
<?php		
	$alt = '';
	foreach($rows as $row) {
		$alt = ($alt) ? '' : ' class="alternate"';
		if(!isset($author[$row->user_id])){
			$user_info = get_userdata($row->user_id);
			$author[$row->user_id] = $user_info->display_name;
		}
		$status = ($row->visible=='yes') ? __( 'visible', 'randomize' ) : __( 'hidden', 'randomize' );
		$bytes = strlen($row->text);
		if(strlen($row->text) > 200)
			$row->text = trim(mb_substr($row->text,0,350,'UTF-8')).'...';
		echo '<tr'.$alt.'>
		<td>'.$row->randomize_id.'</td>
		<td>'.esc_html($row->text).'</td>
		<td><a href="'.$pageURL.'&cat='.$row->category.'">'.$row->category.'</a><br />'.$status.'</td>
		<td class="author column-author"><a href="'.$pageURL.'&author_id='.$row->user_id.'">'.$author[$row->user_id].'</a><br />'.$bytes.' bytes</td>
		<td><a href="'.$pageURL.'&action=edit&id='.$row->randomize_id.'">'.__('Edit','randomize').'</a><br />';
		$del_link = wp_nonce_url($pageURL.$del_paged.'&action=delete&id='.$row->randomize_id, 'randomize_delete' . $row->randomize_id);
		echo '<a href="'.$del_link.'" class="submitdelete">'.__('Delete', 'randomize').'</a>';
		echo '</td></tr>';		
	}
	echo '</tbody></table>';
	echo '<p>'.__('You like this plugin?','randomize').' <a href="https://paypal.me/seschwarz" target="_blank">'.__('I\'m happy about your donation.','randomize').'</a> '.__('redirects you to PayPal','randomize').'</p>';

  echo '</div>';
}

function randomize_edit($randomize_id=0) {
	
	echo '<div class="wrap">';
	$title = __( ' - Add new', 'randomize' );
	if($randomize_id) {
		$title = '- Edit';
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'randomize';
		$sql = "SELECT * from $table_name where randomize_id=$randomize_id";
		$row = $wpdb->get_row($sql);
		if(!$row)
			$error_text = '<h2>'.__( 'The requested entry was not found.', 'randomize' ).'</h2>';
	} else {
		$row = new stdClass();
		$row->text = '';
		$row->visible = __( 'Yes', 'randomize' );
	}
	echo randomize_pagetitle($title); 
	
	if($randomize_id && !$row) {
		echo '<h3>'.__( 'The requested entry was not found', 'randomize' ).'</h3>';
	} else {
	// display the add/edit form 
	global $randomize_adminurl;
	
	echo '<form method="post" action="'.$randomize_adminurl.'">
		'.wp_nonce_field('randomize_edit' . $randomize_id).'
		<input type="hidden" id="randomize_id" name="randomize_id" value="'.$randomize_id.'">
		<h3>'.__( 'Content to display: ', 'randomize' ).'</h3>
		<textarea name="randomize_text" style="width: 99%; height: 300px;">'.apply_filters('format_to_edit',$row->text).'</textarea><p><small>'.__( 'You can enter text or HTML tags to embed pictures, videos and much more.', 'randomize' ).'</small></p>
		<h3>'.__( 'Category', 'randomize' ).'</h3>
		<p>'.__( 'Select a category from the list or create a new one.', 'randomize' ).'</p>
		<label for="randomize_category">'.__( 'Category: ', 'randomize' ).'</label><select id="randomize_category" name="randomize_category">'; 
	echo randomize_get_category_options($row->category);
	echo '</select></p>
		<p><label for="randomize_category_new">'.__( 'New Category', 'randomize' ).'</label><input type="text" id="randomize_category_new" name="randomize_category_new"></p>';
		
		echo '<h3>'.__( 'Visibility', 'randomize' ).'</h3>
			<p><label for="randomize_visible_yes"><input type="radio" id="randomize_visible_yes" name="randomize_visible" value="yes" '.checked($row->visible,'yes',false).' />'.__( 'Public ', 'randomize' ).'</label><br /> 
			<label for="randomize_visible_no"><input type="radio" id="randomize_visible_no" name="randomize_visible" value="no" '.checked($row->visible,'no',false).' />'.__( 'Private', 'randomize' ).'</label></p>';
		if(!$randomize_id) {
			// don't offer Bulk Insert on edit
			echo '<h3>'.__( 'Type of import', 'randomize' ).'</h3>
			<p><input type="radio" name="randomize_bulkinsert" value="yes" />'.__( 'Bulk import for multiple items', 'randomize' ).'<br /><input type="radio" name="randomize_bulkinsert" value="no" checked="checked" />'.__( 'Just a single item', 'randomize' ).'</p><small>'.__( 'Bulk insert will create a new record for each line (delimited by carriage return) within the text box above using the same category selected.<br />Empty lines will be ignored.', 'randomize' ).'
			</small>';
		}
		echo '<div class="submit">
			<input class="button-primary" type="submit" name="randomize_Save" value="'.__( 'Save changes', 'randomize' ).'" />
			</div>
			</form>
			
			<p>'.__('Return to ','randomize').'<a href="'.$randomize_adminurl.'">'.__( 'Summary page', 'randomize' ).'</a>.</p>';
	}
  echo '</div>';	
}

function randomize_save($data) {
	global $wpdb, $user_ID;
	$table_name = $wpdb->prefix . 'randomize';
	
	$randomize_id = intval($data['randomize_id']);
	check_admin_referer('randomize_edit'.$randomize_id);
	
	$sqldata = array();
	$category_new = trim($data['randomize_category_new']);
	$sqldata['category'] = ($category_new) ? $category_new : $data['randomize_category'];
	$sqldata['user_id'] = $user_ID;
	$sqldata['visible'] = $data['randomize_visible'];
	
	// check for "Bulk Insert"
	$do_bulkinsert = isset($data['randomize_bulkinsert']) ? $data['randomize_bulkinsert'] : 'no';
	if ($do_bulkinsert == 'yes') {
		// Split the data by carriage returns
		$lines = preg_split("/[\n|\r]/", trim(stripslashes($data['randomize_text'])));
		foreach ($lines as $key=>$value) {
			// Ignore empty lines
			if (!empty($value)) {
				// Set the datavalue and insert
				$sqldata['text'] = $value;
				$wpdb->insert($table_name, $sqldata);
			}
		}
	} else {
		// single record insert/update
		$sqldata['text'] = trim(stripslashes($data['randomize_text']));
		if($randomize_id)
			$wpdb->update($table_name, $sqldata, array('randomize_id'=>$randomize_id));
		else
			$wpdb->insert($table_name, $sqldata);
	}

}

function randomize_delete($id) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'randomize';
	$id = intval($id);
	$sql = "DELETE FROM $table_name WHERE randomize_id = $id";
	$wpdb->query($sql);
}


?>