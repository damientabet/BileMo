<?php

namespace App\Service;

use App\Entity\Phone;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PhoneService
 * @package App\Service
 */
class PhoneService extends Service
{
    /**
     * @var string
     */
    private $repositoryName = 'phoneRepository';

    /**
     * @param Request $request
     * @return string
     */
    public function getDataList(Request $request)
    {
        return $this->getAllItems($request, $this->repositoryName);
    }

    /**
     * @param Phone $phone
     * @return string
     */
    public function getData(Phone $phone)
    {
        return $this->getItem($phone->getId(), $this->repositoryName);
    }

    /**
     * @param Request $request
     */
    public function addData(Request $request)
    {
        $this->addItem($request, Phone::class);
    }

    /**
     * @param Request $request
     * @param Phone $phone
     */
    public function updateData(Request $request, Phone $phone)
    {
        $this->updateItem($request, $phone->getId(), $this->repositoryName);
    }
}
