<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| 	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved
| routes must come before any wildcard or regular expression routes.
|
*/
//$route['default_controller'] = "core";
$route['default_controller'] = "imghost";
$route['scaffolding_trigger'] = "";
$route['advertiser'] = 'advertisement';
$route['rules'] = 'advertisement/rules';
$route['antiaddblock'] = 'advertisement/antiaddblock';
$route['terms-use'] = 'advertisement/terms_use';
$route['user_agreement'] = 'advertisement/user_agreement';
$route['seedoff/set_position/:num'] = 'seedoff/set_position';
$route['seedoff/set_tags/:num'] = 'seedoff/set_tags';
$route['seedoff/set_cover'] = 'seedoff/cover';
$route['seedoff_filename/:num'] = 'seedoff/set_filename';
$route['seedoff_edit'] = 'imghost/seedoff_sync';
$route['seedoff_upload'] = 'imghost/seedoff_sync';
$route['seedoff_check/:num'] = 'seedoff/check_torrent';
$route['seedoff_check/pictures_list/:num'] = 'seedoff/torrents_list';
$route['seedoff/pictures_list/:num'] = 'seedoff/torrents_list';
$route['seedoff_check/cover/:num'] = 'seedoff/cover';
$route['seedoff_edit/cover'] = 'imghost/seedoff_sync';
$route['seedoff/upload'] = 'seedoff/upload';
$route['seedoff/remove_cover/:num'] = 'seedoff/remove_cover';
$route['seedoff/resort_position/:num'] = 'seedoff/resort_position';
$route['upload/fast/add_fields'] = 'imghost/add_fields';
$route['upload/fast'] = 'imghost/upload';
$route['upload/multiple'] = 'imghost/upload';
$route['upload/capture'] = 'imghost/upload';
$route['upload/api'] = 'imghost/upload';
$route['upload/apply_template/:num'] = 'imghost/upload';
$route['capture'] = 'imghost/capture';
$route['capture/row'] = 'imghost/capture_row';
$route['images_guest/edit/:num'] = 'imghost/images_edit';
$route['images/edit/:num'] = 'imghost/images_edit';
$route['images_guest/delete/:num'] = 'imghost/images_delete';
$route['images/delete/:num'] = 'imghost/images_delete';
$route['image/:num'] = 'imghost/image';
$route['image/:num/:num/:any'] = 'imghost/image';
$route['image/big/:num/:num/:any'] = 'imghost/image';
$route['image/big/:num'] = 'imghost/image';
$route['profile/:num/last_element'] = 'imghost/profile';
$route['profile/:num/first_element'] = 'imghost/profile';
$route['links/(guest|user)/:num'] = 'imghost/show_links';
$route['gallery'] = 'imghost/gallery';
$route['gallery/:num'] = 'imghost/gallery';
$route['gallery/tags/:num/:num'] = 'imghost/gallery';
$route['gallery/genres/:num/:num'] = 'imghost/gallery_genres';
$route['gallery/tags/:num'] = 'imghost/gallery';
$route['gallery/genres/:num'] = 'imghost/gallery_genres';
$route['gallery/genres'] = 'imghost/gallery_genres';
$route['gallery/tags'] = 'imghost/gallery';
$route['gallery_history/:num'] = 'imghost/gallery_history';
$route['gallery_history/tags/:num'] = 'imghost/gallery_history';
$route['gallery_history/tags/:num/:num'] = 'imghost/gallery_history';
$route['gallery/top'] = 'imghost/gallery';
$route['gallery/top/(views|rating)'] = 'imghost/gallery';
$route['gallery/top/(views|rating)/:num'] = 'imghost/gallery';
$route['gallery/top/rating/:num'] = 'imghost/gallery';
$route['top/views/:num'] = 'imghost/gallery_top';
$route['top/rating/:num'] = 'imghost/gallery_top';
$route['categories/:num'] = 'imghost/categories';
$route['profile'] = 'imghost/profile';
$route['profile/:num'] = 'imghost/profile';
$route['profile/albums'] = 'imghost/albums';
$route['profile/upload/templates'] = 'imghost/upload_templates';
$route['profile/upload/templates/add'] = 'imghost/upload_templates';
$route['profile/upload/templates/set'] = 'imghost/upload_templates';
$route['profile/upload/templates/delete/:num'] = 'imghost/upload_templates';
$route['profile/upload/templates/edit/:num'] = 'imghost/upload_templates';
$route['torrents/:num'] = 'imghost/torrent';
$route['torrents/:num/:num'] = 'imghost/torrent';
$route['torrents/file/delete'] = 'imghost/torrent_file_delete';
$route['torrents/file/delete/:num'] = 'imghost/torrent_file_delete';
$route['albums/:num'] = 'imghost/album';
$route['albums/:num/:num'] = 'imghost/album';
$route['albums_history/:num'] = 'imghost/album_history';
$route['albums_history/:num/:num'] = 'imghost/album_history';
$route['albums/:num/:num'] = 'imghost/album';
$route['albums/add'] = 'imghost/album_add';
$route['albums/delete/:num'] = 'imghost/album_delete';
$route['torrents/show/:num'] = 'imghost/torrent_show';
$route['torrents/delete/:num'] = 'imghost/torrent_delete';
$route['albums/show/:num'] = 'imghost/album_show';
$route['albums_settings/show/:num'] = 'imghost/album_settings';
$route['albums_settings/net/(vk|fb|ok|pic)/:num/reverse'] = 'imghost/album_settings';
$route['albums_settings/net/(vk|fb|ok|pic)/:num'] = 'imghost/album_settings';
$route['albums/files'] = 'imghost/album_files';
$route['albums/files/:num'] = 'imghost/album_files';
$route['albums/file/add'] = 'imghost/album_file_add';
$route['albums/file/delete'] = 'imghost/album_file_delete';
$route['albums/file/delete/:num'] = 'imghost/album_file_delete';
$route['albums/file/exclude'] = 'imghost/album_file_exclude';
$route['thumbnail/(user|guest)/:num/:num'] = 'imghost/thumbnail';
$route['profile/edit'] = 'auth/profile_edit';
$route['profile/statistic'] = 'imghost/profile_statistic';
$route['user/:num'] = 'imghost/userdetails';
$route['user/:num/:num'] = 'imghost/userdetails';
$route['search'] = 'imghost/search';
$route['register'] = 'auth/register';
$route['register/seedoff_data'] = 'auth/register_with_seedoff';
$route['sync'] = 'imghost/synchronize';
$route['sync/(vk|fb|ok|pic)'] = 'imghost/synchronize';
$route['sync/(vk|pic)/reverse'] = 'imghost/synchronize';
$route['sync/(vk|fb|ok|pic)/albums/:num/:num'] = 'imghost/show_net';
$route['sync/(vk|fb|ok|pic)/photos/:num/:num'] = 'imghost/copy_net';
$route['sync/(vk|fb|ok|pic)/photos/:num/:num/reverse'] = 'imghost/copy_local';
$route['sync/(vk|pic)/create_album/:num'] = 'imghost/create_album_net';
$route['sync/(vk|fb|ok|pic)/set_user'] = 'imghost/account_net';
$route['sync/(vk|pic)/upload'] = 'imghost/upload_to_net';
$route['poll/set'] = 'imghost/set_poll';
$route['favourite'] = 'imghost/gallery_favourite';
$route['favourite_list'] = 'imghost/gallery_favourite';
$route['favourite/(guest|user)/:num'] = 'imghost/add_favourite';
$route['remove_favourite/(guest|user)/:num'] = 'imghost/delete_favourite';
$route['login'] = 'auth/login';
$route['multi'] = 'imghost';
$route['add_comment'] = 'comments/insert';
$route['feedback'] = 'feedback';
$route['seedoff/set_cover'] = 'seedoff/set_cover';
$route['seedoff/new_image_size'] = 'seedoff/change_poster_thumbnail';
$route['set_avatar'] = 'imghost/set_avatar';
$route['authapi/login'] = 'auth/authapi/login';
$route['authapi/edit_profile'] = 'auth/authapi/edit_profile';
$route['logout'] = 'auth/logout';
$route['forgot_password'] = 'auth/forgot_password';
$route['reset_password'] = 'auth/reset_password';
$route['reset_password/:any/:any'] = 'auth/reset_password';
$route['authapi/forgot_password'] = 'auth/authapi/forgot_password';
$route['authapi/register'] = 'auth/authapi/register';
$route['admin/(.*)'] = "admin/$1";
$route['admin'] = "admin/admin";
$route['admin/logout'] = "admin/logout";
$route['admin/delete_cache'] = "admin/delete_cache";


// You can remove next lines after instalation.
//----------------------------------------------
$route['install/(.*)'] = "install/$1";
$route['install'] = "install";
//----------------------------------------------

//$route['sitemap.xml']    = 'sitemap/build_xml_map';
//$route['sitemap.xml.gz'] = 'sitemap/gzip';

$route[':any'] = "imghost/error_404";
//$route[':any'] = "imghost";

/* End of file routes.php */
/* Location: ./system/application/config/routes.php */