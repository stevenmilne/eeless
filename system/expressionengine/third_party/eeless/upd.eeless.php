<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * eeless - Install/Uninstall/Update Class
 *
 * In charge of the install, uninstall, and updating of the module
 *
 * @package: 		eeless
 * @author: 		Steven Milne <stevenmilne@gmail.com>
 * @copyright: 		Copyright (c) 2011 Steven Milne
 * @link:			http://stevenmilne.co.uk/
 * @version:		1.0
 * @filesource: 	./system/expressionengine/third_party/eeless/upd.eeless.php
 */ 

include_once('functions/fcn.eeless.php'); 
 
class Eeless_upd { 
	public $version;
	
	private $eeless_functions;
	private $eeless_return_data; 
	private $EE;
	
	/**
     * Class Constructor
     *
     * @access public
     * @return null
     */
	public function __construct() { 
		// Set the version of the module
		$this->version = '1.0';
		
		$this->EE =& get_instance();
		
		// Initialise and load functions list    	
    	$this->eeless_functions = new Eeless_fcn();		
	} /* END Constructor */

	/**
     * Module Installer
     *
     * @access public
  	 * @return boolean
     */
	public function install() {
		// Tells EE about the module
		$eeless_module_data = array(
			'module_name' => 'Eeless',
			'module_version' => $this->version,
			'has_cp_backend' => 'y',
			'has_publish_fields' => 'n'
		);

		// Add the module to the Modules table
        $this->EE->db->insert('modules',$eeless_module_data);

		// Clean up
		unset($eeless_module_data);
 
        $this->EE->load->dbforge();
     
     	// Sets up the table fields structure
     	// using varchar for cache and showerrors in case we need multiple states later
		$eeless_table_fields = array(
			'eeless_id' => array(
				'type' => 'bigint',
				'constraint' => 10,
				'unsigned' => true,
				'auto_increment' => true
			),
			'less_serverpath' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false
			),
			'less_browserpath' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false
			),
			'css_serverpath' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false
			),
			'css_browserpath' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false
			),
			'cache' => array(
				'type' => 'varchar',
				'constraint' => 16,
				'null' => false
			),
			'showerrors' => array(
				'type' => 'varchar',
				'constraint' => 16,
				'null' => false
			),
			'comments' => array(
				'type' => 'text',
				'null' => false
			)
		);
		
		// Sets primary key and creates the table
		$this->EE->dbforge->add_field($eeless_table_fields);
		
		$this->EE->dbforge->add_key('eeless_id',true);
		
		$this->EE->dbforge->create_table('eeless');
		
		// Set default values where we can
		$eeless_data = array(
			'cache' => 'off',
			'showerrors' => 'off',
			'comments' => $this->EE->security->xss_clean('Only one root currently, tags allow subfolders within.'),
		);
		
		// Perform the insert
		$this->EE->db->query($this->EE->db->insert_string('eeless',$eeless_data));
		
		// Update the .htaccess file with new IP address
		//$this->eeless_functions->write_to_htaccess();
		
		// Clean up
		unset($eeless_table_fields,$eeless_data,$eeless_functions);
		 
		
		
		// Return true as required
		return $this->eeless_return_data = true;
	} /* END install */
	
	/**
     * Module Updater
     *
     * @access public
     * @param string
     * @return boolean
     */
	public function update($eeless_current = '') {
		// Return true as required
		return $this->eeless_return_data = true;
	} /* END update */

	/**
     * Module Uninstaller
     *
     * @access public
     * @return boolean
     */
	public function uninstall() {		
	 
		// Finds and removes the module tables from the database
		  
		$this->EE->load->dbforge();

		$this->EE->db->select('module_id');
	
		$eeless_query = $this->EE->db->get_where('modules',array('module_name' => 'eeless'));

		$this->EE->db->where('module_id',$eeless_query->row('module_id'));
		$this->EE->db->delete('module_member_groups');

		$this->EE->db->where('module_name','eeless');
		$this->EE->db->delete('modules');

		$this->EE->dbforge->drop_table('eeless');		
	 
		// Clean up
		unset($eeless_query,$eeless_new,$eeless_functions,$eeless_action);
		
		// Return true as required 
		
		return $this->eeless_return_data = true;
	} /* END uninstall */
}
/* END Class */

/* End of file upd.eeless.php */
/* Location: ./system/expressionengine/third_party/eeless/upd.eeless.php */