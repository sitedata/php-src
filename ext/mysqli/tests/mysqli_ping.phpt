--TEST--
mysqli_ping()
--SKIPIF--
<?php
require_once('skipif.inc');
require_once('skipifemb.inc');
require_once('skipifconnectfailure.inc');
?>
--FILE--
<?php
	require_once("connect.inc");

	require('table.inc');

	var_dump(mysqli_ping($link));

	// provoke an error to check if mysqli_ping resets it
	$res = mysqli_query($link, 'SELECT * FROM unknown_table');
	if (!($errno = mysqli_errno($link)))
		printf("[003] Statement should have caused an error\n");

	var_dump(mysqli_ping($link));
	if ($errno === mysqli_errno($link))
		printf("[004] Error codes should have been reset\n");

	mysqli_close($link);

	if (false !== ($tmp = mysqli_ping($link)))
		printf("[005] Expecting false, got %s/%s\n", gettype($tmp), $tmp);

	print "done!";
?>
--EXPECTF--
bool(true)
bool(true)

Warning: mysqli_ping(): Couldn't fetch mysqli in %s on line %d
done!
