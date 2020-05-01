<?php

namespace App\Controller;

use App\Entity\Client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class ClientController
 * @package App\Controller
 * @Route("/api")
 */
class ClientController extends Controller
{
    protected $serviceName = "clientService";

    /**
     * @Route("/client/{id}", name="client.show", methods={"GET"})
     * @param Client $client
     * @return Response
     *
     * @SWG\Response(
     *     response=200,
     *     description="Display the detail of client with ID {id}",
     *     @Model(type=Client::class, groups={"show"})
     *     )
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You are not allowed for this request"
     * )
     * @SWG\Tag(name="Client")
     */
    public function displayClient(Client $client)
    {
        return $this->show($client);
    }

    /**
     * @Route("/clients/{page<\d+>?1}", name="client.index", methods={"GET"})
     * @param Request $request
     * @return Response
     * @SWG\Response(
     *     response=200,
     *     description="Display the list of all clients",
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You are not allowed for this request"
     * )
     * @SWG\Tag(name="Client")
     */
    public function displayAllClients(Request $request)
    {
        return $this->index($request);
    }

    /**
     * @Route("/clients/add", name="client.add", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @SWG\Response(
     *     response=201,
     *     description="Add new Client"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You are not allowed for this request"
     * )
     * @SWG\Parameter(
     *     name="name",
     *     in="body",
     *     type="string",
     *     description="Name of the client",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="name", type="string")
     *     )
     * )
     * @SWG\Tag(name="Client")
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
     * @SWG\Response(
     *     response=201,
     *     description="Update client with ID {id}"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You are not allowed for this request"
     * )
     * @SWG\Parameter(
     *     name="name",
     *     in="body",
     *     type="string",
     *     description="Name of the Client",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="name", type="string")
     *     )
     * )
     * @SWG\Tag(name="Client")
     */
    public function updateClient(Request $request, Client $client)
    {
        return $this->update($request, $client);
    }

    /**
     * @Route("/client/{id}", name="client.delete", methods={"DELETE"})
     * @param Client $client
     * @return Response
     * @SWG\Response(
     *     response=204,
     *     description="Delete client with ID {id}"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You are not allowed for this request"
     * )
     * @SWG\Tag(name="Client")
     */
    public function deleteClient(Client $client)
    {
        return $this->delete($client);
    }
}
