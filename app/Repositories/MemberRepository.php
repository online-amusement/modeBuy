<?php

namespace App\Repositories;

use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class MemberRepository
{
    protected $member;

    const DESC = "desc";
    const ASC = "asc";

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    //検索
    public function findBy($field, $operator, $value)
    {
        return $this->member
            ->newQuery()
            ->where($field, $operator, $value)
            ->first();
    }

    //メンバー検索
    public function search($memberId, $status, $startDate, $endDate, $sort)
    {
        $members = $this->member->newQuery();

        if($memberId != null)
        {
            $members = $members->where("id", "=", $memberId);
        }

        if($status != null)
        {
            $members = $members->where("status", "=", $status);
        }

        if($startDate != null)
        {
            $members = $members
                ->where("created_at", ">", $startDate)
                ->where("created_at", "<", $endDate);
        }

        if($sort == '降順')
        {
            return $members
                ->orderBy('id', self::DESC)
                ->paginate(10);
        }else {
            return $members
                ->orderBy('id', self::ASC)
                ->paginate(10);
        }
    }

    //メンバー情報登録
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

    //メンバー情報新規登録又は更新
    public function createOrUpdate($id, $name, $email, $country, $address, $city, $status, $points)
    {
        $members = $this->member->newQuery();
        $member = $members->updateOrCreate(
            [
                "id" => $id,
            ],
            [
                "name" => $name,
                "email" => $email,
                "country" => $country,
                "address" => $address,
                "city" => $city,
                "status" => $status,
                "points" => $points
            ],
        );
        return $member;
    }
}