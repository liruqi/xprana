<?php
$id = sprintf('%09d', $_REQUEST['id']);
$img_url = 'http://i01.img.tudou.com/data/imgs/i/' . $id[0].$id[1].$id[2] . '/' . $id[3].$id[4].$id[5] . '/' . $id[6].$id[7].$id[8] . '/p.jpg';

$ch = curl_init();
$options = array(
	CURLOPT_URL => $img_url,
);
curl_setopt_array($ch, $options);
header('Content-type: image/jpg');
curl_exec($ch);
