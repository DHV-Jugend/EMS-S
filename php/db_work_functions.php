<?php
function fill_costom_emss(){
	global $wpdb;
	$wpdb->query("INSERT INTO wp_emss (tbid, id, value_type, value_data) VALUES
(1, 0, 'type', 'config'),
(2, 0, 'affected', 'config'),
(3, 0, 'id', 'adminmenu'),
(4, 0, 'show_data', '1'),
(5, 0, 'show_ERRORS', '1'),
(138, 1, 'type', 'skip'),
(139, 1, 'affected', 'user'),
(140, 1, 'id', '79'),
(141, 1, 'info', 'deaduser'),
(142, 2, 'type', 'skip'),
(143, 2, 'affected', 'user'),
(144, 2, 'id', '114'),
(145, 2, 'info', 'deaduser'),
(146, 3, 'type', 'skip'),
(147, 3, 'affected', 'user'),
(148, 3, 'id', '108'),
(149, 3, 'info', 'deaduser'),
(150, 4, 'type', 'skip'),
(151, 4, 'affected', 'user'),
(152, 4, 'id', '116'),
(153, 4, 'info', 'deaduser'),
(154, 5, 'type', 'skip'),
(155, 5, 'affected', 'user'),
(156, 5, 'id', '124'),
(157, 5, 'info', 'deaduser'),
(158, 6, 'type', 'skip'),
(159, 6, 'affected', 'user'),
(160, 6, 'id', '142'),
(161, 6, 'info', 'deaduser'),
(162, 7, 'type', 'skip'),
(163, 7, 'affected', 'user'),
(164, 7, 'id', '144'),
(165, 7, 'info', 'deaduser'),
(166, 8, 'type', 'skip'),
(167, 8, 'affected', 'user'),
(168, 8, 'id', '151'),
(169, 8, 'info', 'deaduser'),
(170, 9, 'type', 'skip'),
(171, 9, 'affected', 'user'),
(172, 9, 'id', '158'),
(173, 9, 'info', 'deaduser'),
(174, 10, 'type', 'skip'),
(175, 10, 'affected', 'user'),
(176, 10, 'id', '170'),
(177, 10, 'info', 'deaduser'),
(178, 11, 'type', 'skip'),
(179, 11, 'affected', 'user'),
(180, 11, 'id', '186'),
(181, 11, 'info', 'deaduser'),
(182, 12, 'type', 'skip'),
(183, 12, 'affected', 'user'),
(184, 12, 'id', '192'),
(185, 12, 'info', 'deaduser'),
(186, 13, 'type', 'skip'),
(187, 13, 'affected', 'user'),
(188, 13, 'id', '206'),
(189, 13, 'info', 'deaduser'),
(190, 14, 'type', 'skip'),
(191, 14, 'affected', 'user'),
(192, 14, 'id', '209'),
(193, 14, 'info', 'deaduser'),
(194, 15, 'type', 'skip'),
(195, 15, 'affected', 'user'),
(196, 15, 'id', '216'),
(197, 15, 'info', 'deaduser'),
(198, 16, 'type', 'skip'),
(199, 16, 'affected', 'user'),
(200, 16, 'id', '221'),
(201, 16, 'info', 'deaduser'),
(202, 17, 'type', 'skip'),
(203, 17, 'affected', 'user'),
(204, 17, 'id', '222'),
(205, 17, 'info', 'deaduser'),
(206, 18, 'type', 'skip'),
(207, 18, 'affected', 'user'),
(208, 18, 'id', '225'),
(209, 18, 'info', 'deaduser'),
(210, 19, 'type', 'skip'),
(211, 19, 'affected', 'user'),
(212, 19, 'id', '230'),
(213, 19, 'info', 'deaduser'),
(214, 20, 'type', 'skip'),
(215, 20, 'affected', 'user'),
(216, 20, 'id', '237'),
(217, 20, 'info', 'deaduser'),
(218, 21, 'type', 'skip'),
(219, 21, 'affected', 'user'),
(220, 21, 'id', '242'),
(221, 21, 'info', 'deaduser'),
(222, 22, 'type', 'skip'),
(223, 22, 'affected', 'user'),
(224, 22, 'id', '257'),
(225, 22, 'info', 'deaduser'),
(226, 23, 'type', 'skip'),
(227, 23, 'affected', 'user'),
(228, 23, 'id', '263'),
(229, 23, 'info', 'deaduser'),
(230, 24, 'type', 'skip'),
(231, 24, 'affected', 'user'),
(232, 24, 'id', '272'),
(233, 24, 'info', 'deaduser'),
(234, 25, 'type', 'skip'),
(235, 25, 'affected', 'user'),
(236, 25, 'id', '273'),
(237, 25, 'info', 'deaduser'),
(238, 26, 'type', 'skip'),
(239, 26, 'affected', 'user'),
(240, 26, 'id', '287'),
(241, 26, 'info', 'deaduser'),
(242, 27, 'type', 'skip'),
(243, 27, 'affected', 'user'),
(244, 27, 'id', '293'),
(245, 27, 'info', 'deaduser'),
(246, 28, 'type', 'skip'),
(247, 28, 'affected', 'user'),
(248, 28, 'id', '308'),
(249, 28, 'info', 'deaduser'),
(250, 29, 'type', 'skip'),
(251, 29, 'affected', 'user'),
(252, 29, 'id', '321'),
(253, 29, 'info', 'deaduser'),
(254, 30, 'type', 'skip'),
(255, 30, 'affected', 'user'),
(256, 30, 'id', '330'),
(257, 30, 'info', 'deaduser'),
(258, 31, 'type', 'skip'),
(259, 31, 'affected', 'user'),
(260, 31, 'id', '333'),
(261, 31, 'info', 'deaduser'),
(262, 32, 'type', 'skip'),
(263, 32, 'affected', 'user'),
(264, 32, 'id', '336'),
(265, 32, 'info', 'deaduser'),
(266, 33, 'type', 'skip'),
(267, 33, 'affected', 'user'),
(268, 33, 'id', '79'),
(269, 33, 'info', 'deaduser'),
(270, 34, 'type', 'skip'),
(271, 34, 'affected', 'user'),
(272, 34, 'id', '108'),
(273, 34, 'info', 'deaduser'),
(274, 35, 'type', 'skip'),
(275, 35, 'affected', 'user'),
(276, 35, 'id', '114'),
(277, 35, 'info', 'deaduser'),
(278, 36, 'type', 'skip'),
(279, 36, 'affected', 'user'),
(280, 36, 'id', '116'),
(281, 36, 'info', 'deaduser'),
(282, 37, 'type', 'skip'),
(283, 37, 'affected', 'user'),
(284, 37, 'id', '124'),
(285, 37, 'info', 'deaduser'),
(286, 38, 'type', 'skip'),
(287, 38, 'affected', 'user'),
(288, 38, 'id', '142'),
(289, 38, 'info', 'deaduser'),
(290, 39, 'type', 'skip'),
(291, 39, 'affected', 'user'),
(292, 39, 'id', '144'),
(293, 39, 'info', 'deaduser'),
(294, 40, 'type', 'skip'),
(295, 40, 'affected', 'user'),
(296, 40, 'id', '151'),
(297, 40, 'info', 'deaduser'),
(298, 41, 'type', 'skip'),
(299, 41, 'affected', 'user'),
(300, 41, 'id', '158'),
(301, 41, 'info', 'deaduser'),
(302, 42, 'type', 'skip'),
(303, 42, 'affected', 'user'),
(304, 42, 'id', '170'),
(305, 42, 'info', 'deaduser'),
(306, 43, 'type', 'skip'),
(307, 43, 'affected', 'user'),
(308, 43, 'id', '186'),
(309, 43, 'info', 'deaduser'),
(310, 44, 'type', 'skip'),
(311, 44, 'affected', 'user'),
(312, 44, 'id', '192'),
(313, 44, 'info', 'deaduser'),
(314, 45, 'type', 'skip'),
(315, 45, 'affected', 'user'),
(316, 45, 'id', '206'),
(317, 45, 'info', 'deaduser'),
(318, 46, 'type', 'skip'),
(319, 46, 'affected', 'user'),
(320, 46, 'id', '209'),
(321, 46, 'info', 'deaduser'),
(322, 47, 'type', 'skip'),
(323, 47, 'affected', 'user'),
(324, 47, 'id', '216'),
(325, 47, 'info', 'deaduser'),
(334, 48, 'type', 'skip'),
(335, 48, 'affected', 'user'),
(336, 48, 'id', '88'),
(337, 48, 'info', 'gelöscht'),
(338, 49, 'type', 'add'),
(339, 49, 'affected', 'page'),
(340, 49, 'id', '2662'),
(341, 49, 'data', '{\"ems_start_date\":1501891200,\"ems_end_date\":1502582400,\"year\":2017,\"name\":\"b-schein\"}'),
(342, 49, 'info', 'Gelösche durch ???'),
(343, 50, 'type', 'skip'),
(344, 50, 'affected', 'user'),
(345, 50, 'id', '337'),
(346, 50, 'info', 'Gelöschter user'),
(347, 51, 'type', 'skip'),
(348, 51, 'affected', 'user'),
(349, 51, 'id', '30'),
(350, 51, 'info', 'Gelöschter user'),
(351, 52, 'type', 'skip'),
(352, 52, 'affected', 'user'),
(353, 52, 'id', '30'),
(354, 52, 'info', 'Gelöschter user'),
(355, 53, 'type', 'skip'),
(356, 53, 'affected', 'user'),
(357, 53, 'id', '30'),
(358, 53, 'info', 'Gelöschter user'),
(359, 54, 'type', 'skip'),
(360, 54, 'affected', 'user'),
(361, 54, 'id', '30'),
(362, 54, 'info', 'Gelöschter user'),
(363, 55, 'type', 'skip'),
(364, 55, 'affected', 'user'),
(365, 55, 'id', '30'),
(366, 55, 'info', 'Gelöschter user'),
(367, 56, 'type', 'skip'),
(368, 56, 'affected', 'user'),
(369, 56, 'id', '30'),
(370, 56, 'info', 'Gelöschter user'),
(371, 57, 'type', 'skip'),
(372, 57, 'affected', 'user'),
(373, 57, 'id', '30'),
(374, 57, 'info', 'Gelöschter user'),
(375, 58, 'type', 'skip'),
(376, 58, 'affected', 'user'),
(377, 58, 'id', '30'),
(378, 58, 'info', 'Gelöschter user'),
(379, 59, 'type', 'skip'),
(380, 59, 'affected', 'user'),
(381, 59, 'id', '30'),
(382, 59, 'info', 'Gelöschter user'),
(383, 60, 'type', 'skip'),
(384, 60, 'affected', 'user'),
(385, 60, 'id', '30'),
(386, 60, 'info', 'Gelöschter user');");
		
} // Will be insert to db on Installation. Cantains:found issues on DHV-Jugend EMS Database... --> Config data for skipping or configdata for EMSS 

function creat_DB_tables(){
	global $wpdb;
	global $wp;
	
	$datatable = $wpdb->prefix . 'emss';
    $wpdb->myhome_data = $datatable;

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $datatable (
		tbid mediumint(9) NOT NULL AUTO_INCREMENT,
    id int NOT NULL,
    value_type text NOT NULL,
    value_data text NOT NULL,
    	PRIMARY KEY  (tbid)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	
}

function write_line2emss($id, $type, $value){
	global $wpdb;
	$table = $wpdb->prefix .'emss';
	
	$wpdb->insert( $table, array( 
		'id'			=> $id,
		'value_type'	=> $type, 
		'value_data' 	=> $value 
	), 
	array( 
		'%d',
		'%s', 
		'%s' 
	), true  );
} // insert $id, $type, $value to DB _emss table as 'id'=>$id,'value_type'=>$type,'value_data'=>$value 

function insert2usermeta($id, $type, $data){
	global $wpdb;
	$table 	= $wpdb->prefix . "usermeta";  	
		
	$wpdb->insert( $table, array( 
		'user_id'			=> $id,
		'meta_key'	=> $type, 
		'meta_value' 	=> $data 
	), 
	array( 
		'%d',
		'%s', 
		'%s' 
	), true  );
	
} // insert to _usermeta table

function write2emss($type, $affected, $affectedid, $value , $data , $info = null){
	global $wpdb;
	$table_emss 		= $wpdb->prefix . "emss"; 
	$request="SELECT id FROM $table_emss GROUP BY id ORDER BY `wp_emss`.`id` DESC";
	
	$ids = 	$wpdb->get_results( $request, 'ARRAY_N' );
	$id=$ids[0][0]+1;
	
	write_line2emss($id, 'type', $type);
	write_line2emss($id, 'affected', $affected);
	write_line2emss($id, 'id', $affectedid);
	if ($value !==null) write_line2emss($id, 'value', $value);
	if ($data !==null) write_line2emss($id, 'data', $data);
	if ($info !==null)	write_line2emss($id, 'info', $info);
	
}  // inserts a new issue under new ID in _emss table

?>