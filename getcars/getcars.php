<?php
header("content-type: text/plain");

$fh = file_get_contents("carmarks.txt");
preg_match_all('%<option\s*value="[^"]+"[^>]*>[^<]+<%si', $fh, $matches);

if(!file_exists("mark_folder"))
{
	mkdir("mark_folder");
}

foreach($matches[0] as $match)
{
	preg_match('%<option\s*value="([^"]+)"[^>]*>([^<]+)<%si', $match, $mark);
	$markID = $mark[1];
	$markName = mb_strtolower($mark[2]);
	$url ="https://m.mobile.de/svc/r/models/$markID?_jsonp=_loadModels&_lang=pl";
	$json = file_get_contents($url);
	$jh = fopen("mark_folder/" . $markName . ".json", 'w');
	echo $markName . "\n";
	fwrite($jh, $json);
	fclose($jh);
}

?>