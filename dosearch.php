<?php 
$criterion = @htmlentities($_GET["criterion"], ENT_NOQUOTES);
if(strpos($criterion, "\"")){
	$criterion = stripslashes($criterion);
	echo "<b>$criterion</b>"."</p><hr style=\"border:1px dotted black\" />";
}else{
	echo "\"<b>$criterion</b>\".</p><hr style=\"border:1px dotted black\" />";
}
//site here
$query = $criterion . " site:usgaymassage.com";
//your Google key goes here
$key = "AIzaSyBM9xR-N0iZqXBtW-wQX6_xFY1t_v8CoxM";
$maxresults = 8;
$start = 0;
try{
  $client = new SoapClient("http://api.google.com/GoogleSearch.wsdl");
  /*
  doGoogleSearchResponse  doGoogleSearch (string key, string q, int start, int
  maxResults, boolean filter, string restrict, boolean safeSearch, string lr,
  string ie, string oe)
  */
  $results = $client->doGoogleSearch($key, $query, $start, $maxresults, false,
      '',false, '','','' );
  /*
  GoogleSearchResults are made up of
  documentFiltering, searchComments, estimatedTotalResultsCount,
  estimateIsExact,  resultElements, searchQuery, startIndex, 
  endIndex, searchTips, directoryCategories, searchTime 
  */
  $searchtime = $results->searchTime;
  $total = $results->estimatedTotalResultsCount;
  if($total > 0){ 
    //retrieve the array of result elements
    $re = $results->resultElements;
    /*
    ResultElements are made up of
    summary, URL, snippet, title, cachedSize, relatedInformationPresent,
    hostName, directoryCategory, directoryTitle
    */   
    foreach ($re as $value){
      $strtemp = "<a href= \"$value->URL\"> ".
        " $value->URL</a> $value->snippet<br /><br />\n";
      echo $strtemp;
    }  
    echo "<hr style=\"border:1px dotted black\" />";
    echo "<br />Search time: $searchtime seconds.";
  }else{
    echo "<br /><br />Nothing found.";    
  }
}
catch (SOAPFault $exception){
  //echo $exception;
  echo "Could not process your request.";
}
?>

