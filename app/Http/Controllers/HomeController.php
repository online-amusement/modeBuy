<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Services\MemberService;

class HomeController extends Controller
{
    protected $memberService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MemberService $memberService)
    {
        //$this->middleware('auth');
        $this->memberService = $memberService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $memberId = $request->input('searchMemberId');
        $status = $request->input('searchMemberStatus');
        $startDate = $request->input('searchMemberStartDate');
        $endeDate = $request->input('searchMemberEndDate');
        $sort = $request->input("searchSort");

        $members = $this->memberService->search($memberId, $status, $startDate, $endeDate, $sort);
        //$members->appends(["sort" => "降順"]);
        $members->withQueryString();

        
        return view('home', compact('members'));
    }

    public function create(Request $request)
    {
        $member = null;

        return view('member-edit', compact('member'));
    }

    public function edit(Request $request, $id)
    {
        $accessToken = $request->bearerToken();

        $member = $this->memberService->findBy("id", "=", $id);
        
        $member = json_encode($member);

        return view('member-edit', compact('member'));
    }

    public function save(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $country = $request->input('country');
        $address = $request->input('address');
        $city = $request->input('city');
        $status = $request->input('status');
        $points = $request->input('points');

        $member = $this->memberService->createOrUpdate($id, $name, $email, $country, $address, $city, $status, $points);

        return redirect()->to('/home');
    }

    public function delete(Request $request, $id)
    {
        $memberDelete = $this->memberService->deleteMember($id);

        return redirect()->to('/home');
    }
}
