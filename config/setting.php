<?php

// config("setting.err_500")

$css_folder = 'css';
$storage = '/storage/';
$js_folder = 'js';
$js_folder_ = "{$js_folder}/";
$layout_folder = 'layouts';
$layout_folder_ = "{$layout_folder}.";
$public_folder = 'public/';
$public_fo = 'public';
$images_folder = 'images/';
$land_folder = 'land/';
$admin_folder = 'admin/';

if (config('app.env') == 'production') {
    $images_folder = $public_folder.$images_folder;
    $js_folder = $public_folder.$js_folder;
    $css_folder = $public_folder.$css_folder;
    $storage = '/'.$public_fo.$storage;
    $js_folder_ = $public_folder.$js_folder_;
}

return [
    'setting_lay' => $layout_folder_.'settings',
    'show_users' => $layout_folder_.'show_users',
    'retry_time' => 30,
    'max_tble_size' => 9_0000000000,
    'gender' => [
        'male', 'female', 'others',
    ],
    'en_prfle_form' => true,
    'my_prfle' => $layout_folder.'.my_profile',
    'admn_oprtn_list' => $layout_folder.'.admin_operations_list',
    'admn_oprtn' => $layout_folder.'.admin_operations',
    'min_pass' => 6,
    'pass_no_req' => false,
    'pass_ltr_req' => true,
    'pass_smbl_req' => false,
    'user_reg' => 'user_reg',
    'crtr_admn_mdl' => 'crtr_admn_mdl',
    'update_password' => 'update_password',
    'del_form' => 'del_form',
    'sub_admins_js' => "{$js_folder}/{$admin_folder}sub_admins.js",
    'usrs_js' => "{$js_folder}/{$admin_folder}show_users.js",
    'sub_admins' => $layout_folder.'.sub_admins',
    'lands' => 'lands',
    'var_js' => $js_folder_.'vars.js',
    'settings_js' => $js_folder_.'settings.js',
    'message_form' => 'message_form',
    'storage' => $storage.'uploads/',
    'body' => $layout_folder.'.body',
    'default_desc' => 'Default Description',
    'app_css' => $css_folder.'/app.css',
    'app_js' => $js_folder.'/app.js',
    'datatable_js' => $js_folder.'/datatable.js',
    'common_functions' => $js_folder.'/common_functions.js',
    'welcome' => 'welcome',
    'is_success' => 'is_success',
    'message' => 'message',
    'error' => 'error',
    'dash_lines' => '-----------------------',
    'status_200' => 200,
    'err_500' => 500,
    'err_422' => 422,
    'err_403' => 403,
    'err_404' => 404,
    'err_301' => 301,
    'favicon' => $images_folder.'favicon.ico',
    'email' => 'harbourislandcommonage@gmail.com',
    'phone_num' => '1-242-805-5687',
    'address' => 'Harbour Island commonage office, barracks Hill Dunmore Town North Eleuthera Bahamas',
    'link' => 'no-underline hover:underline text-blue-900',
    'im_wel' => $images_folder.'wel.jpg',
    'im_glass' => $images_folder.'glass.jpeg',
    'im_event' => $images_folder.'event.jpg',
    'im_sponsorship' => $images_folder.'sponsorship.jpg',
    'im_welcome' => $images_folder.'welcome.jpg',
    'im_log' => $images_folder.'logo.png',
    'im_log_desc' => '',
    'en_slf' => true,
    'en_lnd_edt' => false,
    'en_wel' => true,
    'en_typewriter' => true,
    'en_mo_info_con' => true,
    'en_im_glass' => true,
    'en_newsupdates' => true,
    'en_im_event' => true,
    'en_im_sponsorship' => false,
    'en_works' => true,
    'en_footer' => true,
    'en_contact' => true,
    'en_articleadvices' => true,
    'en_articleadvices_con' => true,
    'land_create' => $land_folder.'land_create',
    'en_land_display' => false,
    'en_reg_form' => true,
    'land_create_css' => "{$css_folder}/{$land_folder}land_create.css",
    'land_create_js' => "{$js_folder}/{$land_folder}land_create.js",
    'admin_login_js' => "{$js_folder}/{$admin_folder}admin_login.js",
    'admin_lands_js' => "{$js_folder}/{$admin_folder}admin_lands.js",
    'my_profile_js' => "{$js_folder}/my_profile.js",
    'login_js' => "{$js_folder}/login.js",
    'svg_toggle' => '',
    'isLoaderLoaded' => false,
    'h2_css' => 'pb-3 flex flex-col justify-center items-center mb-4 text-4xl font-extrabold leading-none
        tracking-tight md:text-5xl lg:text-6xl dark:text-white',
    'red_star' => '<span class="red_cross">*</span>',
    'title' => 'title',
    'land_title' => 'Land Title',
    'description' => 'description',
    'land_des' => 'Land Registeration Description',
    'location' => 'location',
    'location_desc' => 'Location/Address',
    'size' => 'size',
    'city' => 'city',
    'country' => 'country',
    'bahmas_country_code' => 17,
    'en_country' => false,
    'app_name' => 'harbourislandcommonage.com',
    'en_land_reg_file' => true,
    'land_reg_file_upload' => 'file_upload',
    'fuas' => 100,
    'en_gc' => true,
    'ad' => 'token is missing in the header',
    'suname' => 'Sample UserName',
    'landreg_folder' => 'land_register',
    'landreg_multiple' => true,
    'default_timeout' => 5000,
    'default_local' => 'local',
    'default_img' => 'qUBzTvDUVPxIt38iC3ZkEHbCywdrcTPBn1Gvuz47.jpg',
    'send_land_email' => false,
    'admin_login' => 'admin_login',
    'admin_chart' => 'admin_chart',
    'admin_lands' => 'admin_lands',
    'admin_body' => $layout_folder_.'admin_body',
    'land_logs' => $layout_folder_.'land_logs',
    'comment_logs' => $layout_folder_.'comment_logs',
];
