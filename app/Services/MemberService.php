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

    public function search($memberId, $status, $startDate, $endDate, $sort)
    {
        return $this->memberRepository->search($memberId, $status, $startDate, $endDate, $sort);
    }

    public function memberInfoRegister($name, $password, $token, $country, $address, $city)
    {
        return $this->memberRepository->memberInfoRegister($name, $password, $token, $country, $address, $city);
    }

    public function createOrUpdate($id, $name, $email, $country, $address, $city, $status, $points)
    {
        return $this->memberRepository->createOrUpdate($id, $name, $email, $country, $address, $city, $status, $points);
    }
}