<?php

namespace App\Controller;

use App\Service\PhoneService;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(UserService $userService, EntityManagerInterface $entityManager)
    {
        $this->userService = $userService;
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/users/{page<\d+>?1}", name="user.index", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->userService->getUserList($request);

//        return new Response($data, 200, [
//            'Content-Type' => 'application/json'
//        ]);
    }
}
