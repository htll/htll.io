<?php
/*
 * First authored by Brian Cray
 * License: http://creativecommons.org/licenses/by/3.0/
 * Contact the author at http://briancray.com/
 */

ini_set('display_errors', 0);

$url_to_shorten = get_magic_quotes_gpc() ? stripslashes(trim($_REQUEST['longurl'])) : trim($_REQUEST['longurl']);

if(!empty($url_to_shorten) && preg_match('|^https?://|', $url_to_shorten))
{
	require('config.php');

	// check if the client IP is allowed to shorten
	if($_SERVER['REMOTE_ADDR'] != LIMIT_TO_IP)
	{
		die('You are not allowed to shorten URLs with this service.');
	}

	// check if the URL is valid
  if(CHECK_URL)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url_to_shorten);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($ch);
		curl_close($handle);
		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) == '404')
		{
			die('Not a valid URL');
		}
	}

	// check if the URL has already been shortened
	$sql = 'SELECT id FROM ' . DB_TABLE. ' WHERE long_url="' . mysqli_real_escape_string($conn, $url_to_shorten) . '";';
	$already_shortened = mysqli_fetch_assoc(mysqli_query($conn, $sql))['id'];
	if(!empty($already_shortened))
	{
		// URL has already been shortened
		$shortened_url = getShortenedURLFromID(intval($already_shortened));
	}
	else
	{
		// URL not in database, insert
		mysqli_query($conn, 'LOCK TABLES ' . DB_TABLE . ' WRITE;');
		mysqli_query($conn, 'INSERT INTO ' . DB_TABLE . ' (long_url, created, creator) VALUES ("' . mysqli_real_escape_string($conn, $url_to_shorten) . '", "' . time() . '", "' . mysqli_real_escape_string($conn, $_SERVER['REMOTE_ADDR']) . '")');
		$shortened_url = getShortenedURLFromID(mysqli_insert_id($conn));
		mysqli_query($conn, 'UNLOCK TABLES');
	}
	echo "http://htll.info/s/" . $shortened_url;
}

function getShortenedURLFromID ($integer, $base = ALLOWED_CHARS)
{
	$length = strlen($base);
	while($integer > $length - 1)
	{
		$out = $base[fmod($integer, $length)] . $out;
		$integer = floor( $integer / $length );
	}
	return $base[$integer] . $out;
}
