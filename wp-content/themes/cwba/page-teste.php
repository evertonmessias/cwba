<?php
echo "TESTESSSS";
/*
$id1 = 373;
$id2 = 374;
$id3 = 375;
$id4 = 376;
$id5 = 377;
$id6 = 378;

$titulo1 = 'Aula 2 - Inserindo recursos dinâmicos';
$titulo2 = 'Aula 3 - Gerenciando temas';
$titulo3 = 'Aula 4 - Personalizar temas';
$titulo4 = 'Aula 5 - Plugins';
$titulo5 = 'Aula 6 - Editores especiais';
$titulo6 = 'Aula 7 - Configurações e usuários';

$slug1 = sanitize_title($titulo1);
$slug2 = sanitize_title($titulo2);
$slug3 = sanitize_title($titulo3);
$slug4 = sanitize_title($titulo4);
$slug5 = sanitize_title($titulo5);
$slug6 = sanitize_title($titulo6);

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

global $wpdb;

$sql = "INSERT INTO wp_posts values 
($id1,'1','2022-11-07 12:00:00','2022-11-07 12:00:00','','$titulo1','','publish','open','open','','$slug1','','','2022-11-07 12:00:00','2022-11-07 12:00:00','','0','/?p=$id1','0','post','','0'),
($id2,'1','2022-11-07 12:00:00','2022-11-07 12:00:00','','$titulo2','','publish','open','open','','$slug2','','','2022-11-07 12:00:00','2022-11-07 12:00:00','','0','/?p=$id2','0','post','','0'),
($id3,'1','2022-11-07 12:00:00','2022-11-07 12:00:00','','$titulo3','','publish','open','open','','$slug3','','','2022-11-07 12:00:00','2022-11-07 12:00:00','','0','/?p=$id3','0','post','','0'),
($id4,'1','2022-11-07 12:00:00','2022-11-07 12:00:00','','$titulo4','','publish','open','open','','$slug4','','','2022-11-07 12:00:00','2022-11-07 12:00:00','','0','/?p=$id4','0','post','','0'),
($id5,'1','2022-11-07 12:00:00','2022-11-07 12:00:00','','$titulo5','','publish','open','open','','$slug5','','','2022-11-07 12:00:00','2022-11-07 12:00:00','','0','/?p=$id5','0','post','','0'),
($id6,'1','2022-11-07 12:00:00','2022-11-07 12:00:00','','$titulo6','','publish','open','open','','$slug6','','','2022-11-07 12:00:00','2022-11-07 12:00:00','','0','/?p=$id6','0','post','','0')";

dbDelta($sql);
