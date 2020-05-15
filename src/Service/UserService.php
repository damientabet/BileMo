<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    private $limit;
    private $serializer;
    private $passwordEncoder;
    private $entityManager;
    private $validator;
    /**
     * @var ClientRepository
     */
    private $clientRepository;
    /**
     * @var Security
     */
    private $security;

    /**
     * UserService constructor.
     * @param $limit
     * @param SerializerInterface $serializer
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param ClientRepository $clientRepository
     */
    public function __construct($limit, SerializerInterface $serializer, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, ValidatorInterface $validator, ClientRepository $clientRepository, Security $security)
    {
        $this->limit = $limit;
        $this->serializer = $serializer;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->clientRepository = $clientRepository;
        $this->security = $security;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function newUser(Request $request)
    {
        $isSuperAdmin = $this->security->isGranted('ROLE_SUPER_ADMIN');
        $client_id = $this->security->getUser()->getClient();
        $values = json_decode($request->getContent());
        if(isset($values->username,$values->password)) {
            $user = new User();
            $user->setUsername($values->username);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $values->password));
            $roles = ($isSuperAdmin && isset($values->role)) ? [$values->role] : $user->getRoles();
            $user->setRoles($roles);

            $client = $this->clientRepository->findOneBy(['id' => ($isSuperAdmin && isset($values->client_id)) ? $values->client_id : $client_id]);
            $user->setClient($client);

            $this->displayError($this->validator->validate($user));
            
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $data = [
                'status' => 201,
                'message' => 'L\'utilisateur a été créé'
            ];
            return new JsonResponse($data, 201);
        }
        $data = [
            'status' => 500,
            'message' => 'Vous devez renseigner les clés username et password'
        ];
        return new JsonResponse($data, 500);
    }

    /**
     * @param $errors
     * @return Response
     */
    public function displayError($errors)
    {
        if(count($errors)) {
            $errors = $this->serializer->serialize($errors, 'json');
            return new Response($errors, 500, ['Content-Type' => 'application/json']);
        }
    }
}
