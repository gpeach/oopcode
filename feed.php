<html>
<head>
<title>RSS Feed</title>
</head>
<body>
<?php
//point to an xml file
$feed = "http://z.about.com/6/g/classicalmusic/b/index.xml";
//create object
$sxml = simplexml_load_file($feed);
foreach ($sxml->attributes() as $key => $value){
  echo "<p>RSS $key $value</p>\n";
}
echo "<h2>". $sxml->channel->title. "</h2>\n";
//below won't work
//echo "<h2>$sxml->channel->title</h2>\n";
//may use the syntax below
//echo "<h2>{$sxml->channel->title}</h2>\n";
echo "<p>\n";
//iterate through items
foreach ($sxml->channel->item as $item){
  $strtemp = "<a href=\"$item->link\">".
    "$item->title</a> $item->description<br /><br />\n";
  echo $strtemp;
}
echo "</p>\n";
?>
</body>
</html>
