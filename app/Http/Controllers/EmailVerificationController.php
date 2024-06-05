<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemporaryRegistration;
use App\Services\TemporaryRegistrationService;
use App\Services\MemberRegistrationService;
use App\Services\MemberService;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\TemporaryRegistrationRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\Registration;

class EmailVerificationController extends Controller
{
    protected $temporaryRegistration;
    protected $temporaryRegistrationService;
    protected $memberRegistrationService;
    protected $memberService;

    public function __construct(TemporaryRegistration $temporaryRegistration, TemporaryRegistrationService $temporaryRegistrationService, MemberRegistrationService $memberRegistrationService, MemberService $memberService) 
    {
        $this->temporaryRegistration = $temporaryRegistration;
        $this->temporaryRegistrationService = $temporaryRegistrationService;
        $this->memberRegistrationService = $memberRegistrationService;
        $this->memberService = $memberService;
    }

    public function temporaryRegistration(TemporaryRegistrationRequest $request)
    {
        //アドレス取得
        $email = $request->get('email');

        //トークン発行
        $token = Str::random(80);

        //temporary_registrationデータベースに登録
        $temporaryRegistration = $this->temporaryRegistrationService->createTemporaryRegistration($email);

        //temporary_registrationデータベースを検索して同じメールアドレスが存在していて、なおかつ有効期限が切れていた場合有効期限が切れてる方のデータ削除
        //$deleteTemporaryRegistration = $this->temporaryRegistrationService->DeleteByTemporaryRegistration($email);

        //memberに新規登録
        $member = $this->memberRegistrationService->createTemporaryMember($email, $temporaryRegistration->token);

        //仮登録のメールアドレス宛にメールを送信
        Mail::to($email)->send(new \App\Mail\Registration($temporaryRegistration));

        //レスポンスを返す処理
        return response()->json([
            "result" => true,
            "status" => 200,
            "message" => "メールアドレス宛にメールを送信しました。",
            "data" => $member
        ]);

    }

    public function officialRegistration(RegistrationRequest $request) 
    {
        //氏名
        $name = $request->get('name');
        //パスワード
        $password = $request->get('password');
        //トークン
        $token = $request->get('token');
        //国
        $country = $request->get('country');
        //アドレス
        $address = $request->get('address');
        //アドレス2
        $city = $request->get('city');
        
        //メンバーDBに登録
        $memberInfoRegist = $this->memberService->memberInfoRegister($name, $password, $token, $country, $address, $city);

        //メンバー情報取得
        $member = $this->memberService->findBy("api_token", "=", $token)->first();
        
        if($memberInfoRegist) {
            return response()->json([
                "result" => true,
                "status" => 200,
                "message" => "情報を登録しました。",
                "token" => $member->api_token
            ]);
        }

        if(!$memberInfoRegist) {
            return response()->json([
                "result" => false,
                "status" => 401,
                "message" => "情報を登録できませんでした。",
            ]);
        }
    }
}
