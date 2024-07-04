<?php

namespace App\Repositories;

use App\Models\TemporaryRegistration;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TemporaryRegistrationRepository
{
    protected $temporaryRegistration;


    public function __construct(TemporaryRegistration $temporaryRegistration)
    {
        $this->temporaryRegistration = $temporaryRegistration;
    }

    //仮登録(メールアドレス、トークン,有効期限)
    public function createTemporaryRegistration($email)
    {
        //日時生成
        $now = new Carbon();
        $expirationDate = $now->addHour();

        //トークン生成
        $token = Str::random(80);

        return $this->temporaryRegistration
            ->newQuery()
            ->create([
                'email' => $email,
                'token' => $token,
                'expiration_date' => $expirationDate,
            ]);
    }

    //temporaryRegistrationのカラム削除
    public function DeleteByTemporaryRegistration($email)
    {
        //日時生成
        $now = new Carbon();

        return $this->temporaryRegistration
            ->newQuery()
            ->where("email", "=", $email)
            ->orWhere("expiration_date", "<=", $now)
            ->delete();
    }

    //検索
    public function findBy($field, $operator, $value)
    {
        return $this->temporaryRegistration
            ->newQuery()
            ->where($field, $operator, $value);   
    }
}
