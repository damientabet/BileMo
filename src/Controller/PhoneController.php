<?php

namespace App\Controller;

use App\Entity\Phone;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhoneController extends Controller
{
    protected $serviceName = "phoneService";

    /**
     * @Route("/phone/{id}", name="phone.show", methods={"GET"})
     * @param Phone $phone
     * @return Response
     */
    public function displayPhone(Phone $phone)
    {
        return $this->show($phone);
    }

    /**
     * @Route("/phones/{page<\d+>?1}", name="phone.index")
     * @param Request $request
     * @return Response
     */
    public function displayAllPhones(Request $request)
    {
        return $this->index($request);
    }

    /**
     * @Route("/phones/add", name="phone.add", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addPhone(Request $request)
    {
        return $this->new($request);
    }

    /**
     * @Route("/phone/{id}", name="phone.update", methods={"PUT"})
     * @param Request $request
     * @param Phone $phone
     * @return JsonResponse|Response
     */
    public function updatePhone(Request $request, Phone $phone)
    {
        return $this->update($request, $phone);
    }

    /**
     * @Route("/phone/{id}", name="phone.delete", methods={"DELETE"})
     * @param Phone $phone
     * @return Response
     */
    public function deletePhone(Phone $phone)
    {
        return $this->delete($phone);
    }
}
