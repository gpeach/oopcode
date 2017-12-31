<?php
//point to an xml file
$feed = "http://www.sciencedaily.com/rss/health_medicine/illegal_drugs.xml";
//create object of SimpleXMLElement class
$sxml = simplexml_load_file($feed);

foreach ($sxml->attributes() as $key => $value){
echo "RSS $key $value";
}

echo "<h2>" . $sxml->channel->title . "</h2>\n";
//below won't work
//echo "<h2>$sxml->channel->title</h2>\n";
//may use the syntax below
//echo "<h2>{$sxml->channel->title}</h2>\n";echo "<p>\n";

//set counter and feed display limit
$i=1;
$limit=10;

// count total number of feed items
echo 'Total Feeds: '.count($sxml->channel->item).' Displaying: '.$limit.'<br /><br />';

//iterate through items as though an array
foreach ($sxml->channel->item as $item){
// limit number of feeds shown	
if($i<=$limit){
	$strtemp = $i.') '."<a href=\"$item->link\">"."$item->title</a> $item->description<br /><br />\n";
echo $strtemp;
$i+=1;
}
}
?>