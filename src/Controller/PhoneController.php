<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Service\PhoneService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhoneController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var PhoneService
     */
    private $phoneService;

    public function __construct(PhoneService $phoneService, EntityManagerInterface $entityManager)
    {
        $this->phoneService = $phoneService;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/phone/{id}", name="phone.show", methods={"GET"})
     * @param Phone $phone
     * @return Response
     */
    public function show(Phone $phone)
    {
        $data = $this->phoneService->getPhone($phone);

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/phones/{page<\d+>?1}", name="phone.index", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->phoneService->getPhonesList($request);

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/phones/add", name="phone.add", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $this->phoneService->addPhone($request);
        $data = [
            'status' => 201,
            'message' => 'Le téléphone a bien été ajouté'
        ];
        return new JsonResponse($data, 201);
    }

    /**
     * @Route("/phones/{id}", name="phone.update", methods={"PUT"})
     * @param Request $request
     * @param Phone $phone
     * @return JsonResponse|Response
     * @throws \Exception
     */
    public function update(Request $request, Phone $phone)
    {
        $this->phoneService->updatePhone($request, $phone);
        $data = [
            'status' => 200,
            'message' => 'Le téléphone a bien été mis à jour'
        ];
        return new JsonResponse($data);
    }

    /**
     * @Route("/phones/{id}", name="phone.delete", methods={"DELETE"})
     * @param Phone $phone
     * @return Response
     */
    public function delete(Phone $phone)
    {
        $this->entityManager->remove($phone);
        $this->entityManager->flush();

        $data = [
            'status' => 204,
            'message' => 'Le téléphone a bien été supprimé'
        ];
        return new JsonResponse($data);
    }
}
