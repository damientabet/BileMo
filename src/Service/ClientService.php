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
    private $repositoryName = 'clientRepository';

    public function getDataList(Request $request)
    {
        return $this->getAllItems($request, $this->repositoryName);
    }

    public function getData(Client $client)
    {
        return $this->getItem($client->getId(), $this->repositoryName);
    }

    public function addData(Request $request)
    {
        $this->addItem($request, Client::class);
    }

    public function updateData(Request $request, Client $client)
    {
        $this->updateItem($request, $client->getId(), $this->repositoryName);
    }
}
