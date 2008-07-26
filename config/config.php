<?php

//// Server    //////////////////////////////////
$server_address = "fire.dynalias.org";
$email = "brian8181@gmail.com";

////  Database //////////////////////////////////
$db_name = "music";
$db_address = "192.168.81.50";
$db_user_name = "web";
$db_password = "sas*.0125";

/// Multi Server Mode ///////////////////////////
$db_servers = array("192.168.81", "localhost"); 

////  Customization /////////////////////////////
$site_name = "Music Web";
$style = "style.css";

////  Directory Locations ///////////////////////
// art location, relative to document root 
$art_location = "/music_web/.album_art";
// music location, relative to document root
$music_location = "/music";

////  Informational Stings /////////////////////////
// Server admin information, these do not affect  //
// actual functionality but they are disaplyed.   //
////////////////////////////////////////////////////
$mail_message = "for further information please email us @";
// global version 
$version = "0.0.1";
$version_date = "Sunday July 20 4:37 AM CDT 2008";
$index_title = "Music Database";
$search_title = "Search Database";
$advanced_title = "Advanced Search";
$results_title = "Search Results";
$details_title = "Song Details";

////  Options  ////////////////////////////////////
$enable_advanced = true;
$enable_statistics = true;
$enable_playlist = false;
$enable_logging = false;
// this features are not implemented and should remain off (false)
$enable_browse = false;
$enable_security = true;
// 0 or less = umlimited
$page_result_limit = 0;
	
?>