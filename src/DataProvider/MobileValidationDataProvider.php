<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Model\MobileValidation;
use App\Repository\UserRepository;

class MobileValidationDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $mobileValidation = new MobileValidation($id);

        $mobileValidation
            ->setValid($this->userRepository->findOneBy(['mobile' => $mobileValidation->getId()]) == null);

        return $mobileValidation;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return MobileValidation::class == $resourceClass;
    }
}