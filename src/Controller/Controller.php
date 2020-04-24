<?php

namespace App\Controller;

use App\Service\ClientService;
use App\Service\PhoneService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var PhoneService
     */
    private $phoneService;
    /**
     * @var ClientService
     */
    private $clientService;

    protected $serviceName;

    /**
     * Controller constructor.
     * @param PhoneService $phoneService
     * @param ClientService $clientService
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(PhoneService $phoneService, ClientService $clientService, EntityManagerInterface $entityManager)
    {
        $this->phoneService = $phoneService;
        $this->clientService = $clientService;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $serviceName = $this->serviceName;
        $data = $this->$serviceName->getDataList($request);
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @param $object
     * @return Response
     */
    public function show($object)
    {
        $serviceName = $this->serviceName;
        $data = $this->$serviceName->getData($object);
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function new(Request $request)
    {
        $serviceName = $this->serviceName;
        $this->$serviceName->addData($request);
        $data = [
            'status' => 201,
            'message' => 'L\'élément a bien été ajouté'
        ];
        return new JsonResponse($data, 201);
    }

    /**
     * @param $request
     * @param $object
     * @return JsonResponse
     */
    public function update($request, $object)
    {
        $serviceName = $this->serviceName;
        $this->$serviceName->updateData($request, $object);
        $data = [
            'status' => 200,
            'message' => 'L\'élément a bien été mis à jour'
        ];
        return new JsonResponse($data);
    }

    /**
     * @param $object
     * @return JsonResponse
     */
    public function delete($object)
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();

        $data = [
            'status' => 204,
            'message' => 'L\'élément a bien été supprimé'
        ];
        return new JsonResponse($data);
    }
}
