<?php
$info = array(
		"execute" 	=> '\library\capsule\layan\layan::init("{view}");',
		"option"	=> array(
					   "text"			=> array("type" => "input"),
					   "view"			=> array("type" => "select", "value" => array(
					   															'normal',
					   															'user_dashboard',
					   															'admin_dashboard',
					   															'admin_settings',
					   															'admin_settings_holiday',
					   															'counter',
					   															'user_counter',
					   															'admin_counter',
					   															'history',
					   															'id',
					   															'body',
					   															'icon_admin',
					   															'icon_user',
					   															'icon_library',
					   															'icon_guest_library',
					   															'overview',
					   															'user_pemberitahuan',
					   															'admin_pemberitahuan',
					   															'admin_pemberitahuan_create',
					   															'admin_pemberitahuan_edit',
					   															'user_perpanjangan',
					   															'admin_perpanjangan',
					   															'admin_perpanjangan_create',
					   															'admin_perpanjangan_edit',
					   															'user_penolakan',
					   															'admin_penolakan',
					   															'admin_penolakan_create',
					   															'admin_penolakan_edit',
					   															'admin_keberatan',
					   															'admin_keberatan_create',
					   															'admin_keberatan_edit',
					   															'user_keberatan',
					   															'user_keberatan_create',
					   															'user_keberatan_edit',
					   															'global_sejarah',
					   															'user_sejarah',
					   															'admin_sejarah',
					   															'user_attachment',
					   															'admin_attachment',
					   															'library',
					   															'libraryMetadata',
					   															'library_guest',
					   															'libraryGuestMetadata',
					   															'library_user',
					   															'libraryUserMetadata'
					   															)
					   						),
					  
					   )
		);


return $info;

?>