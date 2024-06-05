<?php

namespace App\Services;

use App\Repositories\TemporaryRegistrationRepository;

class TemporaryRegistrationService 
{
    protected $temporaryRegistrationRepository;

    public function __construct(TemporaryRegistrationRepository $temporaryRegistrationRepository)
    {
        $this->temporaryRegistrationRepository = $temporaryRegistrationRepository;
    }

    //仮登録(メールアドレス、トークン,有効期限)
    public function createTemporaryRegistration($email)
    {
        return $this->temporaryRegistrationRepository->createTemporaryRegistration($email);
    }

    //temporaryRegistrationのカラム削除
    public function DeleteByTemporaryRegistration($email)
    {
        return $this->temporaryRegistrationRepository->DeleteByTemporaryRegistration($email);
    }

    //検索
    public function findBy($field, $operator, $value)
    {
        return $this->temporaryRegistrationRepository->findBy($field, $operator, $value);
    }

}
