<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * SecurityController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/register", name="register", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @SWG\Response(
     *     response=201,
     *     description="Create user"
     * )
     * @SWG\Parameter(
     *     name="username",
     *     in="body",
     *     type="string",
     *     description="Username",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="username", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="password",
     *     in="body",
     *     type="string",
     *     description="Password",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="password", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="client_id",
     *     in="body",
     *     type="int",
     *     description="ID of the client associated",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="client_id", type="integer")
     *     )
     * )
     * @SWG\Tag(name="User")
     */
    public function register(Request $request)
    {
        return $this->userService->newUser($request);
    }

    /**
     * @Route("/login", name="login", methods={"POST"})
     * @return JsonResponse
     * @SWG\Response(
     *     response=201,
     *     description="Login"
     * )
     * @SWG\Parameter(
     *     name="username",
     *     in="body",
     *     type="string",
     *     description="Username of the user",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="username", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="password",
     *     in="body",
     *     type="string",
     *     description="Password",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="password", type="string")
     *     )
     * )
     * @SWG\Tag(name="User")
     */
    public function login()
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }
}
