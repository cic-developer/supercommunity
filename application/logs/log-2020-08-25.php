<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-08-25 11:02:55 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 11:03:18 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 11:03:28 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 11:03:28 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 11:03:34 --> 404 Page Not Found: 
ERROR - 2020-08-25 11:03:34 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 11:03:36 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 11:03:37 --> 404 Page Not Found: 
ERROR - 2020-08-25 11:03:37 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 11:03:38 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 11:14:25 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 11:14:57 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 11:15:02 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 11:15:15 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 11:15:17 --> 404 Page Not Found: 
ERROR - 2020-08-25 11:15:17 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 13:26:40 --> 404 Page Not Found: media/views
ERROR - 2020-08-25 13:26:40 --> 404 Page Not Found: media/views
ERROR - 2020-08-25 13:32:52 --> Severity: error --> Exception: Call to a member function replace_apply_mission_judge() on null /opt/bitnami/apps/dev-percommunity/www/application/controllers/Mission.php 260
ERROR - 2020-08-25 13:34:45 --> Severity: error --> Exception: Call to a member function replace_apply_mission_judge() on null /opt/bitnami/apps/dev-percommunity/www/application/controllers/Mission.php 262
ERROR - 2020-08-25 14:46:02 --> Query error: Unknown column 'rs_media.med_idx' in 'where clause' - Invalid query: SELECT *
FROM `rs_media`
LEFT OUTER JOIN `rs_mission_apply` `rs_apply` ON `rs_apply`.`med_id` = `rs_media`.`med_id`
LEFT OUTER JOIN `rs_judge` ON `rs_judge`.`jud_mis_id` = `rs_apply`.`mis_id` AND `rs_judge`.`jud_deletion` = 'N' AND `rs_judge`.`jud_jug_id` = 1 AND `rs_judge`.`jud_mis_id` = 17
WHERE `rs_media`.`med_idx` = '35'
AND `rs_media`.`med_deletion` = 'N'
AND `rs_media`.`mem_id` = '7'
ORDER BY ISNULL(rs_judge.jud_wdate) ASC, `rs_judge`.`jud_wdate` DESC
ERROR - 2020-08-25 14:46:02 --> Severity: error --> Exception: Call to a member function row_array() on bool /opt/bitnami/apps/dev-percommunity/www/application/models/RS_judge_model.php 273
ERROR - 2020-08-25 14:53:28 --> Query error: Unknown column 'rs_media.med_idx' in 'where clause' - Invalid query: SELECT *
FROM `rs_media`
LEFT OUTER JOIN `rs_mission_apply` `rs_apply` ON `rs_apply`.`med_id` = `rs_media`.`med_id`
LEFT OUTER JOIN `rs_judge` ON `rs_judge`.`jud_mis_id` = `rs_apply`.`mis_id` AND `rs_judge`.`jud_deletion` = 'N' AND `rs_judge`.`jud_jug_id` = 1 AND `rs_judge`.`jud_mis_id` = 17
WHERE `rs_media`.`med_idx` = '35'
AND `rs_media`.`med_deletion` = 'N'
AND `rs_media`.`mem_id` = '7'
ORDER BY ISNULL(rs_judge.jud_wdate) ASC, `rs_judge`.`jud_wdate` DESC
ERROR - 2020-08-25 14:53:28 --> Severity: error --> Exception: Call to a member function row_array() on bool /opt/bitnami/apps/dev-percommunity/www/application/models/RS_judge_model.php 273
ERROR - 2020-08-25 14:54:00 --> Severity: error --> Exception: Too few arguments to function CI_DB_driver::query(), 0 passed in /opt/bitnami/apps/dev-percommunity/www/application/models/RS_judge_model.php on line 274 and at least 1 expected /opt/bitnami/apps/dev-percommunity/www/_system/database/DB_driver.php 608
ERROR - 2020-08-25 14:56:03 --> Query error: Unknown column 'jud_med_wht_it' in 'field list' - Invalid query: INSERT INTO `rs_judge` (`jud_jug_id`, `jud_mis_id`, `jud_med_id`, `jud_attach`, `jud_mem_id`, `jud_register_ip`, `jud_wdate`, `jud_med_name`, `jud_med_admin`, `jud_med_wht_it`, `jud_med_url`) VALUES (1, '17', NULL, '2020/08/2c50b4b920fc2017fe82ec7a6c2c9932.jpg', '7', '59.26.134.158', '2020-08-25 14:56:03', '카카오톡 미디어 등록 테스트', 'RS MAN', '2', 'http://kakao.com/rs_man')
ERROR - 2020-08-25 14:56:03 --> Query error: Table 'CIC_DEV.rs_apply' doesn't exist - Invalid query: INSERT INTO `rs_apply` (`med_id`, `mis_id`) VALUES (NULL, '17')
ERROR - 2020-08-25 14:56:03 --> Query error: Unknown column 'jud_med_wht_it' in 'field list' - Invalid query: INSERT INTO `rs_judge` (`jud_jug_id`, `jud_mis_id`, `jud_med_id`, `jud_attach`, `jud_mem_id`, `jud_register_ip`, `jud_wdate`, `jud_med_name`, `jud_med_admin`, `jud_med_wht_it`, `jud_med_url`) VALUES (1, '17', NULL, '2020/08/c5737932055dbc333606ca64aa3c336c.jpg', '7', '59.26.134.158', '2020-08-25 14:56:03', '배고픈 테스트', '곧 죽어요', '1', 'http://fb.com/imhungry')
ERROR - 2020-08-25 14:56:03 --> Query error: Table 'CIC_DEV.rs_apply' doesn't exist - Invalid query: INSERT INTO `rs_apply` (`med_id`, `mis_id`) VALUES (NULL, '17')
ERROR - 2020-08-25 14:56:26 --> Query error: Unknown column 'jud_med_wht_it' in 'field list' - Invalid query: INSERT INTO `rs_judge` (`jud_jug_id`, `jud_mis_id`, `jud_med_id`, `jud_attach`, `jud_mem_id`, `jud_register_ip`, `jud_wdate`, `jud_med_name`, `jud_med_admin`, `jud_med_wht_it`, `jud_med_url`) VALUES (1, '17', NULL, '2020/08/f3d93dfb413a7f53b84d2180177d8829.jpg', '7', '59.26.134.158', '2020-08-25 14:56:26', '카카오톡 미디어 등록 테스트', 'RS MAN', '2', 'http://kakao.com/rs_man')
ERROR - 2020-08-25 14:56:26 --> Query error: Table 'CIC_DEV.rs_apply' doesn't exist - Invalid query: INSERT INTO `rs_apply` (`med_id`, `mis_id`) VALUES (NULL, '17')
ERROR - 2020-08-25 14:56:26 --> Query error: Unknown column 'jud_med_wht_it' in 'field list' - Invalid query: INSERT INTO `rs_judge` (`jud_jug_id`, `jud_mis_id`, `jud_med_id`, `jud_attach`, `jud_mem_id`, `jud_register_ip`, `jud_wdate`, `jud_med_name`, `jud_med_admin`, `jud_med_wht_it`, `jud_med_url`) VALUES (1, '17', NULL, '2020/08/185a0d17cad356d89f2cc1dc5aa9b43d.jpg', '7', '59.26.134.158', '2020-08-25 14:56:26', '배고픈 테스트', '곧 죽어요', '1', 'http://fb.com/imhungry')
ERROR - 2020-08-25 14:56:26 --> Query error: Table 'CIC_DEV.rs_apply' doesn't exist - Invalid query: INSERT INTO `rs_apply` (`med_id`, `mis_id`) VALUES (NULL, '17')
ERROR - 2020-08-25 14:57:35 --> Query error: Unknown column 'jud_med_wht_it' in 'field list' - Invalid query: INSERT INTO `rs_judge` (`jud_jug_id`, `jud_mis_id`, `jud_med_id`, `jud_attach`, `jud_mem_id`, `jud_register_ip`, `jud_wdate`, `jud_med_name`, `jud_med_admin`, `jud_med_wht_it`, `jud_med_url`) VALUES (1, '17', NULL, '2020/08/c991c51526cbab4cdf83b928eb31c110.jpg', '7', '59.26.134.158', '2020-08-25 14:57:35', '카카오톡 미디어 등록 테스트', 'RS MAN', '2', 'http://kakao.com/rs_man')
ERROR - 2020-08-25 14:57:35 --> Query error: Table 'CIC_DEV.rs_apply' doesn't exist - Invalid query: INSERT INTO `rs_apply` (`med_id`, `mis_id`) VALUES (NULL, '17')
ERROR - 2020-08-25 14:57:35 --> Query error: Unknown column 'jud_med_wht_it' in 'field list' - Invalid query: INSERT INTO `rs_judge` (`jud_jug_id`, `jud_mis_id`, `jud_med_id`, `jud_attach`, `jud_mem_id`, `jud_register_ip`, `jud_wdate`, `jud_med_name`, `jud_med_admin`, `jud_med_wht_it`, `jud_med_url`) VALUES (1, '17', NULL, '2020/08/bd7d4718f5b91a11743932dca62474c2.jpg', '7', '59.26.134.158', '2020-08-25 14:57:35', '배고픈 테스트', '곧 죽어요', '1', 'http://fb.com/imhungry')
ERROR - 2020-08-25 14:57:35 --> Query error: Table 'CIC_DEV.rs_apply' doesn't exist - Invalid query: INSERT INTO `rs_apply` (`med_id`, `mis_id`) VALUES (NULL, '17')
ERROR - 2020-08-25 14:57:35 --> Query error: Unknown column 'jul_datetime' in 'field list' - Invalid query: INSERT INTO `rs_mission_apply` (`jul_datetime`, `jul_ip`, `jul_jud_id`, `jul_jug_id`, `jul_med_id`, `jul_mem_id`, `jul_state`, `jul_user_id`, `jul_useragent`) VALUES ('2020-08-25 14:57:35','59.26.134.158',0,1,NULL,'7',1,'-social_wweeq501','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36'), ('2020-08-25 14:57:35','59.26.134.158',0,1,NULL,'7',1,'-social_wweeq501','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36')
ERROR - 2020-08-25 14:59:14 --> Query error: Unknown column 'jud_med_wht_it' in 'field list' - Invalid query: INSERT INTO `rs_judge` (`jud_jug_id`, `jud_mis_id`, `jud_med_id`, `jud_attach`, `jud_mem_id`, `jud_register_ip`, `jud_wdate`, `jud_med_name`, `jud_med_admin`, `jud_med_wht_it`, `jud_med_url`) VALUES (1, '17', NULL, '2020/08/25b1fb1db7dc9d75ae42222c992526f5.jpg', '7', '59.26.134.158', '2020-08-25 14:59:14', '카카오톡 미디어 등록 테스트', 'RS MAN', '2', 'http://kakao.com/rs_man')
ERROR - 2020-08-25 14:59:14 --> Query error: Table 'CIC_DEV.rs_apply' doesn't exist - Invalid query: INSERT INTO `rs_apply` (`med_id`, `mis_id`) VALUES (NULL, '17')
ERROR - 2020-08-25 14:59:14 --> Query error: Unknown column 'jud_med_wht_it' in 'field list' - Invalid query: INSERT INTO `rs_judge` (`jud_jug_id`, `jud_mis_id`, `jud_med_id`, `jud_attach`, `jud_mem_id`, `jud_register_ip`, `jud_wdate`, `jud_med_name`, `jud_med_admin`, `jud_med_wht_it`, `jud_med_url`) VALUES (1, '17', NULL, '2020/08/b7f8179e33d0fc2296e1c5970ce1eda5.jpg', '7', '59.26.134.158', '2020-08-25 14:59:14', '배고픈 테스트', '곧 죽어요', '1', 'http://fb.com/imhungry')
ERROR - 2020-08-25 14:59:14 --> Query error: Table 'CIC_DEV.rs_apply' doesn't exist - Invalid query: INSERT INTO `rs_apply` (`med_id`, `mis_id`) VALUES (NULL, '17')
ERROR - 2020-08-25 15:00:00 --> 404 Page Not Found: media/views
ERROR - 2020-08-25 15:00:01 --> 404 Page Not Found: media/views
ERROR - 2020-08-25 15:01:51 --> Query error: Unknown column 'jud_med_wht_it' in 'field list' - Invalid query: INSERT INTO `rs_judge` (`jud_jug_id`, `jud_mis_id`, `jud_med_id`, `jud_attach`, `jud_mem_id`, `jud_register_ip`, `jud_wdate`, `jud_med_name`, `jud_med_admin`, `jud_med_wht_it`, `jud_med_url`) VALUES (1, '17', NULL, '', '7', '59.26.134.158', '2020-08-25 15:01:51', '미션 신청용', 'mission', '2', 'http://kakao.com/mission_apply_test')
ERROR - 2020-08-25 15:01:51 --> Query error: Table 'CIC_DEV.rs_apply' doesn't exist - Invalid query: INSERT INTO `rs_apply` (`med_id`, `mis_id`) VALUES (NULL, '17')
ERROR - 2020-08-25 15:08:56 --> Query error: Unknown column 'jud_med_wht_it' in 'field list' - Invalid query: INSERT INTO `rs_judge` (`jud_jug_id`, `jud_mis_id`, `jud_med_id`, `jud_attach`, `jud_mem_id`, `jud_register_ip`, `jud_wdate`, `jud_med_name`, `jud_med_admin`, `jud_med_wht_it`, `jud_med_url`) VALUES (1, '17', NULL, '', '7', '59.26.134.158', '2020-08-25 15:08:55', '미션 신청용', 'mission', '2', 'http://kakao.com/mission_apply_test')
ERROR - 2020-08-25 15:09:43 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 15:09:45 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 15:09:50 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 15:10:01 --> Query error: Unknown column 'jud_med_wht_it' in 'field list' - Invalid query: INSERT INTO `rs_judge` (`jud_jug_id`, `jud_mis_id`, `jud_med_id`, `jud_attach`, `jud_mem_id`, `jud_register_ip`, `jud_wdate`, `jud_med_name`, `jud_med_admin`, `jud_med_wht_it`, `jud_med_url`) VALUES (1, '17', NULL, '', '7', '59.26.134.158', '2020-08-25 15:10:01', '미션 신청용', 'mission', '2', 'http://kakao.com/mission_apply_test')
ERROR - 2020-08-25 15:10:54 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 15:10:56 --> Query error: Unknown column 'jud_med_wht_it' in 'field list' - Invalid query: INSERT INTO `rs_judge` (`jud_jug_id`, `jud_mis_id`, `jud_med_id`, `jud_attach`, `jud_mem_id`, `jud_register_ip`, `jud_wdate`, `jud_med_name`, `jud_med_admin`, `jud_med_wht_it`, `jud_med_url`) VALUES (1, '17', NULL, '2020/08/99fd8fb9cdac70b52d81638d15a91157.jpg', '7', '59.26.134.158', '2020-08-25 15:10:56', '미션 신청용', 'mission', '2', 'http://kakao.com/mission_apply_test')
ERROR - 2020-08-25 15:11:23 --> Query error: Unknown column 'jud_med_wht_it' in 'field list' - Invalid query: INSERT INTO `rs_judge` (`jud_jug_id`, `jud_mis_id`, `jud_med_id`, `jud_attach`, `jud_mem_id`, `jud_register_ip`, `jud_wdate`, `jud_med_name`, `jud_med_admin`, `jud_med_wht_it`, `jud_med_url`) VALUES (1, '17', NULL, '2020/08/c07e7575c2e7ca44884f1fe91a1384cd.jpg', '7', '59.26.134.158', '2020-08-25 15:11:23', '미션 신청용', 'mission', '2', 'http://kakao.com/mission_apply_test')
ERROR - 2020-08-25 15:15:27 --> Query error: Unknown column 'jud_med_wht_it' in 'field list' - Invalid query: INSERT INTO `rs_judge` (`jud_jug_id`, `jud_mis_id`, `jud_med_id`, `jud_attach`, `jud_mem_id`, `jud_register_ip`, `jud_wdate`, `jud_med_name`, `jud_med_admin`, `jud_med_wht_it`, `jud_med_url`) VALUES (1, '17', '37', '2020/08/36c3f4662e9db16bdd443a6f74894074.jpg', '7', '59.26.134.158', '2020-08-25 15:15:27', '미션 신청용', 'mission', '2', 'http://kakao.com/mission_apply_test')
ERROR - 2020-08-25 15:15:27 --> Query error: Table 'CIC_DEV.rs_apply' doesn't exist - Invalid query: INSERT INTO `rs_apply` (`med_id`, `mis_id`) VALUES ('37', '17')
ERROR - 2020-08-25 15:16:42 --> Query error: Unknown column 'jud_med_wht_it' in 'field list' - Invalid query: INSERT INTO `rs_judge` (`jud_jug_id`, `jud_mis_id`, `jud_med_id`, `jud_attach`, `jud_mem_id`, `jud_register_ip`, `jud_wdate`, `jud_med_name`, `jud_med_admin`, `jud_med_wht_it`, `jud_med_url`) VALUES (1, '17', '37', '2020/08/94e2436b6874929d41aa739105b849b4.jpg', '7', '59.26.134.158', '2020-08-25 15:16:42', '미션 신청용', 'mission', '2', 'http://kakao.com/mission_apply_test')
ERROR - 2020-08-25 15:26:22 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 15:27:22 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 15:29:43 --> Severity: error --> Exception: Call to a member function get_whitelist_list() on null /opt/bitnami/apps/dev-percommunity/www/application/controllers/admin/cic/Setting.php 324
ERROR - 2020-08-25 15:29:43 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 15:30:59 --> Severity: error --> Exception: Call to a member function get_whitelist_list() on null /opt/bitnami/apps/dev-percommunity/www/application/controllers/admin/cic/Setting.php 324
ERROR - 2020-08-25 15:38:22 --> 404 Page Not Found: setting/whitelist
ERROR - 2020-08-25 15:38:22 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 15:40:39 --> 404 Page Not Found: setting/whitelist
ERROR - 2020-08-25 15:44:51 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 15:44:59 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 15:45:06 --> Query error: Unknown column 'met_deletion' in 'field list' - Invalid query: UPDATE `rs_whitelist` SET `met_deletion` = 'Y'
WHERE `wht_id` = '11'
ERROR - 2020-08-25 16:14:37 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 16:14:41 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 16:17:53 --> Severity: Warning --> Creating default object from empty value /opt/bitnami/apps/dev-percommunity/www/application/controllers/admin/cic/Setting.php 180
ERROR - 2020-08-25 16:17:53 --> Severity: error --> Exception: Call to undefined method stdClass::get_list() /opt/bitnami/apps/dev-percommunity/www/application/controllers/admin/cic/Setting.php 184
ERROR - 2020-08-25 16:20:13 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 16:57:40 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 16:58:55 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 16:58:56 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 16:58:57 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:03:16 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:03:17 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:03:27 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:05:04 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:05:13 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:05:14 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:05:22 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:05:24 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:06:31 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:13:23 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:17:57 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 17:18:59 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 17:19:00 --> 404 Page Not Found: 
ERROR - 2020-08-25 17:19:01 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 17:20:11 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 17:21:39 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:21:44 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:21:53 --> 404 Page Not Found: 
ERROR - 2020-08-25 17:21:54 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 17:22:02 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 17:22:16 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 17:22:40 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:22:47 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:23:11 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:23:28 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:24:24 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 17:24:38 --> 404 Page Not Found: 
ERROR - 2020-08-25 17:24:39 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 17:25:29 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 17:25:44 --> 404 Page Not Found: 
ERROR - 2020-08-25 17:25:46 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 131
ERROR - 2020-08-25 17:30:11 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 132
ERROR - 2020-08-25 17:32:19 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 132
ERROR - 2020-08-25 17:32:50 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 17:33:03 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 132
ERROR - 2020-08-25 17:34:10 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 132
ERROR - 2020-08-25 17:38:47 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 132
ERROR - 2020-08-25 17:40:18 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 132
ERROR - 2020-08-25 17:40:26 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 132
ERROR - 2020-08-25 17:41:02 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 132
ERROR - 2020-08-25 17:46:33 --> Severity: Warning --> nl2br() expects parameter 1 to be string, array given /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 67
ERROR - 2020-08-25 17:46:33 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 132
ERROR - 2020-08-25 17:47:07 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 132
ERROR - 2020-08-25 17:59:10 --> 404 Page Not Found: 
ERROR - 2020-08-25 17:59:10 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 132
ERROR - 2020-08-25 18:00:23 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 132
ERROR - 2020-08-25 18:34:06 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 18:55:40 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 18:55:58 --> Severity: error --> Exception: Call to undefined method RS_whitelist_model::result() /opt/bitnami/apps/dev-percommunity/www/application/controllers/admin/cic/Judgemission.php 274
ERROR - 2020-08-25 19:09:18 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 19:09:19 --> 404 Page Not Found: Apple-touch-icon-precomposedpng/index
ERROR - 2020-08-25 19:09:19 --> 404 Page Not Found: Apple-touch-iconpng/index
ERROR - 2020-08-25 19:09:19 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 19:09:19 --> 404 Page Not Found: Apple-touch-icon-precomposedpng/index
ERROR - 2020-08-25 19:09:19 --> 404 Page Not Found: Apple-touch-iconpng/index
ERROR - 2020-08-25 19:09:19 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 19:09:19 --> 404 Page Not Found: Apple-touch-icon-precomposedpng/index
ERROR - 2020-08-25 19:09:19 --> 404 Page Not Found: Apple-touch-iconpng/index
ERROR - 2020-08-25 19:09:19 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 19:09:19 --> 404 Page Not Found: Apple-touch-icon-precomposedpng/index
ERROR - 2020-08-25 19:09:19 --> 404 Page Not Found: Apple-touch-iconpng/index
ERROR - 2020-08-25 19:09:19 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 19:12:40 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 19:12:40 --> 404 Page Not Found: Apple-touch-icon-precomposedpng/index
ERROR - 2020-08-25 19:12:40 --> 404 Page Not Found: Apple-touch-iconpng/index
ERROR - 2020-08-25 19:12:41 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 19:13:17 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 19:13:18 --> 404 Page Not Found: Apple-touch-icon-precomposedpng/index
ERROR - 2020-08-25 19:13:18 --> 404 Page Not Found: Apple-touch-iconpng/index
ERROR - 2020-08-25 19:13:18 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 19:13:18 --> 404 Page Not Found: Apple-touch-icon-precomposedpng/index
ERROR - 2020-08-25 19:13:18 --> 404 Page Not Found: Apple-touch-iconpng/index
ERROR - 2020-08-25 19:13:18 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 19:13:18 --> 404 Page Not Found: Apple-touch-icon-precomposedpng/index
ERROR - 2020-08-25 19:13:18 --> 404 Page Not Found: Apple-touch-iconpng/index
ERROR - 2020-08-25 19:13:18 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 19:13:18 --> 404 Page Not Found: Apple-touch-icon-precomposedpng/index
ERROR - 2020-08-25 19:13:18 --> 404 Page Not Found: Apple-touch-iconpng/index
ERROR - 2020-08-25 19:13:18 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 19:13:56 --> 404 Page Not Found: Apple-touch-icon-precomposedpng/index
ERROR - 2020-08-25 19:13:56 --> 404 Page Not Found: Apple-touch-iconpng/index
ERROR - 2020-08-25 19:13:58 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 19:14:00 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 19:14:02 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-08-25 19:14:03 --> Severity: Warning --> Invalid argument supplied for foreach() /opt/bitnami/apps/dev-percommunity/www/views/admin/basic/cic/judgewithdraw/index.php 132
ERROR - 2020-08-25 19:14:03 --> 404 Page Not Found: Faviconico/index
