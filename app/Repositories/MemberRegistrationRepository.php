<?php

namespace App\Repositories;

use App\Models\Member;
use App\Models\TemporaryRegistration;
use Carbon\Carbon;

class MemberRegistrationRepository
{
    protected $member;
    
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    public function createTemporaryMember($email, $token) 
    {
        return $this->member
            ->newQuery()
            ->create([
                "email" => $email,
                "api_token" => $token,
                "status" => 0,
            ]);
    }

}
