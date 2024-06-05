<?php

namespace App\Repositories;

use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class MemberRepository
{
    protected $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    //検索
    public function findBy($field, $operator, $value)
    {
        return $this->member
            ->newQuery()
            ->where($field, $operator, $value);
    }

    public function memberInfoRegister($name, $password, $token, $country, $address, $city)
    {
        //新規トークン発行
        //$api_token = Str::random(80);

        return $this->member
            ->newQuery()
            ->where("api_token", "=", $token)
            ->update([
                "name" => $name,
                "password" => Hash::make($password),
                "api_token" => $token,
                "country" => $country,
                "address" => $address,
                "city" => $city,
                "status" => 1
            ]);
    }
}