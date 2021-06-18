<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Welcome';

//login
$route['admin'] = 'admin/Login';
$route['admin/two_fa_verify'] = 'admin/Login/two_fa_verify';

//logout
$route['admin/logout'] = 'admin/Login/jadminlogout';

//dashboard
$route['admin/dashboard'] = 'admin/Dashboard';

//hashtag
$route['admin/hash-tags'] = 'admin/Hash_Tag/index';
$route['admin/hash-tags/(:any)/videos'] = 'admin/Hash_Tag/hash_tag_posts';

//banners
$route['admin/banners'] = 'admin/SearchHeaders/index';

//user
$route['admin/users'] = 'admin/User/index';
$route['admin/users/(:any)/edit'] = 'admin/User/edit_user';
$route['admin/users/(:any)/view'] = 'admin/User/view_user';
$route['admin/users/(:any)/videos'] = 'admin/User/user_posts';
$route['admin/users/(:any)/notifications'] = 'admin/User/user_notifications';
$route['admin/users/(:any)/reports'] = 'admin/User/user_reports';
$route['admin/users/(:any)/comments'] = 'admin/User/user_comments';
$route['admin/users/(:any)/sounds'] = 'admin/User/user_sounds';

//admin
$route['admin/profile'] = 'admin/Login/admin_profile';

//post
$route['admin/videos'] = 'admin/Post/index';
$route['admin/videos/(:any)/reports'] = 'admin/Post/post_reports';


//sound
$route['admin/sounds'] = 'admin/Sound/index';
$route['admin/sounds/(:any)/videos'] = 'admin/Sound/sound_posts';

$route['admin/sound-categories'] = 'admin/Sound/sound_category_list';
$route['admin/sound-categories/(:any)/sounds'] = 'admin/Sound/sounds_by_category';

//profile category
$route['admin/profile-categories'] = 'admin/Profile_Categories/index';
$route['admin/profile-categories/(:any)/users'] = 'admin/Profile_Categories/users_by_category';

//verification
$route['admin/verification-requests'] = 'admin/Verification_Request/index';



//report
$route['admin/reports'] = 'admin/Report/index';

//coin
$route['admin/coin-rate'] = 'admin/Coin/coin_rate';
$route['admin/coin-plans'] = 'admin/Coin/coin_plan';

//rewarding action
$route['admin/rewarding-actions'] = 'admin/Rewarding/index';

//redeem request
$route['admin/redeem-requests']='admin/Redeem_Request/index';

//notifications
$route['admin/notification_list'] = 'admin/Notifications/index';

//comments
$route['admin/comments_list'] = 'admin/Comments/index';

//settings
$route['admin/configs'] = 'admin/Settings/index';


//security
$route['admin/security'] = 'admin/User/security';

//deprecated
$route['admin/transaction_history'] = 'admin/Transaction/transaction_history_live';
$route['admin/add_referral_level'] = 'admin/Refferal/add_referral_level';
$route['admin/edit_referral_level/(:any)'] = 'admin/Refferal/edit_referral_level';
$route['admin/referral_level_manage'] = 'admin/Refferal/referral_level_manage';
$route['admin/core_wallet'] = 'admin/Core_Wallet/core_wallet';
$route['invite'] = 'Invite/invite_link';
$route['admin/ticket_list'] = 'admin/Support/ticket_list';
$route['admin/view_ticket/(:any)'] = 'admin/Support/view_ticket';
$route['admin/mining_fees'] = 'admin/Refferal/mining_fees';
$route['admin/app_fees'] = 'admin/Core_Wallet/app_fees';
$route['admin/add_blogs'] = 'admin/Blogs/add_blogs';
$route['admin/blogs_list'] = 'admin/Blogs/blogs_list';
$route['admin/edit_blogs/(:any)'] = 'admin/Blogs/edit_blogs'; 

//api
$route['User/registration']='api/User/registration_post';


//defaults
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;