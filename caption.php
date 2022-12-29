<?php

# YouTube Transcriber

$url = $_GET['url'];
$url = json_decode('"' . $url.'"');
$url = "https://$url&fmt=json3";

$video = "http://youtube.com/v/" . preg_replace('/.*v=(.*?)&.*/', '$1', $url);
print "<pre>";
print "Transcript for <a href=$video target=_blank>$video</a><BR>";
print "Captions: <input value=\"".htmlspecialchars($url)."\" size=50><BR><BR>";

$data = file_get_contents($url);
$data = json_decode($data, 1);

$events = $data['events'];
foreach($events as $e){
  if(!$e['segs']) continue;
  foreach($e['segs'] as $seg){
    $words[] = $seg['utf8'];
  }
}

$text = implode('', $words);

# Replace every other new line.
#$text = preg_replace('#(.*?)\n(.*?)\n(.*?)\n(.*?)\n(.*?)\n(.*?)\n(.*?)\n(.*?)\n(.*?)\n#', "$1 $2 $3 $4 $5 $6 $7 $8 $9 $10\n", $text);

$text = str_replace(array("\n", "\r"), ' ', $text); 

print $text;
