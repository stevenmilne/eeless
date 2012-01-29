<?php 
// Customise the Edit button.
$eeless_submit_button = array(
	'name' => 'submit',
	'id' => 'submit',
	'value' => lang('eeless_edit'),
	'type' => 'submit',
	'class' => 'submit'
);

// Customise the labels, input and textarea fields

 
$eeless_less_serverpath_label = array(); 

$eeless_less_serverpath_input = array(
	'name' => 'less_serverpath',
	'id' => 'less_serverpath',
	'value' => $eeless_less_serverpath,
	'maxlength' => '200',
	'size' => '60',
	'style' => ''
);



$eeless_less_browserpath_label = array(); 

$eeless_less_browserpath_input = array(
	'name' => 'less_browserpath',
	'id' => 'less_browserpath',
	'value' => $eeless_less_browserpath,
	'maxlength' => '200',
	'size' => '60',
	'style' => ''
);



$eeless_css_serverpath_label = array(); 

$eeless_css_serverpath_input = array(
	'name' => 'css_serverpath',
	'id' => 'css_serverpath',
	'value' => $eeless_css_serverpath,
	'maxlength' => '200',
	'size' => '60',
	'style' => ''
);



$eeless_css_browserpath_label = array(); 

$eeless_css_browserpath_input = array(
	'name' => 'css_browserpath',
	'id' => 'css_browserpath',
	'value' => $eeless_css_browserpath,
	'maxlength' => '200',
	'size' => '60',
	'style' => ''
);
 
// Adds the name attribute to the form
$eeless_form_attributes = array('name' => 'eeless_form');

$eeless_html_output = '';

$eeless_html_output .= '<p>Configure the location of your LESS files, and your CSS output files. Ensure that the CSS folderpath is writable (666).</p>';

$eeless_html_output .= form_open($action_url,$eeless_form_attributes);

$eeless_html_output .= form_hidden('eeless_id',$eeless_id);

$eeless_html_output .= '<p>'.form_label('LESS Folder Path','less_serverpath',$eeless_less_serverpath_label).'<br>'.form_input($eeless_less_serverpath_input).'</p>';
$eeless_html_output .= '<p>'.form_label('LESS Folder URL','less_browserpath',$eeless_less_browserpath_label).'<br>'.form_input($eeless_less_browserpath_input).'</p>';
$eeless_html_output .= '<p>'.form_label('CSS Folder Path','css_serverpath',$eeless_css_serverpath_label).'<br>'.form_input($eeless_css_serverpath_input).'</p>';
$eeless_html_output .= '<p>'.form_label('CSS Folder URL','css_browserpath',$eeless_css_browserpath_label).'<br>'.form_input($eeless_css_browserpath_input).'</p>';
 

$eeless_html_output .= form_submit($eeless_submit_button);

$eeless_html_output .= form_close();

echo $eeless_html_output;

// Clean up
unset($eeless_id,$eeless_ip_address,$eeless_comments,$eeless_html_output,$action_url,$eeless_submit_button,$eeless_comments_label,$eeless_comments_textarea,$eeless_form_attributes);
?>