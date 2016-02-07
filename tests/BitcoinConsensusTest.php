<?php

namespace BitWasp\BitcoinConsensus\Tests;

class BitcoinConsensusTest extends \PHPUnit_Framework_TestCase
{
    private function loadExternalTestFiles($dir)
    {
        $results = array();
        $basedir = __DIR__ . '/../bitcoinconsensus_testcases/';
        $fulldir = $basedir . $dir . '/';
        foreach (scandir($fulldir) as $file) {
            if (in_array($file, array('.','..'))) {
                continue;
            }
            $results[] = $fulldir . $file;
        }
        return $results;
    }

    private function loadVectors($dir)
    {
        $vectors = array();
        foreach ($this->loadExternalTestFiles($dir) as $c => $file) {
            $vectors[] = array_merge(array($dir, $c), explode("\n", file_get_contents($file)));
        }
        return $vectors;
    }

    public function getNegativeTests()
    {
        return $this->loadVectors('0.10-negative');
    }

    public function getPositiveTests()
    {
        return $this->loadVectors('0.10-positive');
    }

    public function getAllTests()
    {
        return array_merge($this->getPositiveTests(), $this->getNegativeTests());
    }

    public function testVersion()
    {
        $this->assertEquals(1, \bitcoinconsensus_version());
    }

    public function getNew()
    {
        $array = json_decode(file_get_contents("tests/data/vectors.json"), true);

        return $array;
    }

    /**
     * @dataProvider getNew
     */
    public function testSimple($txHex, $scriptPubKeyHex, $eResult, $flags)
    {
        $script = pack("H*", $scriptPubKeyHex);
        $tx = pack("H*", $txHex);

        $error = 0;
        $result = \bitcoinconsensus_verify_script($script, $tx, 0, $flags, $error);


        $this->assertEquals($eResult, $result);

        // since the script returns true, the error can never be zero.
        if ($eResult == 1) {
            $this->assertEquals(0, $error);
        }
    }

}