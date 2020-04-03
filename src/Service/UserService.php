<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    private $limit;
    private $serializer;
    private $passwordEncoder;
    private $entityManager;
    private $validator;

    public function __construct($limit, SerializerInterface $serializer, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->limit = $limit;
        $this->serializer = $serializer;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function newUser(Request $request)
    {
        $values = json_decode($request->getContent());
        if(isset($values->username,$values->password)) {
            $user = new User();
            $user->setUsername($values->username);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $values->password));
            $user->setRoles($user->getRoles());
            $errors = $this->validator->validate($user);
            if(count($errors)) {
                $errors = $this->serializer->serialize($errors, 'json');
                return new Response($errors, 500, ['Content-Type' => 'application/json']);
            }
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
}
