<?php

use React\Promise\Deferred;
use React\Promise\Promise;

class FetchData
{
    /** @var Deferred */
    private $deferred;

    public function call(string $url, string $method = null): self
    {
        $curlHandler = curl_init();
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandler, CURLOPT_FAILONERROR, true);
        curl_setopt($curlHandler, CURLOPT_URL, $url);

        strtolower($method) === 'post' ?? curl_setopt(CURLOPT_POST, true);

        $result = curl_exec($curlHandler);
        curl_close($curlHandler);

        $this->deferred = new Deferred();
        if ($result) {
            $this->deferred->resolve($result);
        } else {
            $this->deferred->reject('Some error occurs' . PHP_EOL);
        }

        return $this;
    }

    public function getPromise(): Promise
    {
        return $this->deferred->promise();
    }
}