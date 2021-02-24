<?php

namespace App\Services;

Class Google
{
    protected $client;

    function __construct()
    {
        $client = new \Google_Client();
        $client->setApplicationName('Horeca Apartment Calendar');
        $client->setScopes(config('services.google.scopes'));
        $client->setAuthConfig(storage_path('/app/keys/oauth-credentials.json'));
        $client->setAccessType('offline');
        $client->setIncludeGrantedScopes(true);
        $client->setApprovalPrompt('force');
        $this->client = $client;
    }

    public function __call($method, $args)
    {
        if (! method_exists($this->client, $method)) {
            throw new \Exception("Call to undefined method '{$method}'");
        }

        return call_user_func_array([$this->client, $method], $args);
    }

    public function service($service)
    {
        $classname = "Google_Service_$service";

        return new $classname($this->client);
    }

    public function connectUsing($token)
    {
        $this->client->setAccessToken($token);

        return $this;
    }
    
}