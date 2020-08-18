<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-08-13 10:13:53 --> Query error: Incorrect DATE value: '' - Invalid query: SELECT *
FROM `popup`
WHERE `pop_activated` = 1
AND   (
`pop_start_date` <= '2020-08-13'
OR `pop_start_date` IS NULL
 )
AND   (
`pop_end_date` >= '2020-08-13'
OR `pop_end_date` = '0000-00-00'
OR `pop_end_date` = ''
OR `pop_end_date` IS NULL
 )
ERROR - 2020-08-13 10:32:28 --> 404 Page Not Found: judgemission/write
ERROR - 2020-08-13 10:32:30 --> 404 Page Not Found: judgemission/write
ERROR - 2020-08-13 10:34:01 --> Severity: error --> Exception: syntax error, unexpected ':' /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/index.php 68
ERROR - 2020-08-13 10:36:45 --> Severity: error --> Exception: Call to undefined function echoelement() /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/index.php 63
ERROR - 2020-08-13 10:37:04 --> Severity: error --> Exception: Call to undefined function echoelement() /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/index.php 63
ERROR - 2020-08-13 10:48:15 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 10:54:55 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 10:55:24 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 10:56:17 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 10:59:48 --> Severity: error --> Exception: syntax error, unexpected 'if' (T_IF) /opt/bitnami/apps/CIC/htdocs/application/controllers/admin/cic/Judgemission.php 87
ERROR - 2020-08-13 10:59:53 --> Severity: error --> Exception: syntax error, unexpected 'if' (T_IF) /opt/bitnami/apps/CIC/htdocs/application/controllers/admin/cic/Judgemission.php 87
ERROR - 2020-08-13 11:01:40 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:01:43 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:01:45 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:01:51 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:03:39 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:03:40 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:03:41 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:04:41 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:04:42 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:04:42 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:04:59 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:04:59 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:05:00 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:05:07 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:05:07 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:05:57 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:07:01 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:07:09 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:07:11 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:07:30 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:08:15 --> 404 Page Not Found: admin/cic/Medialist/index
ERROR - 2020-08-13 11:08:48 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:10:48 --> 404 Page Not Found: admin/cic/Url/index
ERROR - 2020-08-13 11:10:48 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:13:18 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:13:29 --> Query error: Unknown column 'jud_wht_id' in 'where clause' - Invalid query: SELECT *
FROM `rs_judge`
INNER JOIN `rs_whitelist` ON `rs_judge`.`jud_med_wht_id` = `rs_whitelist`.`wht_id`
INNER JOIN `rs_judge_group` ON `rs_judge`.`jud_jug_id` = `rs_judge_group`.`jug_id`
WHERE `jud_state` = 1
AND `jud_wht_id` = 1
AND `jud_jug_id` = 1
AND `jud_deletion` = 'N'
ORDER BY `jud_id` DESC
 LIMIT 20
ERROR - 2020-08-13 11:13:29 --> Severity: error --> Exception: Call to a member function result_array() on bool /opt/bitnami/apps/CIC/htdocs/application/core/CB_Model.php 226
ERROR - 2020-08-13 11:32:04 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:32:06 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:32:14 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:33:37 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:45:23 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:52:12 --> Severity: error --> Exception: Call to undefined method RS_judge_model::get_one_mission() /opt/bitnami/apps/CIC/htdocs/application/controllers/admin/cic/Judgemission.php 195
ERROR - 2020-08-13 11:52:12 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 11:57:45 --> Severity: error --> Exception: Call to undefined function display_dhtml_editor() /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/detail.php 93
ERROR - 2020-08-13 11:58:20 --> Severity: error --> Exception: Call to undefined function display_dhtml_editor() /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/detail.php 93
ERROR - 2020-08-13 11:58:31 --> Severity: error --> Exception: Call to undefined function display_dhtml_editor() /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/detail.php 93
ERROR - 2020-08-13 12:06:39 --> Query error: Table 'CIC_DEV.rs_mission' doesn't exist - Invalid query: SELECT *
FROM `rs_judge`
INNER JOIN `rs_whitelist` ON `rs_judge`.`jud_med_wht_id` = `rs_whitelist`.`wht_id`
INNER JOIN `rs_judge_group` ON `rs_judge`.`jud_jug_id` = `rs_judge_group`.`jug_id`
INNER JOIN `rs_mission` ON `rs_judge`.`jud_mis_id` = `rs_mission`.`mis_id`
WHERE `jud_jug_id` = 1
AND `jud_deletion` = 'N'
ORDER BY `jud_id` DESC
 LIMIT 20
ERROR - 2020-08-13 12:06:39 --> Severity: error --> Exception: Call to a member function result_array() on bool /opt/bitnami/apps/CIC/htdocs/application/core/CB_Model.php 226
ERROR - 2020-08-13 12:09:26 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:09:27 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:09:28 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:12:16 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:16:58 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:25:58 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:37:11 --> 404 Page Not Found: admin/cic/Undefined/index
ERROR - 2020-08-13 12:48:23 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:25 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:26 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:27 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:29 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:30 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:30 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:32 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:34 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:38 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:39 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:41 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:42 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:44 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:47 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:48 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:49 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:54:58 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 12:55:02 --> 404 Page Not Found: admin/cic/Medialist/index
ERROR - 2020-08-13 13:04:33 --> Severity: error --> Exception: Call to a member function get_media() on null /opt/bitnami/apps/CIC/htdocs/application/controllers/Media.php 18
ERROR - 2020-08-13 13:05:52 --> Severity: error --> Exception: Call to a member function get_media() on null /opt/bitnami/apps/CIC/htdocs/application/controllers/Media.php 18
ERROR - 2020-08-13 15:06:47 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 15:08:17 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 15:13:30 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 15:33:53 --> 404 Page Not Found: admin/cic/Medialist/index
ERROR - 2020-08-13 15:46:26 --> Severity: error --> Exception: Unable to locate the model you have specified: RS_judge_denyreason_model /opt/bitnami/apps/CIC/htdocs/_system/core/Loader.php 348
ERROR - 2020-08-13 15:46:26 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 15:46:45 --> Severity: error --> Exception: Unable to locate the model you have specified: RS_judge_denyreason_model /opt/bitnami/apps/CIC/htdocs/_system/core/Loader.php 348
ERROR - 2020-08-13 15:47:04 --> Severity: error --> Exception: Unable to locate the model you have specified: RS_judge_denyreason_model /opt/bitnami/apps/CIC/htdocs/_system/core/Loader.php 348
ERROR - 2020-08-13 15:47:05 --> Severity: error --> Exception: Unable to locate the model you have specified: RS_judge_denyreason_model /opt/bitnami/apps/CIC/htdocs/_system/core/Loader.php 348
ERROR - 2020-08-13 15:48:24 --> Severity: error --> Exception: Unable to locate the model you have specified: RS_judge_denyreason_model /opt/bitnami/apps/CIC/htdocs/_system/core/Loader.php 348
ERROR - 2020-08-13 15:49:03 --> Severity: error --> Exception: Call to undefined method RS_judge_denyreason_model::get_whitelist_list() /opt/bitnami/apps/CIC/htdocs/application/controllers/admin/cic/Judgemission.php 204
ERROR - 2020-08-13 15:53:50 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/denyreason.php 18
ERROR - 2020-08-13 15:53:54 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/denyreason.php 18
ERROR - 2020-08-13 15:55:58 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 15:58:49 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 15:59:29 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 16:02:11 --> 404 Page Not Found: admin/cic/Medialist/index
ERROR - 2020-08-13 16:09:01 --> 404 Page Not Found: admin/cic/Medialist/index
ERROR - 2020-08-13 16:09:05 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 16:09:06 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 16:12:35 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 16:17:12 --> Severity: error --> Exception: The OAuth 2.0 access token has expired, and a refresh token is not available. Refresh tokens are not returned for responses that were auto-approved. /opt/bitnami/apps/CIC/htdocs/plugin/social/libraries/google/Auth/OAuth2.php 248
ERROR - 2020-08-13 16:17:14 --> Severity: error --> Exception: The OAuth 2.0 access token has expired, and a refresh token is not available. Refresh tokens are not returned for responses that were auto-approved. /opt/bitnami/apps/CIC/htdocs/plugin/social/libraries/google/Auth/OAuth2.php 248
ERROR - 2020-08-13 16:18:37 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 16:23:19 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 16:24:38 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 16:24:53 --> Severity: Warning --> nl2br() expects at most 2 parameters, 3 given /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/denyreason.php 56
ERROR - 2020-08-13 16:24:53 --> Severity: Warning --> substr() expects at least 2 parameters, 1 given /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/denyreason.php 56
ERROR - 2020-08-13 16:24:53 --> Severity: Warning --> nl2br() expects at most 2 parameters, 3 given /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/denyreason.php 56
ERROR - 2020-08-13 16:24:54 --> Severity: Warning --> substr() expects at least 2 parameters, 1 given /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/denyreason.php 56
ERROR - 2020-08-13 16:26:03 --> Severity: error --> Exception: syntax error, unexpected ')', expecting ',' or ';' /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/denyreason.php 56
ERROR - 2020-08-13 16:26:08 --> Severity: Warning --> nl2br() expects at most 2 parameters, 3 given /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/denyreason.php 56
ERROR - 2020-08-13 16:26:08 --> Severity: Warning --> substr() expects at least 2 parameters, 1 given /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/denyreason.php 56
ERROR - 2020-08-13 16:26:08 --> Severity: Warning --> nl2br() expects at most 2 parameters, 3 given /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/denyreason.php 56
ERROR - 2020-08-13 16:26:08 --> Severity: Warning --> substr() expects at least 2 parameters, 1 given /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/denyreason.php 56
ERROR - 2020-08-13 16:26:59 --> 404 Page Not Found: admin/cic/Medialist/index
ERROR - 2020-08-13 16:27:26 --> 404 Page Not Found: admin/cic/Medialist/index
ERROR - 2020-08-13 16:28:16 --> 404 Page Not Found: judgemission/denyreason_listdelete
ERROR - 2020-08-13 16:28:16 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 16:28:52 --> 404 Page Not Found: judgemission/whitelist
ERROR - 2020-08-13 16:28:52 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 16:29:03 --> 404 Page Not Found: judgemission/whitelist
ERROR - 2020-08-13 16:34:31 --> Severity: error --> Exception: syntax error, unexpected 'as' (T_AS), expecting ')' /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/judgemission/detail.php 86
ERROR - 2020-08-13 16:41:34 --> Severity: error --> Exception: syntax error, unexpected ''judr_reason'' (T_CONSTANT_ENCAPSED_STRING), expecting ')' /opt/bitnami/apps/CIC/htdocs/application/controllers/admin/cic/Judgemission.php 238
ERROR - 2020-08-13 16:41:40 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 16:43:50 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 16:43:50 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 16:44:15 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 16:45:49 --> 404 Page Not Found: admin/cic/Url/index
ERROR - 2020-08-13 16:48:00 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 16:48:11 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 16:48:17 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:02:54 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:11:27 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:11:29 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:12:40 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:12:41 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:19:20 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:19:28 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:19:28 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:19:31 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:20:00 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:21:41 --> Severity: error --> Exception: Cannot use string offset as an array /opt/bitnami/apps/CIC/htdocs/application/controllers/admin/member/Members.php 521
ERROR - 2020-08-13 17:21:41 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:21:44 --> Severity: error --> Exception: Cannot use string offset as an array /opt/bitnami/apps/CIC/htdocs/application/controllers/admin/member/Members.php 521
ERROR - 2020-08-13 17:21:44 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:21:46 --> Severity: error --> Exception: Cannot use string offset as an array /opt/bitnami/apps/CIC/htdocs/application/controllers/admin/member/Members.php 521
ERROR - 2020-08-13 17:39:33 --> Severity: error --> Exception: Cannot use string offset as an array /opt/bitnami/apps/CIC/htdocs/application/controllers/admin/member/Members.php 521
ERROR - 2020-08-13 17:40:43 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:46:04 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:46:22 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/CIC/htdocs/views/media/basic/media.php 19
ERROR - 2020-08-13 17:46:22 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:46:29 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:47:01 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/CIC/htdocs/views/media/basic/media.php 19
ERROR - 2020-08-13 17:47:02 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:47:02 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:47:02 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:47:28 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/CIC/htdocs/views/media/basic/media.php 19
ERROR - 2020-08-13 17:47:29 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:47:29 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:47:43 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/CIC/htdocs/views/media/basic/media.php 19
ERROR - 2020-08-13 17:47:44 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:47:44 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:48:10 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/CIC/htdocs/views/media/basic/media.php 19
ERROR - 2020-08-13 17:48:10 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:48:11 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:48:31 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/CIC/htdocs/views/media/basic/media.php 19
ERROR - 2020-08-13 17:48:31 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:48:32 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:48:32 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:49:21 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/CIC/htdocs/views/media/basic/media.php 19
ERROR - 2020-08-13 17:49:21 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:49:22 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:49:46 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/CIC/htdocs/views/media/basic/media.php 19
ERROR - 2020-08-13 17:49:46 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:49:47 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:51:14 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable /opt/bitnami/apps/CIC/htdocs/views/media/basic/media.php 19
ERROR - 2020-08-13 17:51:15 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:51:15 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:52:03 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:52:04 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:52:14 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:52:15 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:52:43 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:52:44 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:53:03 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:53:04 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:54:20 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:54:21 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:54:23 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:54:53 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:56:10 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:56:30 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:57:01 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:57:02 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:57:20 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:57:55 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 17:59:00 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:59:01 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:59:38 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:59:38 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 17:59:40 --> 404 Page Not Found: 
ERROR - 2020-08-13 17:59:40 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 18:00:02 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:00:03 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:00:32 --> 404 Page Not Found: 
ERROR - 2020-08-13 18:00:40 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:00:41 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:01:16 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:01:17 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:02:42 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 18:03:03 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 18:03:05 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 18:03:05 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:03:06 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:03:06 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 18:03:14 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 18:09:05 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 18:09:13 --> 404 Page Not Found: admin/cic/Medialist/index
ERROR - 2020-08-13 18:09:13 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 18:09:48 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 18:38:32 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 18:38:35 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 18:39:13 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:39:13 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:39:13 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 18:55:02 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:55:03 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:55:03 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 18:55:19 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:55:20 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:55:20 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 18:55:21 --> 404 Page Not Found: Form/index
ERROR - 2020-08-13 18:55:27 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:55:27 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:55:44 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:55:45 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:55:45 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 18:59:48 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:59:49 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:59:49 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 18:59:50 --> 404 Page Not Found: Form/index
ERROR - 2020-08-13 18:59:52 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 18:59:53 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:00:57 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:00:57 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:00:58 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 19:00:58 --> 404 Page Not Found: Form/index
ERROR - 2020-08-13 19:01:00 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:01:01 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:02:48 --> 404 Page Not Found: Form/index
ERROR - 2020-08-13 19:02:52 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:02:53 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:03:25 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:03:25 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:03:49 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:03:49 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:03:53 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:04:28 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 19:05:49 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 19:05:50 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 19:10:26 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:10:26 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:10:26 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 19:11:07 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:11:08 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:11:08 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 19:11:31 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:11:32 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:11:35 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 19:12:04 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:12:04 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:14:37 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:14:38 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:14:41 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:14:41 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:14:51 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:14:51 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:14:53 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:14:53 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:19:44 --> Severity: error --> Exception: syntax error, unexpected 'echo' (T_ECHO) /opt/bitnami/apps/CIC/htdocs/application/controllers/Media.php 38
ERROR - 2020-08-13 19:19:59 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:19:59 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:20:00 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:20:00 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:21:28 --> Severity: error --> Exception: syntax error, unexpected 'foreach' (T_FOREACH) /opt/bitnami/apps/CIC/htdocs/application/controllers/Media.php 38
ERROR - 2020-08-13 19:28:08 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 19:28:22 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 19:28:43 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:28:43 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:28:46 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:28:46 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:29:01 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:29:02 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:29:21 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:29:22 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:29:38 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:29:39 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:29:40 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 19:29:42 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:29:42 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:45:59 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:46:00 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:47:35 --> Query error: Unknown column 'jul_input' in 'field list' - Invalid query: INSERT INTO `rs_judge_log` (`jul_jug_id`, `jul_jud_id`, `jul_state`, `jul_mem_id`, `jul_user_id`, `jul_datetime`, `jul_input`, `jul_useragent`) VALUES ('1', '1', '3', '1', NULL, '2020-08-13 19:47:35', '59.26.134.158', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_5) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.1 Safari/605.1.15')
ERROR - 2020-08-13 19:48:20 --> Query error: Column 'jul_user_id' cannot be null - Invalid query: INSERT INTO `rs_judge_log` (`jul_jug_id`, `jul_jud_id`, `jul_state`, `jul_mem_id`, `jul_user_id`, `jul_datetime`, `jul_ip`, `jul_useragent`) VALUES ('1', '1', '3', '1', NULL, '2020-08-13 19:48:19', '59.26.134.158', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_5) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.1 Safari/605.1.15')
ERROR - 2020-08-13 19:49:05 --> Query error: Column 'jul_user_id' cannot be null - Invalid query: INSERT INTO `rs_judge_log` (`jul_jug_id`, `jul_jud_id`, `jul_state`, `jul_mem_id`, `jul_user_id`, `jul_datetime`, `jul_ip`, `jul_useragent`) VALUES ('1', '1', '3', '1', NULL, '2020-08-13 19:49:05', '59.26.134.158', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_5) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.1 Safari/605.1.15')
ERROR - 2020-08-13 19:49:23 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:49:23 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:49:32 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:49:32 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 19:50:37 --> Query error: Column 'jul_user_id' cannot be null - Invalid query: INSERT INTO `rs_judge_log` (`jul_jug_id`, `jul_jud_id`, `jul_state`, `jul_mem_id`, `jul_user_id`, `jul_datetime`, `jul_ip`, `jul_useragent`) VALUES ('1', '1', '3', '1', NULL, '2020-08-13 19:50:37', '59.26.134.158', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_5) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.1 Safari/605.1.15')
ERROR - 2020-08-13 19:51:30 --> Query error: Column 'jul_user_id' cannot be null - Invalid query: INSERT INTO `rs_judge_log` (`jul_jug_id`, `jul_jud_id`, `jul_state`, `jul_mem_id`, `jul_user_id`, `jul_datetime`, `jul_ip`, `jul_useragent`) VALUES ('1', '1', '3', '1', NULL, '2020-08-13 19:51:30', '59.26.134.158', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_5) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.1 Safari/605.1.15')
ERROR - 2020-08-13 19:52:30 --> Query error: Column 'judn_reason' cannot be null - Invalid query: INSERT INTO `rs_judge_denied` (`judn_jud_id`, `judn_reason`) VALUES ('1', NULL)
ERROR - 2020-08-13 19:54:31 --> Query error: Column 'judn_reason' cannot be null - Invalid query: INSERT INTO `rs_judge_denied` (`judn_jud_id`, `judn_reason`) VALUES ('1', NULL)
ERROR - 2020-08-13 19:58:33 --> Query error: Column 'judn_reason' cannot be null - Invalid query: INSERT INTO `rs_judge_denied` (`judn_jud_id`, `judn_reason`) VALUES ('1', NULL)
ERROR - 2020-08-13 20:00:44 --> Query error: Duplicate entry '1-mem_warn_1' for key 'mem_id_mev_key' - Invalid query: INSERT INTO `member_extra_vars` (`mem_id`, `mev_key`, `mev_value`) VALUES ('1', 'mem_warn_1', 'tests')
ERROR - 2020-08-13 20:03:07 --> Query error: Duplicate entry '1-mem_warn_1' for key 'mem_id_mev_key' - Invalid query: INSERT INTO `member_extra_vars` (`mem_id`, `mev_key`, `mev_value`) VALUES ('1', 'mem_warn_1', 'testes')
ERROR - 2020-08-13 20:06:28 --> Severity: error --> Exception: Call to undefined method RS_judge_denied_model::meta_update() /opt/bitnami/apps/CIC/htdocs/application/controllers/admin/cic/Judgemission.php 906
ERROR - 2020-08-13 20:11:41 --> Query error: Unknown column 'mem_warn_1' in 'field list' - Invalid query: SELECT `mem_warn_1`
FROM `member_extra_vars`
WHERE `mem_id` = '1'
AND `mev_key` = 'mem_warn_1'
 LIMIT 1
ERROR - 2020-08-13 20:11:41 --> Severity: error --> Exception: Call to a member function row_array() on bool /opt/bitnami/apps/CIC/htdocs/application/core/CB_Model.php 69
ERROR - 2020-08-13 20:15:00 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 20:16:13 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 20:16:14 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 20:16:23 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 20:16:45 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-13 20:22:08 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 20:22:09 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 20:25:08 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 20:25:08 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 20:25:22 --> 404 Page Not Found: media/views
ERROR - 2020-08-13 20:25:22 --> 404 Page Not Found: media/views
