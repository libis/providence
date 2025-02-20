<?php
/* ----------------------------------------------------------------------
 * persistentReferencesPlugin.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2018 Whirl-i-Gig
 * This file originally contributed 2014 by Gaia Resources
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
 * ----------------------------------------------------------------------
 */


class persistentReferencesPlugin extends BaseApplicationPlugin {
	# -------------------------------------------------------
	/**
	 * Plugin config
	 * @var Configuration
	 */
	var $opo_plugin_config = null;



	# -------------------------------------------------------
	public function __construct($ps_plugin_path)
	{


		$this->description = _t('This plugin allows persistent references to items, where primary keys are less durable');
		parent::__construct();

		$this->opo_plugin_config = Configuration::load($ps_plugin_path . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'persistentReferences.conf');
	}

	/**
	 *
	 */
	public function checkStatus() {
		return array(
			'description' => $this->getDescription(),
			'errors' => array(),
			'warnings' => array(),
			'available' => (bool) $this->opo_plugin_config->get('enabled')
		);
	}


	# -------------------------------------------------------
	public function hookEditItem($pa_params) {

		$currentPath = $_SERVER['REQUEST_URI'];
		$pattern = '/editor\/(.*)\/(.*)Editor\/Edit\/idno\/(.*)/';

		// Perform the regular expression match on an idno editor url
		if (preg_match($pattern, $currentPath, $matches)) {

			// Extract the ID from the matched pattern
			$concept = "ca_" . $matches[1];
			$concept_key = substr($matches[1], 0, -1)."_id";

			$vs_sql = sprintf("select * from %s where idno='%s'", $concept,$matches[3]);

			$id=null;
			$o_db = new Db();
			$res = $o_db->query($vs_sql);
			while($res->nextRow()) {
				$id = $res->get($concept_key);
			}

			if(!is_null($id)){
				$url = str_replace($matches[0],sprintf("/editor/%s/%sEditor/Edit/%s/%s",$matches[1],$matches[2],$concept_key,$id),$currentPath);
				header('Location: ' . $url);
			}

		}

		return $pa_params;

	}


}
