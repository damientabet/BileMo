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
    public function getClientList(Request $request)
    {
        return $this->getAllItems($request, 'clientRepository');
    }

    public function getClient(Client $client)
    {
        return $this->getItem($client->getId(), 'clientRepository');
    }

    public function addClient(Request $request)
    {
        $this->addItem($request, Client::class);
    }

    public function updateClient(Request $request, Client $client)
    {
        $this->updateItem($request, $client->getId(), 'clientRepository');
    }
}
