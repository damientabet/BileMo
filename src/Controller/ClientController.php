<?php

namespace App\Controller;

use App\Entity\Client;
use App\Service\ClientService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @var ClientService
     */
    private $clientService;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(ClientService $clientService, EntityManagerInterface $entityManager)
    {
        $this->clientService = $clientService;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/client/{id}", name="client.show", methods={"GET"})
     * @param Client $client
     * @return Response
     */
    public function show(Client $client)
    {
        $data = $this->clientService->getClient($client);

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/clients/{page<\d+>?1}", name="client.index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->clientService->getClientList($request);
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/clients/add", name="client.add", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function new(Request $request)
    {
        $this->clientService->addClient($request);
        $data = [
            'status' => 201,
            'message' => 'Le client a bien été ajouté'
        ];
        return new JsonResponse($data, 201);
    }

    /**
     * @Route("/client/{id}", name="client.update", methods={"PUT"})
     * @param Request $request
     * @param Client $client
     * @return JsonResponse|Response
     */
    public function update(Request $request, Client $client)
    {
        $this->clientService->updateClient($request, $client);
        $data = [
            'status' => 200,
            'message' => 'Le client a bien été mis à jour'
        ];
        return new JsonResponse($data);
    }

    /**
     * @Route("/client/{id}", name="client.delete", methods={"DELETE"})
     * @param Client $client
     * @return Response
     */
    public function delete(Client $client)
    {
        $this->entityManager->remove($client);
        $this->entityManager->flush();

        $data = [
            'status' => 204,
            'message' => 'Le client a bien été supprimé'
        ];
        return new JsonResponse($data);
    }
}
