<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Repository\PhoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PhoneController extends AbstractController
{
    private $limit;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var PhoneRepository
     */
    private $phoneRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct($limit, SerializerInterface $serializer, EntityManagerInterface $entityManager, PhoneRepository $phoneRepository, ValidatorInterface $validator)
    {
        $this->limit = $limit;
        $this->serializer = $serializer;
        $this->phoneRepository = $phoneRepository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @Route("/phone/{id}", name="phone.show", methods={"GET"})
     * @param Phone $phone
     * @return Response
     */
    public function show(Phone $phone)
    {
        $phone = $this->phoneRepository->find($phone->getId());
        $data = $this->serializer->serialize($phone, 'json', [
            'groups' => ['show']
        ]);

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
        $page = $request->query->get('page');
        if(is_null($page) || $page < 1) {
            $page = 1;
        }
        $phones = $this->phoneRepository->findAllPhones($page,$this->limit);
        $data = $this->serializer->serialize($phones, 'json', [
            'groups' => ['list']
        ]);

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
