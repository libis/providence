<?php
/* ----------------------------------------------------------------------
 * views/editor/object_representations/ajax_representation_image_center_editor_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2020 Whirl-i-Gig
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
 	$t_rep 						= $this->getVar('t_subject');
	$vn_representation_id 		= $this->getVar('subject_id');

	$vb_can_edit	 			= $t_rep->isSaveable($this->request);
	$vb_can_delete				= $t_rep->isDeletable($this->request);
	
	$vn_image_width 			= $this->getVar('image_width');	
	$vn_image_height 			= $this->getVar('image_height');
	
	$vn_center_x_pixel			= floor($vn_image_width * $this->getVar('center_x'));
	$vn_center_y_pixel			= floor($vn_image_height * $this->getVar('center_y'));
	
	
	$t_media = new Media();
	$vs_media_type = $t_media->getMimetypeTypename($vs_mime_type = $t_rep->getMediaInfo('media', 'original', 'MIMETYPE'));
?>

<div class="caMediaOverlayControls">
	<div class='close'><a href="#" onclick="caMediaPanel.hidePanel(); return false;" title="close"><?= caNavIcon(__CA_NAV_ICON_CLOSE__, "18px", [], ['color' => 'white']).' '._t('Close'); ?></a></div>
	<div class="objectInfo"><?= "{$vs_media_type}; ".caGetRepresentationDimensionsForDisplay($t_rep, 'original'); ?></div>
</div>
	
<div class="caObjectRepresentationSetCenterContainer" style="width: <?= $vn_image_width; ?>px; height: <?= $vn_image_height; ?>px;">
<div id="caObjectRepresentationSetCenterMarker"><?= caNavIcon(__CA_NAV_ICON_CROSSHAIRS__, 3); ?></div>
<?php
	print $this->getVar('image');
?>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#caObjectRepresentationSetCenterMarker").css("top", <?= $vn_center_y_pixel; ?> + "px").css("left", <?= $vn_center_x_pixel; ?> + "px").draggable({'containment' : 'parent'});
	});
</script>
