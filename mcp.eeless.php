<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * eeless - Control Panel Class
 *
 * The Control Panel master class that handles all of the CP Requests and Displaying
 *
 * @package: 		eeless
 * @author: 		Steven Milne <stevenmilne@gmail.com>
 * @copyright: 		Copyright (c) 2011 Steven Milne
 * @link:			http://stevenmilne.co.uk/
 * @version:		1.0
 * @filesource: 	./system/expressionengine/third_party/eeless/mcp.eeless.php
 */
include_once('functions/fcn.eeless.php');

class Eeless_mcp {
	private $eeless_base_url;
	private $eeless_form_url;
	private $eeless_return_data;
	private $eeless_per_page;
	private $eeless_vars;
	private $eeless_functions;
	private $EE;
	
	/**
     * Class Constructor
     *
     * @access public
     * @return null
     */
	public function __construct() {
		$this->EE =& get_instance();
		
		// Setting some global variables
		$this->eeless_per_page = 20;
		
		$this->eeless_base_url = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=eeless';

    	$this->eeless_form_url = 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=eeless';

    	$this->eeless_vars = array();
    	
		// Customise the module pages
    	$this->EE->cp->set_right_nav(
    		array(
        		'eeless_home' => $this->eeless_base_url
    		)
    	);	
		
		// Initialise and load functions list    	
    	$this->eeless_functions = new eeless_fcn();
    } /* END Constructor */
	
	
	
	
	
	
	/**
	 * Class Index page
	 * 
	 * First page users see - simply displays path settings atm
	 *
	 * @access public
     * @return array
	 */
	public function index() {
		// Load some libraries and helpers
		$this->EE->load->library('javascript');
		$this->EE->load->library('table');
		$this->EE->load->library('pagination');
		$this->EE->load->helper('form');
		 
		// Set the module page title
		$this->EE->cp->set_variable('cp_page_title',$this->EE->lang->line('eeless_module_name'));
		
		// Set the forms action URL
		$this->eeless_vars['action_url'] = $this->eeless_form_url;
		
		$this->eeless_vars['eelesss'] = array();
		
		// Get a head count of all the entries in the table
 		$eeless_total = $this->EE->db->count_all('eeless');

		// todo check this is 1 - as we should only have one root
		
		// Get all the entries in the table, build up variables array to pass over the View
		$this->EE->db->order_by('eeless_id','asc'); 
		
		$eeless_query = $this->EE->db->get('eeless',1,0);
		
		foreach($eeless_query->result_array() as $row) :
			$this->eeless_vars['eelesss'][$row['eeless_id']]['less_serverpath'] = $row['less_serverpath'];
			$this->eeless_vars['eelesss'][$row['eeless_id']]['less_browserpath'] = $row['less_browserpath'];
			$this->eeless_vars['eelesss'][$row['eeless_id']]['css_serverpath'] = $row['css_serverpath'];
			$this->eeless_vars['eelesss'][$row['eeless_id']]['css_browserpath'] = $row['css_browserpath'];
			$this->eeless_vars['eelesss'][$row['eeless_id']]['edit_link'] = $this->eeless_base_url.AMP.'method=edit'.AMP.'eeless_id='.$row['eeless_id'];	 
		endforeach;
	
		unset($eeless_total,$eeless_p_config,$eeless_query);
		 
		// Load modules main page
		return $this->eeless_return_data = $this->EE->load->view('index',$this->eeless_vars,true);
	} /* END index */
	
	
 
	/**
	 * Class Edit page
	 * 
	 * Page users see to edit the path values
	 *
	 * @access public
     * @return array	 
	 */
	public function edit() {
		// Load some libraries and helpers
		$this->EE->load->library('javascript');
		$this->EE->load->helper('form');
		
		// Customise the page title
		$this->EE->cp->set_variable('cp_page_title',$this->EE->lang->line('eeless_edit'));
		
		$this->EE->cp->set_breadcrumb($this->eeless_base_url,$this->EE->lang->line('eeless_module_name'));

		// Set the form action url to Update
		$this->eeless_vars['action_url'] = $this->eeless_form_url.AMP.'method=update';
	 
		// TODO - add some JS checking of the input	 
	 
		// Check for the entry ID.  If empty show index
		if(false == $this->EE->input->get_post('eeless_id')) :		
			$this->EE->functions->redirect($this->eeless_base_url);
		endif;

		// Based on entry ID, get entries row values in order to pass over the Edit view
		$eeless_id = $this->EE->input->get_post('eeless_id');
		
		$eeless_query = $this->EE->db->get('eeless',$eeless_id);

		foreach($eeless_query->result_array() as $row) :
			$this->eeless_vars['eeless_id'] 				= $row['eeless_id'];
			$this->eeless_vars['eeless_less_serverpath'] 	= $row['less_serverpath'];
			$this->eeless_vars['eeless_less_browserpath'] 	= $row['less_browserpath'];
			$this->eeless_vars['eeless_css_serverpath']		= $row['css_serverpath'];
			$this->eeless_vars['eeless_css_browserpath'] 	= $row['css_browserpath'];	 
		endforeach;

		// Clean up
		unset($eeless_id,$eeless_query);
		
		// Load the Edit view
		return $this->eeless_return_data = $this->EE->load->view('edit',$this->eeless_vars,true);
	} /* END edit */
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	/**
	 * Class Update page
	 * 
	 * This function actions the edit form submission
	 *
	 * @access public
     * @return array	 
	 */
	public function update() {
		// Check if the view has passed over all the required data
		if(true == $this->EE->input->get_post('eeless_id')  ) :
			$eeless_data = array(
				'less_serverpath'  => $this->EE->security->xss_clean($this->EE->input->get_post('less_serverpath')),
				'less_browserpath' => $this->EE->security->xss_clean($this->EE->input->get_post('less_browserpath')),
				'css_serverpath'   => $this->EE->security->xss_clean($this->EE->input->get_post('css_serverpath')),
				'css_browserpath'  => $this->EE->security->xss_clean($this->EE->input->get_post('css_browserpath'))	
			);
			
			// TODO - TESTS
			//		  make sure that the serverpath values are accessible locations on the server
			//        return a message if not
			//        perhaps drop a small gif into the folder to test then show in the template?
			
			
			// Do the update
			$this->EE->db->query($this->EE->db->update_string('eeless',$eeless_data,'eeless_id = '.$this->EE->input->get_post('eeless_id')));
		
			// Show success message to user
			$this->EE->session->set_flashdata('message_success',$this->EE->lang->line('eeless_updated_success'));
  
			unset($eeless_functions);
		endif;

		// Clean up		
		unset($eeless_data,$eeless_query);
		
		// Return the user the modules Index page		
		$this->EE->functions->redirect($this->eeless_base_url);
	} /* END update */
 
}
// END CLASS

/* End of file mcp.eeless.php */
/* Location: ./system/expressionengine/third_party/eeless/mcp.eeless.php */