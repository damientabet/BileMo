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
    private $repositoryName = 'phoneRepository';

    public function getDataList(Request $request)
    {
        return $this->getAllItems($request, $this->repositoryName);
    }

    public function getData(Phone $phone)
    {
        return $this->getItem($phone->getId(), $this->repositoryName);
    }

    public function addData(Request $request)
    {
        $this->addItem($request, Phone::class);
    }

    public function updateData(Request $request, Phone $phone)
    {
        $this->updateItem($request, $phone->getId(), $this->repositoryName);
    }
}
