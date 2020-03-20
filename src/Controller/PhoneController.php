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

    /**
     * @Route("/phones/add", name="phone.add", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
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
        $phoneUpdate = $this->phoneRepository->findOneBy(['id' => $phone->getId()]);
        $data = json_decode($request->getContent());
        foreach ($data as $key => $value){
            if($key && !empty($value)) {
                $name = self::camelCase($key);
                $setter = 'set'.self::camelCase($name);
                if ($key == "year_of_marketing") {
                    $value = new \DateTime($value);
                }
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
