<?php
/** ---------------------------------------------------------------------
 * app/lib/ca/Browse/InterstitialBrowse.php : ca_entities faceted browse
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * @package CollectiveAccess
 * @subpackage Browse
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
  /**
  *
  */
  
 	require_once(__CA_LIB_DIR__.'/Browse/BaseBrowse.php');
 	require_once(__CA_LIB_DIR__.'/Browse/InterstitialBrowseResult.php');
 
	class InterstitialBrowse extends BaseBrowse {
		# ------------------------------------------------------
		/**
		 * Which table does this class represent?
		 */
		protected $ops_tablename;
		protected $ops_tablenum;
		protected $ops_primary_key;
		# ----------------------------------------------------------------------
		public function __construct($pn_browse_id=null, $ps_context='', $ps_table) {
			
			$this->ops_tablename = $ps_table;
			$this->opn_tablenum = Datamodel::getTableNum($ps_table);
		
			$this->ops_primary_key = Datamodel::primaryKey($ps_table);
			parent::__construct($this->ops_tablename, $pn_browse_id, $ps_context);
		}
		# ------------------------------------------------------
		public function getResults($pa_options=null) {
			return parent::doGetResults(new InterstitialBrowseResult($this->ops_tablename), $pa_options);
		}
		# ----------------------------------------------------------------------
	}