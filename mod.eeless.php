<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Eeless - Module Class
 *
 * The Module master class
 *
 * @package: 		eeless
 * @author: 		Steven Milne <stevenmilne@gmail.com>
 * @copyright: 		Copyright (c) 2011 Steven Milne
 * @link:			http://stevenmilne.co.uk/
 * @version:		1.0
 * @filesource: 	./system/expressionengine/third_party/eeless/mod.eeless.php
 */
 
 /** 
 *  include our compiler class from leafo.net
 */
 
 /**
  * lessphp v0.2.1
  * http://leafo.net/lessphp
  *
  * LESS css compiler, adapted from http://lesscss.org/docs.html
  *
  * Copyright 2010, Leaf Corcoran <leafot@gmail.com>
  * Licensed under MIT or GPLv3, see LICENSE
  */
  include_once('library/lessc.inc.php');
 
class Eeless {
	private $EE;
	var $return_data    = ''; 
	/**
	* Class Constructor
	*
	* @access public
	* @return null
	*/
	public function __construct() {
	$this->EE =& get_instance();
	}
	
	
	function eeless()
	{
		 
	}
	
	
	function compile()
	{ 
	
		/*
			grab the paths from the database
		*/
		$eeless_query = $this->EE->db->get('eeless',1,0);
		
		foreach($eeless_query->result_array() as $row) :
			$less_serverpath 	= $row['less_serverpath'];
			$less_browserpath	= $row['less_browserpath'];
			$css_serverpath 	= $row['css_serverpath'];
			$css_browserpath	= $row['css_browserpath'];
		 
		endforeach;

		/*
			grab the paths from the template
		*/
		
		$bootstrap = $this->EE->TMPL->fetch_param('less');
		$css = $this->EE->TMPL->fetch_param('css');
		
		/*
			combine into the full paths for each of our three locations
		*/ 	
		
		$full_bootstrap 	= $less_serverpath.$bootstrap;
		$full_css 			= $css_serverpath.$css; 
		$browser_css 		= $css_browserpath.$css;
		
		/*
		
		TODO - check if the full_css folder exists, then create, then check if writable
		
		*/
		
		
		/*
			we just want to return the full path to the template to let the page know where to grab the css
		*/
		
		$this->return_data 	= $browser_css;  
		
		/*
			now we fire the full paths at the compiler
		*/ 
		
		try {
		    lessc::ccompile($full_bootstrap, $full_css);
		} catch (exception $ex) {
			/*
				capture any fails and feed back to browser
				TODO - have a switch to turn off error reporting
			*/
			$this->return_data = 'oops - there has been a less compilation fatal error:<br />'.$ex->getMessage();
		   // exit('lessc fatal error:<br />'.$ex->getMessage());
		}

		return   $this->return_data;
	}
    
    
}
// END CLASS

/* End of file mod.eeless.php */
/* Location: /system/expressionengine/third_party/eeless/mod.eeless.php */