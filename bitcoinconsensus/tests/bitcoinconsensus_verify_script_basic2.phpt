--TEST--
bitcoinconsensus_verify_script returns false
--SKIPIF--
if (!extension_loaded("bitcoinconsensus")) print "skip extension not loaded";
--FILE--
<?php
$script = hex2bin("745287");
$tx = hex2bin("0100000001dc3e1270bc983b5fc117d86201475c85dbac7647c663e275f730cc87200f7a920000000000ffffffff0100000000000000000000000000");
$flags = 3;
$nIn = 0;
$error = 0;
$result = bitcoinconsensus_verify_script($script, $tx, $nIn, $flags, $error);
echo ($result ? "true" : "false")  . PHP_EOL;
?>
--EXPECTF--
false