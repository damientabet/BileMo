<?php

namespace App\Service;

use App\Entity\Client;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ClientService
 * @package App\Service
 */
class ClientService extends Service
{
    /**
     * @var string
     */
    private $repositoryName = 'clientRepository';

    /**
     * @param Request $request
     * @return string
     */
    public function getDataList(Request $request)
    {
        return $this->getAllItems($request, $this->repositoryName);
    }

    /**
     * @param Client $client
     * @return string
     */
    public function getData(Client $client)
    {
        return $this->getItem($client->getId(), $this->repositoryName);
    }

    /**
     * @param Request $request
     */
    public function addData(Request $request)
    {
        $this->addItem($request, Client::class);
    }

    /**
     * @param Request $request
     * @param Client $client
     */
    public function updateData(Request $request, Client $client)
    {
        $this->updateItem($request, $client->getId(), $this->repositoryName);
    }
}
