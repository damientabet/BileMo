<?php

namespace App\Service;

use App\Repository\ClientRepository;
use App\Repository\PhoneRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Service
{
    /**
     * @var ClientRepository
     */
    private $clientRepository;
    /**
     * @var PhoneRepository
     */
    private $phoneRepository;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    private $limit;

    /**
     * Service constructor.
     * @param ClientRepository $clientRepository
     * @param PhoneRepository $phoneRepository
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param $limit
     */
    public function __construct(ClientRepository $clientRepository, PhoneRepository $phoneRepository, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator, $limit)
    {
        $this->clientRepository = $clientRepository;
        $this->phoneRepository = $phoneRepository;
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->limit = $limit;
    }

    /**
     * @param Request $request
     * @param $repositoryName
     * @return string
     */
    public function getAllItems(Request $request, $repositoryName)
    {
        $page = $request->get('page');
        if($page === null || $page < 1) {
            $page = 1;
        }
        $items = $this->$repositoryName->findAllByPage($page,$this->limit);
        $context = SerializationContext::create()->setGroups(array('Default', 'items' => array('list')));
        return $this->serializer->serialize($items, 'json', $context);
    }

    /**
     * @param $idItem
     * @param $repositoryName
     * @return string
     */
    public function getItem($idItem, $repositoryName)
    {
        $item = $this->$repositoryName->find($idItem);
        $context = SerializationContext::create()->setGroups(array(
            'show',
            'users_group',
            'users' => array(
                'user'
            )
        ));
        return $this->serializer->serialize($item, 'json', $context);
    }

    /**
     * @param Request $request
     * @param $class
     */
    public function addItem(Request $request, $class)
    {
        $data = $this->serializer->deserialize($request->getContent(), $class, 'json');
        $errors = $this->validator->validate($data);
        $this->displayError($errors);

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    /**
     * @param Request $request
     * @param $idItem
     * @param $repositoryName
     * @throws Exception
     */
    public function updateItem(Request $request, $idItem, $repositoryName)
    {
        $item = $this->$repositoryName->findOneBy(['id' => $idItem]);
        $data = json_decode($request->getContent());
        foreach ($data as $key => $value){
            $value = $this->convertToDateTime($key, $value);
            if($key && !empty($value)) {
                $setter = 'set'.self::camelCase($key);
                $item->$setter($value);
            }
        }
        $errors = $this->validator->validate($item);
        $this->displayError($errors);
        $this->entityManager->flush();
    }

    /**
     * @param $errors
     * @return Response
     */
    public function displayError($errors)
    {
        if(count($errors)) {
            $errors = $this->serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
    }

    /**
     * @param $key
     * @param $value
     * @return DateTime
     * @throws Exception
     */
    public function convertToDateTime($key, $value)
    {
        if ($key == "year_of_marketing") {
            $value = new DateTime($value);
        }
        return $value;
    }

    /**
     * @param $str
     * @param array $noStrip
     * @return string|string[]|null
     */
    public static function camelCase($str, array $noStrip = [])
    {
        $str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
        $str = trim($str);
        $str = ucwords($str);
        $str = str_replace(" ", "", $str);
        $str = lcfirst($str);

        return $str;
    }
}
