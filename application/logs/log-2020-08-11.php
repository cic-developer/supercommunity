<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-08-11 10:18:44 --> Query error: Incorrect DATE value: '' - Invalid query: SELECT *
FROM `popup`
WHERE `pop_activated` = 1
AND   (
`pop_start_date` <= '2020-08-11'
OR `pop_start_date` IS NULL
 )
AND   (
`pop_end_date` >= '2020-08-11'
OR `pop_end_date` = '0000-00-00'
OR `pop_end_date` = ''
OR `pop_end_date` IS NULL
 )
ERROR - 2020-08-11 10:18:47 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 10:20:45 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/advertisementlist/index.php 17
ERROR - 2020-08-11 10:26:07 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 10:26:14 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 10:27:12 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 10:30:00 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 10:30:01 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 11:06:06 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 15:22:13 --> 404 Page Not Found: admin/cic/Medialist/index
ERROR - 2020-08-11 15:22:13 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 15:22:15 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 15:22:17 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 15:22:18 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 15:22:20 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 15:22:50 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 15:22:59 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 15:27:03 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 15:33:14 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 16:02:31 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 16:02:33 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 16:06:30 --> Severity: error --> Exception: Call to undefined function display_dhtml_editor() /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/missionlist/write.php 85
ERROR - 2020-08-11 16:07:21 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 16:09:22 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 16:09:23 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 16:16:10 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 16:16:34 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 16:26:27 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 16:27:38 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 16:27:45 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 16:29:17 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 16:38:50 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 16:39:04 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 16:39:17 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 17:15:45 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'rs_missionlist.mis_enddate <= "2020-08-11 17:15:45") THEN "end" ELSE ( CASE WHEN' at line 1 - Invalid query: SELECT `rs_missionlist`.*, `rs_missionpoint`.`mip_tpoint` as `tpoint`, CASE WHEN rs_missionlist.mis_max_point = 0 THEN 0 ELSE (rs_missionpoint.mip_tpoint/rs_missionlist.mis_max_point*100) END percentage, CASE WHEN rs_missionlist.mis_max_point <= rs_missionpoint.mip_tpoint OR rs_missionlist.mis_end = 1 OR (rs_missionlist.mis_enddate != "0000-00-00 00:00:00" rs_missionlist.mis_enddate <= "2020-08-11 17:15:45") THEN "end" ELSE ( CASE WHEN rs_missionlist.mis_opendate > "2020-08-11 17:15:45" THEN "planned" ELSE "process" END) END state
FROM `rs_missionlist`
LEFT JOIN `rs_missionpoint` ON `rs_missionlist`.`mis_id` = `rs_missionpoint`.`mip_mis_id`
WHERE `mis_deletion` = 'N'
ORDER BY `mis_id` DESC
 LIMIT 20
ERROR - 2020-08-11 17:15:45 --> Severity: error --> Exception: Call to a member function result_array() on bool /opt/bitnami/apps/CIC/htdocs/application/core/CB_Model.php 226
ERROR - 2020-08-11 17:15:49 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'rs_missionlist.mis_enddate <= "2020-08-11 17:15:49") THEN "end" ELSE ( CASE WHEN' at line 1 - Invalid query: SELECT `rs_missionlist`.*, `rs_missionpoint`.`mip_tpoint` as `tpoint`, CASE WHEN rs_missionlist.mis_max_point = 0 THEN 0 ELSE (rs_missionpoint.mip_tpoint/rs_missionlist.mis_max_point*100) END percentage, CASE WHEN rs_missionlist.mis_max_point <= rs_missionpoint.mip_tpoint OR rs_missionlist.mis_end = 1 OR ( rs_missionlist.mis_enddate != "0000-00-00 00:00:00" rs_missionlist.mis_enddate <= "2020-08-11 17:15:49") THEN "end" ELSE ( CASE WHEN rs_missionlist.mis_opendate > "2020-08-11 17:15:49" THEN "planned" ELSE "process" END) END state
FROM `rs_missionlist`
LEFT JOIN `rs_missionpoint` ON `rs_missionlist`.`mis_id` = `rs_missionpoint`.`mip_mis_id`
WHERE `mis_deletion` = 'N'
ORDER BY `mis_id` DESC
 LIMIT 20
ERROR - 2020-08-11 17:15:49 --> Severity: error --> Exception: Call to a member function result_array() on bool /opt/bitnami/apps/CIC/htdocs/application/core/CB_Model.php 226
ERROR - 2020-08-11 17:16:08 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 17:31:02 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 17:32:29 --> Severity: error --> Exception: syntax error, unexpected '!=' (T_IS_NOT_EQUAL) /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/missionlist/write.php 89
ERROR - 2020-08-11 17:36:25 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 17:36:48 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 17:47:15 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 17:57:24 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 17:58:38 --> 404 Page Not Found: admin/cic/Medialist/index
ERROR - 2020-08-11 17:58:50 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/advertisementlist/index.php 17
ERROR - 2020-08-11 18:03:49 --> Severity: error --> Exception: syntax error, unexpected 'return' (T_RETURN) /opt/bitnami/apps/CIC/htdocs/application/models/RS_missionlist_model.php 58
ERROR - 2020-08-11 18:39:02 --> 404 Page Not Found: admin/cic/Medialist/index
ERROR - 2020-08-11 18:39:49 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 18:39:59 --> 404 Page Not Found: admin/cic/Medialist/index
ERROR - 2020-08-11 18:40:03 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/advertisementlist/index.php 17
ERROR - 2020-08-11 18:40:03 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 18:40:05 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 18:40:06 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/CIC/htdocs/views/admin/basic/cic/advertisementlist/index.php 17
ERROR - 2020-08-11 18:53:32 --> Severity: error --> Exception: Call to a member function run() on null /opt/bitnami/apps/CIC/htdocs/application/controllers/admin/cic/Missionlist.php 634
ERROR - 2020-08-11 18:53:36 --> Severity: error --> Exception: Call to a member function run() on null /opt/bitnami/apps/CIC/htdocs/application/controllers/admin/cic/Missionlist.php 634
ERROR - 2020-08-11 18:53:36 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-11 18:54:51 --> Severity: error --> Exception: Call to a member function set_rules() on null /opt/bitnami/apps/CIC/htdocs/application/controllers/admin/cic/Missionlist.php 634
ERROR - 2020-08-11 18:55:47 --> Severity: error --> Exception: syntax error, unexpected '$this' (T_VARIABLE), expecting function (T_FUNCTION) or const (T_CONST) /opt/bitnami/apps/CIC/htdocs/application/controllers/admin/cic/Missionlist.php 628
