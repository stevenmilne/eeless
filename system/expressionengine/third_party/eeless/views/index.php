<?php
ini_set('safe_mode',1);	
ini_set('safe_mode_gid',1);

$eeless_html_output = '';
$eeless_html_output .= '<p>'.lang('eeless_introduction').'<p>';
 
// Check to see if we have entries in the table	
if(count($eelesss) > 0) :
	// Set the look and feel of the table
	$this->table->set_template($cp_table_template);
	 
	// Set up of table header columns and data
	
	$eeless_label_heading = array('data' => 'Field','align' => 'left','width' => '30%');
	$eeless_value_heading = array('data' => 'Value','align' => 'left','width' => '70%');
	
	$eeless_less_serverpath_cell_heading = array('data' => lang('eeless_less_serverpath'),'align' => 'left','width' => '30%');
	$eeless_less_browserpath_cell_heading = array('data' => lang('eeless_less_browserpath'),'align' => 'left','width' => '30%');
	$eeless_css_serverpath_cell_heading = array('data' => lang('eeless_css_serverpath'),'align' => 'left','width' => '30%');
	$eeless_css_browserpath_cell_heading = array('data' => lang('eeless_css_browserpath'),'align' => 'left','width' => '30%');
	$eeless_edit_link_cell_heading = array('data' => lang('eeless_css_edit_link'),'align' => 'left','width' => '30%');
	
 	$this->table->set_heading($eeless_label_heading,$eeless_value_heading);

	/* tidy this up later - inelegant  */
	foreach($eelesss as $eeless) : 
	
		$eeless_less_serverpath_val = array('data' => $eeless['less_serverpath'],'align' => 'left','width' => '30%');
		$eeless_less_browserpath_val = array('data' => $eeless['less_browserpath'],'align' => 'left','width' => '30%');
		$eeless_css_serverpath_val = array('data' => $eeless['css_serverpath'],'align' => 'left','width' => '30%');
		$eeless_css_browserpath_val = array('data' => $eeless['css_browserpath'],'align' => 'left','width' => '30%');
		$eeless_edit_link_val = array('data' => '<a href="'.$eeless['edit_link'].'">EDIT</a>','align' => 'left','width' => '30%');
		 
		$this->table->add_row($eeless_less_serverpath_cell_heading,		$eeless_less_serverpath_val);
		$this->table->add_row($eeless_less_browserpath_cell_heading,	$eeless_less_browserpath_val);
		$this->table->add_row($eeless_css_serverpath_cell_heading,		$eeless_css_serverpath_val);
		$this->table->add_row($eeless_css_browserpath_cell_heading,		$eeless_css_browserpath_val);
		$this->table->add_row($eeless_edit_link_cell_heading,		$eeless_edit_link_val);
		
	endforeach;
	
	// Customise the Delete button.
	$eeless_submit_button = array(
    	'name' => 'submit',
    	'id' => 'submit',
    	'value' => lang('eeless_delete'),
    	'type' => 'submit',
    	'class' => 'submit'
	);
	
	// Adds the name attribute to the form
	$eeless_form_attributes = array('name' => 'eeless_form');
 	
	$eeless_html_output .= '<h3>'.lang('eeless_index_header').'</h3>';
	
	$eeless_html_output  .=  lang('eeless_index_howto') ;
	
	$eeless_html_output .= form_open($action_url,$eeless_form_attributes);
	
	$eeless_html_output .= $this->table->generate();
	
	$eeless_html_output .= '<div class="tableFooter">';
	
	if(count($eelesss) == 1  ) :
		$eeless_html_output .= '	<div class="tableSubmit">&nbsp;</div>';
	else :	
		$eeless_html_output .= '	<div class="tableSubmit">'.form_submit($eeless_submit_button).'</div>';
	endif;
	
 
	 
	
	$eeless_html_output .= '</div>';	
	
	$eeless_html_output .= form_close();
else :
 
endif; 

echo $eeless_html_output;

// Clean up
unset($eeless_html_output,$eeless_form_attributes,$eeless_submit_button,$eelesss,$action_url,$form_hidden,$eeless_comments_cell,$eeless_checkbox_cell);
?>