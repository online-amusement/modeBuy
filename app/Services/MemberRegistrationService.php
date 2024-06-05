<?php

namespace App\Services;

use App\Repositories\MemberRegistrationRepository;

class MemberRegistrationService
{
    protected $memberRegistrationRepository;

    public function __construct(MemberRegistrationRepository $memberRegistrationRepository)
    {
        $this->memberRegistrationRepository = $memberRegistrationRepository;
    }

    //ユーザーの仮登録
    public function createTemporaryMember($email,$token)
    {
        return $this->memberRegistrationRepository->createTemporaryMember($email,$token);
    }

    //
}