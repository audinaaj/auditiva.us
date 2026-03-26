<?php
  // ### Uncomment these lines during website or server maintenance ###
  //ShowDownForMaintenanceMesg();
  //return;

  $clientaddress = $_SERVER['REMOTE_ADDR'];
  if (substr($clientaddress,0,7) == '192.168')
  {
    // Intranet Visitor
    //header("Location: http://192.168.0.2/en");   // permanent server
    //header("Location: http://www.acme.com/en");
    header("Location: ./web");
  } else {
    // Internet Visitor
    //header("Location: http://www.acme.com/en");
    header("Location: ./web");
  }

function ShowDownForMaintenanceMesg()
{
  echo '<img src="http://www.acme.com/myapp/web/img/frontpage/logo.png">';
  echo "<p>";
  echo "This site is down for maintenance. We apologize for the inconvenience. Please return in a few minutes.";
}
?>
