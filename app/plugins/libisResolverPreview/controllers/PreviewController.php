<?php
/* ----------------------------------------------------------------------
 * app/plugins/libisResolverPreview/controllers/ExportController.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2018 Whirl-i-Gig
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
require_once(__CA_LIB_DIR__.'/ProgressBar.php');
require_once(__CA_LIB_DIR__.'/Parsers/ZipFile.php');
require_once(__CA_MODELS_DIR__.'/ca_sets.php');
require_once(__CA_MODELS_DIR__.'/ca_bundle_displays.php');


class PreviewController extends ActionController {
	# -------------------------------------------------------
	/**
	 *
	 */
	protected $config;		// plugin configuration file

	# -------------------------------------------------------
	# Constructor
	# -------------------------------------------------------
	/**
	 *
	 */
	public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {


		// Set view path for plugin views directory
		if (!is_array($pa_view_paths)) { $pa_view_paths = array(); }
		$pa_view_paths[] = __CA_APP_DIR__."/plugins/libisResolverPreview/themes/".__CA_THEME__."/views";
		
		// Load plugin configuration file
		$this->config = Configuration::load(__CA_APP_DIR__.'/plugins/libisResolverPreview/conf/libisResolverPreview.conf');
		
		if (!$this->config->get('enabled')) {
			throw new ApplicationException(_t('Libis Resolver Preview is not enabled'));
		}

		
		parent::__construct($po_request, $po_response, $pa_view_paths);
		

		// Load plugin stylesheet
		MetaTagManager::addLink('stylesheet', __CA_URL_ROOT__."/app/plugins/libisResolverPreview/themes/".__CA_THEME__."/css/libisResolverPreview.css",'text/css');
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public function Index() {
		//if (!$this->request->user->canDoAction('can_preview_libis_resolver')) { return; }

		$this->render("index.php");
	}

	public function Completed() {
		//if (!$this->request->user->canDoAction('can_preview_libis_resolver')) { return; }

		$this->render("completed.php");
	}

	public function Metadata() {
		//if (!$this->request->user->canDoAction('can_preview_libis_resolver')) { return; }

		$this->render("metadata.php");
	}
	/**
	 *
	 */
	public function Download() {
		if (!$this->request->user->canDoAction('can_export_artefacts_canada')) { return; }
		$job_id = preg_replace("![^A-Za-z0-9_]+!", "_", $this->request->getParameter('job_id', pString));

		if(!file_exists(__CA_APP_DIR__."/tmp/artefacts_canada_export_{$job_id}.zip")) {
			throw new ApplicationException(_t('Download file is no longer available'));
		}
		
		$this->view->setVar('archive_path', __CA_APP_DIR__."/tmp/artefacts_canada_export_{$job_id}.zip");
		$this->view->setVar('archive_name', "artefacts_canada_export_{$job_id}.zip");
		$this->view->render('bundles/download_file_binary.php');
	}
	# ------------------------------------------------------------------

}
