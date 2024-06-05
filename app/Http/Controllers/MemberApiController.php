<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Services\MemberService;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MemberApiController extends Controller
{
    protected $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    public function member(Request $request)
    {
        //リクエストヘッダートークンを取得
        $accessToken = $request->bearerToken();

        //取得したトークンとDBのメンバートークンが一致しているか確認
        $memberToken = $this->memberService->findBy("api_token", "=", $accessToken)->first();

        //トークンが一致するものが存在していれば
        if($memberToken) {
            return response()->json([
                "result" => true,
                "status" => 200,
                "message" => "ユーザー情報を取得しました。",
                "data" => $memberToken
            ]);
        } else {
            return response()->json([
                "result" => false,
                "status" => 401,
                "message" => "ユーザー情報を取得できませんでした。",
            ]);
        }
    }

    public function login(Request $request)
    {
        $email = $request->get("email");
        $password = $request->get("password");

        //メールアドレスが一致するメンバーを検索
        $member = $this->memberService->findBy("email", "=", $email)->first();

        if($member && Hash::check($password, $member->password)) {
            return response()->json([
                "result" => true,
                "status" => 200,
                "message" => "ログインしました。",
                "token" => $member->api_token,
                "data" => $member
            ]);
        }

        if(!$member) {
            return response()->json([
                "result" => false,
                "status" => 401,
                "message" => "メールアドレスが存在しません。",
                "token" => "",
            ]);
        }

        if(!Hash::check($password, $member->password)) {
            return response()->json([
                "result" => false,
                "status" => 401,
                "message" => "パスワードが一致しません。",
                "token" => "",
            ]);
        }
    }
}
