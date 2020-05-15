<?php

namespace App\Controller;

use App\Entity\Phone;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * Class PhoneController
 * @package App\Controller
 * @Route("/api")
 */
class PhoneController extends Controller
{
    protected $serviceName = "phoneService";

    /**
     * @Route("/phone/{id}", name="phone.show", methods={"GET"})
     * @param Phone $phone
     * @return Response
     * @SWG\Response(
     *     response=200,
     *     description="Display the detail of phone with ID {id}",
     *     @Model(type=Phone::class, groups={"show"})
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You are not allowed for this request"
     * )
     * @SWG\Tag(name="Phone")
     */
    public function displayPhone(Phone $phone)
    {
        return $this->show($phone);
    }

    /**
     * @Route("/phones/{page<\d+>?1}", name="phone.index", methods={"GET"})
     * @param Request $request
     * @return Response
     * @SWG\Response(
     *     response=200,
     *     description="Display the list of all phones"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You are not allowed for this request"
     * )
     * @SWG\Tag(name="Phone")
     */
    public function displayAllPhones(Request $request)
    {
        return $this->index($request);
    }

    /**
     * @Route("/phones/add", name="phone.add", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     * @SWG\Response(
     *     response=201,
     *     description="Add new phone"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You are not allowed for this request"
     * )
     * @SWG\Parameter(
     *     name="brand",
     *     in="body",
     *     type="string",
     *     description="Brand of the phone",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="brand", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="model",
     *     in="body",
     *     type="string",
     *     description="Model of the phone",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="model", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="year_of_marketing",
     *     in="body",
     *     type="datetime",
     *     description="Year of marketing of the phone",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="year_of_marketing", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="screen_size",
     *     in="body",
     *     type="decimal",
     *     description="Screen Size of the phone",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="screen_size", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="screen_resolution",
     *     in="body",
     *     type="string",
     *     description="Screen Resolution of the phone",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="screen_resolution", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="os_version",
     *     in="body",
     *     type="string",
     *     description="OS Version of the phone",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="os_version", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="color",
     *     in="body",
     *     type="string",
     *     description="Color of the phone",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="color", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="specific_absorption_rate",
     *     in="body",
     *     type="string",
     *     description="Specific Absorption Rate of the phone",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="specific_absorption_rate", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="rom_memory",
     *     in="body",
     *     type="decimal",
     *     description="ROM Memory of the phone",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="rom_memory", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="description",
     *     in="body",
     *     type="string",
     *     description="Description of the phone",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="description", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="price",
     *     in="body",
     *     type="decimal",
     *     description="Price of the phone",
     *     required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="price", type="string")
     *     )
     * )
     * @SWG\Tag(name="Phone")
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
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     * @SWG\Response(
     *     response=201,
     *     description="Update phone with ID {id}"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You are not allowed for this request"
     * )
     * @SWG\Parameter(
     *     name="brand",
     *     in="body",
     *     type="string",
     *     description="Brand of the phone",
     *     required=false,
     *     @SWG\Schema(
     *          @SWG\Property(property="brand", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="model",
     *     in="body",
     *     type="string",
     *     description="Model of the phone",
     *     required=false,
     *     @SWG\Schema(
     *          @SWG\Property(property="model", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="year_of_marketing",
     *     in="body",
     *     type="datetime",
     *     description="Year of marketing of the phone",
     *     required=false,
     *     @SWG\Schema(
     *          @SWG\Property(property="year_of_marketing", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="screen_size",
     *     in="body",
     *     type="decimal",
     *     description="Screen Size of the phone",
     *     required=false,
     *     @SWG\Schema(
     *          @SWG\Property(property="screen_size", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="screen_resolution",
     *     in="body",
     *     type="string",
     *     description="Screen Resolution of the phone",
     *     required=false,
     *     @SWG\Schema(
     *          @SWG\Property(property="screen_resolution", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="os_version",
     *     in="body",
     *     type="string",
     *     description="OS Version of the phone",
     *     required=false,
     *     @SWG\Schema(
     *          @SWG\Property(property="os_version", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="color",
     *     in="body",
     *     type="string",
     *     description="Color of the phone",
     *     required=false,
     *     @SWG\Schema(
     *          @SWG\Property(property="color", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="specific_absorption_rate",
     *     in="body",
     *     type="decimal",
     *     description="Specific Absorption Rate of the phone",
     *     required=false,
     *     @SWG\Schema(
     *          @SWG\Property(property="specific_absorption_rate", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="rom_memory",
     *     in="body",
     *     type="string",
     *     description="ROM Memory of the phone",
     *     required=false,
     *     @SWG\Schema(
     *          @SWG\Property(property="rom_memory", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="description",
     *     in="body",
     *     type="string",
     *     description="Description of the phone",
     *     required=false,
     *     @SWG\Schema(
     *          @SWG\Property(property="description", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="price",
     *     in="body",
     *     type="decimal",
     *     description="Price of the phone",
     *     required=false,
     *     @SWG\Schema(
     *          @SWG\Property(property="price", type="string")
     *     )
     * )
     * @SWG\Tag(name="Phone")
     */
    public function updatePhone(Request $request, Phone $phone)
    {
        return $this->update($request, $phone);
    }

    /**
     * @Route("/phone/{id}", name="phone.delete", methods={"DELETE"})
     * @param Phone $phone
     * @return Response
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     * @SWG\Response(
     *     response=204,
     *     description="Delete phone with ID {id}"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You are not allowed for this request"
     * )
     * @SWG\Tag(name="Phone")
     */
    public function deletePhone(Phone $phone)
    {
        return $this->delete($phone);
    }
}
