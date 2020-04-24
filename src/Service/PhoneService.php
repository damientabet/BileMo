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
    public function getPhonesList(Request $request)
    {
        return $this->getAllItems($request, 'phoneRepository');
    }

    public function getPhone(Phone $phone)
    {
        return $this->getItem($phone->getId(), 'phoneRepository');
    }

    public function addPhone(Request $request)
    {
        $this->addItem($request, Phone::class);
    }

    public function updatePhone(Request $request, Phone $phone)
    {
        $this->updateItem($request, $phone->getId(), 'phoneRepository');
    }
}
