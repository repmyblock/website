<?php
	$Menu = "voters";
	$BigMenu = "represent";	
	
#	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
#	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_trac.php";  
#	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }

	$rmb = new RepMyBlock();	
	$result = $rmb->ListTickets();
	
	echo "<PRE>" . print_r($result, 1) . "</PRE>";

	


?>	

<PRE>
	$_COOKIE['_ga']	GA1.2.1752540619.1592278215
	$_COOKIE['_gid']	GA1.2.1680524998.1612129997
	$_SERVER['USER']	www-data
	$_SERVER['HOME']	/var/www
	$_SERVER['HTTP_CACHE_CONTROL']	max-age=0
	$_SERVER['HTTP_UPGRADE_INSECURE_REQUESTS']	1
	$_SERVER['HTTP_COOKIE']	_ga=GA1.2.1752540619.1592278215; _gid=GA1.2.1680524998.1612129997
	$_SERVER['HTTP_CONNECTION']	keep-alive
	$_SERVER['HTTP_ACCEPT_ENCODING']	gzip, deflate, br
	$_SERVER['HTTP_ACCEPT_LANGUAGE']	en-US,en;q=0.5
	$_SERVER['HTTP_ACCEPT']	text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8
	$_SERVER['HTTP_USER_AGENT']	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:85.0) Gecko/20100101 Firefox/85.0
	$_SERVER['HTTP_HOST']	beta.repmyblock.nyc
	$_SERVER['REDIRECT_STATUS']	200
	$_SERVER['SERVER_NAME']	beta.repmyblock.nyc
	$_SERVER['SERVER_PORT']	443
	$_SERVER['SERVER_ADDR']	2600:3c03::f03c:92ff:fe30:2e9d
	$_SERVER['REMOTE_PORT']	57803
	$_SERVER['REMOTE_ADDR']	2001:470:88cd::938c
	$_SERVER['SERVER_SOFTWARE']	nginx/1.18.0
	$_SERVER['GATEWAY_INTERFACE']	CGI/1.1
	$_SERVER['HTTPS']	on
	$_SERVER['REQUEST_SCHEME']	https
	$_SERVER['SERVER_PROTOCOL']	HTTP/1.1
	$_SERVER['DOCUMENT_ROOT']	/usr/local/webserver/www.repmyblock.nyc/htdocs
	$_SERVER['DOCUMENT_URI']	/index.php
	$_SERVER['REQUEST_URI']	/
	$_SERVER['SCRIPT_NAME']	/index.php
	$_SERVER['CONTENT_LENGTH']	no value
	$_SERVER['CONTENT_TYPE']	no value
	$_SERVER['REQUEST_METHOD']	GET
	$_SERVER['QUERY_STRING']	no value
	$_SERVER['SCRIPT_FILENAME']	/usr/local/webserver/www.repmyblock.nyc/htdocs/index.php
	$_SERVER['PATH_INFO']	no value
	$_SERVER['FCGI_ROLE']	RESPONDER
	$_SERVER['PHP_SELF']	/index.php
	$_SERVER['REQUEST_TIME_FLOAT']	1612506754.1356
	$_SERVER['REQUEST_TIME']	1612506754
</PRE>



<?php print phpinfo(); ?>