<?php

namespace App\Service;

use App\Entity\Phone;
use App\Repository\PhoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class PhoneService
 * @package App\Service
 */
class PhoneService
{
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var PhoneRepository
     */
    private $phoneRepository;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    private $limit;

    public function __construct($limit, SerializerInterface $serializer, EntityManagerInterface $entityManager, PhoneRepository $phoneRepository, ValidatorInterface $validator)
    {
        $this->limit = $limit;
        $this->serializer = $serializer;
        $this->phoneRepository = $phoneRepository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function getPhonesList(Request $request)
    {
        $page = $request->query->get('page');
        if($page === null || $page < 1) {
            $page = 1;
        }
        $phones = $this->phoneRepository->findAllPhones($page,$this->limit);
        return $this->serializer->serialize($phones, 'json', [
            'groups' => ['list']
        ]);
    }

    public function getPhone(Phone $phone)
    {
        $phone = $this->phoneRepository->find($phone->getId());
        return $this->serializer->serialize($phone, 'json', [
            'groups' => ['show']
        ]);
    }

    public function addPhone(Request $request)
    {
        $phone = $this->serializer->deserialize($request->getContent(), Phone::class, 'json');
        $errors = $this->validator->validate($phone);
        if(count($errors)) {
            $errors = $this->serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $this->entityManager->persist($phone);
        $this->entityManager->flush();
    }

    public function updatePhone(Request $request, Phone $phone)
    {
        $phoneUpdate = $this->phoneRepository->findOneBy(['id' => $phone->getId()]);
        $data = json_decode($request->getContent());
        foreach ($data as $key => $value){
            if ($key == "year_of_marketing") {
                $value = new \DateTime($value);
            }
            if($key && !empty($value)) {
                $name = self::camelCase($key);
                $setter = 'set'.self::camelCase($name);
                $phoneUpdate->$setter($value);
            }
        }
        $errors = $this->validator->validate($phoneUpdate);
        if(count($errors)) {
            $errors = $this->serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $this->entityManager->flush();
    }

    public static function camelCase($str, array $noStrip = [])
    {
        // non-alpha and non-numeric characters become spaces
        $str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
        $str = trim($str);
        // uppercase the first character of each word
        $str = ucwords($str);
        $str = str_replace(" ", "", $str);
        $str = lcfirst($str);

        return $str;
    }
}
