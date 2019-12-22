<?php

namespace App\Services;

use App\Interfaces\Downloader;

class CurlService implements Downloader
{
    /*
     * There we using CLI curl instead php_curl lib, cause lib don't allow to saving filename from server response

     * If we try do download via lib https://www.gravatar.com/avatar/f0af40756420859b5b63cbceb6d30505?s=32&d=identicon&r=PG
     * Result filename will names as f0af40756420859b5b63cbceb6d30505?s=32&d=identicon&r=PG , without file extension.
     *
     * Instead of this we using CLI with -OJ keys
     *
     * */


    /**
     * Storing filename which was got from curl response
     *
     * @var string
     */
    private $fileName;

    /**
     * CurlService constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        if (!$this->isInstalled()) {
            throw new \Exception('Curl doesn\'t installed in your system, or not available for the current user');
        }
    }

    /**
     * Check is curl installed and available
     *
     * @return bool
     */
    private function isInstalled()
    {
        exec('curl -V', $output, $return);
        if (!empty($output[0]) && $output[0][0] == 'c' && strpos($output[0], 'curl ') !== false) {
            return true;
        }
        return false;
    }


    /**
     * Process download
     *
     *
     * @param $url
     * @param $storeTo
     * @return string
     */
    public function download($url, $storeTo)
    {

        $command = 'curl -sLJOw \'%{filename_effective}\' "' . $url . '"';
        exec($command, $filenameOutput);
        if (!empty($filenameOutput[0])) {
            $this->fileName = $filenameOutput[0];
        } else {
            throw new \Exception('Can\'t get tagret filename');
        }

        $command = 'cd ' . $storeTo . ' && curl -OJ "' . $url . '" > /dev/null';
        exec($command, $output, $returnCode);

        if ($returnCode === 0) {
            return self::STATUS_SUCCESS;
        } else {
            throw new \Exception('Download are failed');
        }
    }


    /**
     * Filename getter
     *
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }
}
