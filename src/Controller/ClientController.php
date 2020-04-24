<?php

namespace App\Controller;

use App\Entity\Client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends Controller
{
    protected $serviceName = "clientService";

    /**
     * @Route("/client/{id}", name="client.show", methods={"GET"})
     * @param Client $client
     * @return Response
     */
    public function displayClient(Client $client)
    {
        return $this->show($client);
    }

    /**
     * @Route("/clients/{page<\d+>?1}", name="client.index")
     * @param Request $request
     * @return Response
     */
    public function displayAllClients(Request $request)
    {
        return $this->index($request);
    }

    /**
     * @Route("/clients/add", name="client.add", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addClient(Request $request)
    {
        return $this->new($request);
    }

    /**
     * @Route("/client/{id}", name="client.update", methods={"PUT"})
     * @param Request $request
     * @param Client $client
     * @return JsonResponse|Response
     */
    public function updateClient(Request $request, Client $client)
    {
        return $this->update($request, $client);
    }

    /**
     * @Route("/client/{id}", name="client.delete", methods={"DELETE"})
     * @param Client $client
     * @return Response
     */
    public function deleteClient(Client $client)
    {
        return $this->delete($client);
    }
}
