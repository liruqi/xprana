<?

$ch = curl_init();

$options = array(
	CURLOPT_URL => $_REQUEST['url'],
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_MAXREDIRS => 1,
	CURLOPT_HEADER => true,
	CURLOPT_NOBODY => true,
	CURLOPT_RETURNTRANSFER => true,
);

curl_setopt_array($ch, $options);
$head = curl_exec($ch);

$x = split("\r\n", $head);
foreach($x as $k => $v) {
	if(preg_match('/^Location: /', $v)){
		$to_url = trim(substr($v, strlen('Location:')));
		break;
	}
}

preg_match('/[0-9]+/', $to_url, $matches);
$id = sprintf('%09d', $matches[0]);
$img_url = 'http://i01.img.tudou.com/data/imgs/i/' . $id[0].$id[1].$id[2] . '/' . $id[3].$id[4].$id[5] . '/' . $id[6].$id[7].$id[8] . '/p.jpg';

$ch = curl_init();
$options = array(
	CURLOPT_URL => $img_url,
);
curl_setopt_array($ch, $options);
header('Content-type: image/jpg');
curl_exec($ch);
