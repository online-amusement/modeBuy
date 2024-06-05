<?php

namespace App\Services;

use App\Repositories\MemberRepository;

class MemberService
{
    protected $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function findBy($field, $operator, $value)
    {
        return $this->memberRepository->findBy($field, $operator, $value);
    }

    public function memberInfoRegister($name, $password, $token, $country, $address, $city)
    {
        return $this->memberRepository->memberInfoRegister($name, $password, $token, $country, $address, $city);
    }
}