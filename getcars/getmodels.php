<?php
// header("content-type: text/plain; charset=utf-8");

$fh = file_get_contents("carmarks.txt");
preg_match_all('%<option\s*value="[^"]+"[^>]*>[^<]+<%si', $fh, $matches);

if(!file_exists("models_json"))
{
	mkdir("models_json");
}

$jsonString = "";

foreach($matches[0] as $match)
{
	preg_match('%<option\s*value="([^"]+)"[^>]*>([^<]+)<%si', $match, $mark);
	$markID = $mark[1];
	$markName = mb_strtolower($mark[2]);
	$url ="https://m.mobile.de/svc/r/models/$markID?_jsonp=_loadModels&_lang=pl";
	$json = file_get_contents($url);
	preg_match_all('%n":"([^"]+)"%Usi', $json, $data);
	$variations = [$markName => $data[1]];
	$jsonString .= json_encode($variations);

// 	$jh = fopen("models_json/all_cars.json", 'w');
// 	// echo $markName . "\n";
// 	fwrite($jh, $encoded);
// 	fclose($jh);
}

$jsonString = preg_replace("%\}\{%Usi", ',', $jsonString);
echo $jsonString;

?>