<?php

namespace App\Service;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ClientService
 * @package App\Service
 */
class ClientService
{
    /**
     * @var ClientRepository
     */
    private $clientRepository;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    private $limit;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    private $validator;

    public function __construct(ClientRepository $clientRepository, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator, $limit)
    {
        $this->clientRepository = $clientRepository;
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->limit = $limit;
    }

    public function getClientList(Request $request)
    {
        $page = $request->query->get('page');
        if($page === null || $page < 1) {
            $page = 1;
        }
        $phones = $this->clientRepository->findAllClients($page,$this->limit);
        return $this->serializer->serialize($phones, 'json', [
            'groups' => ['list']
        ]);
    }

    public function getClient(Client $client)
    {
        $client = $this->clientRepository->find($client->getId());
        return $this->serializer->serialize($client, 'json', [
            'groups' => ['show']
        ]);
    }

    public function addClient(Request $request)
    {
        $client = $this->serializer->deserialize($request->getContent(), Client::class, 'json');
        $errors = $this->validator->validate($client);
        if(count($errors)) {
            $errors = $this->serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }

    public function updateClient(Request $request, Client $client)
    {
        $clientUpdate = $this->clientRepository->findOneBy(['id' => $client->getId()]);
        $data = json_decode($request->getContent());
        foreach ($data as $key => $value){
            if($key && !empty($value)) {
                $name = $key;
                $setter = 'set'.$name;
                $clientUpdate->$setter($value);
            }
        }
        $errors = $this->validator->validate($clientUpdate);
        if(count($errors)) {
            $errors = $this->serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $this->entityManager->flush();
    }
}
