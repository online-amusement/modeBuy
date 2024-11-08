<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\ObjectLineupTag;
use App\Models\ObjectLineupSoftware;
use App\Services\ObjectService;
use App\Services\TagService;
use App\Services\SoftwareService;
use App\Services\ObjectlineupTagService;
use App\Services\ObjectlineupSoftwareService;
use App\Models\ObjectLineup;

class ObjectController extends Controller
{
    protected $objectService;
    protected $tagService;
    protected $softwareService;
    protected $objectlineupTagService;
    protected $objectlineupSoftwareService;

    public function __construct(ObjectService $objectService, TagService $tagService, SoftwareService $softwareService, ObjectlineupTagService $objectlineupTagService, ObjectlineupSoftwareService $objectlineupSoftwareService)
    {
        $this->objectService = $objectService;
        $this->tagService = $tagService;
        $this->softwareService = $softwareService;
        $this->objectlineupTagService = $objectlineupTagService;
        $this->objectlineupSoftwareService = $objectlineupSoftwareService;
    }

    public function index(Request $request)
    {
        $objectId = $request->input('searchObjectId');
        $name = $request->input('searchName');
        $amount = $request->input('searchAmount');
        $started_at = $request->input('searchObjectStartDate');
        $ended_at = $request->input('searchObjectEndDate');
        $sort = $request->input('searchSort');

        $objectLineups = $this->objectService->search($objectId, $name, $amount, $started_at, $ended_at, $sort);

        $objectLineups->withQueryString();

        return view('object-lineup', compact('objectLineups'));
    }

    public function create(Request $request)
    {
        $objectLineup = null;
        
        $tagCategories = $this->tagService->tagCategories();

        $tagCategories = json_encode($tagCategories);

        $softwareCategories = $this->softwareService->softwareCategories();

        $softwareCategories = json_encode($softwareCategories);

        return view('object-lineup-edit', compact('objectLineup', 'tagCategories', 'softwareCategories'));
    }

    public function edit(Request $request, $id)
    {
        $accessToken = $request->bearerToken();

        $objectLineup = $this->objectService->findBy("id", "=", $id);
        
        $objectLineup = json_encode($objectLineup);

        $tagCategories = $this->tagService->tagCategories();

        $tagCategories = json_encode($tagCategories);

        $objectLineupTag = $this->objectlineupTagService->findBy(ObjectLineupTag::OBJECT_LINEUP_ID, "=", $id)->get()->toArray();
    
        $objectLineupTag = json_encode($objectLineupTag);

        $objectLineupSoftware = $this->objectlineupSoftwareService->findBy(ObjectLineupSoftware::OBJECT_LINEUP_ID, "=", $id)->get()->toArray();

        $objectLineupSoftware = json_encode($objectLineupSoftware);

        $softwareCategories = $this->softwareService->softwareCategories();

        $softwareCategories = json_encode($softwareCategories);

        return view('object-lineup-edit', compact('objectLineup', 'tagCategories', 'softwareCategories', 'objectLineupTag', 'objectLineupSoftware'));
    }

    public function save(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $description = $request->input('description');
        $amount = $request->input('amount');
        $previewFile = $request->file('previewFile');
        $downloadFile = $request->file('downloadFile');
        $tagId = $request->get('tagChains');
        $softwareId = $request->get('softwareChains');

        $objectLineup = $this->objectService->createOrUpdate($id, $name, $description, $amount, $previewFile, $downloadFile);

        //中間テーブルの更新(tags)
        $objectLineup->tags()->sync($tagId);

        //中間テーブルの更新(softwares)
        $objectLineup->softwares()->sync($softwareId);

        return redirect()->to("/object-lineup");
    }

    public function delete(Request $request, $id)
    {
        $objectLineup = $this->objectService->deleteObject($id);

        return redirect()->to("/object-lineup");
    }

    public function objectLineUp(Request $request)
    {
        //if($request->input("download")){

            $objectId = $request->get('id');
            
            //ダウンロード用のURLを作成する
            $objectLineup = $this->objectService->getObjectLineUp();
        
            $download_file = parse_url($objectLineup->download_file);
            $path = $download_file["path"];
            $signedUrl = Storage::disk("s3")->temporaryUrl($path, now()->addMinute(2));
            $downloadData = redirect()->away($signedUrl);
            

            return response()->json([
                "result" => true,
                "status" => 200,
                "message" => "ユーザー情報を取得しました。",
                "data" => $downloadData,
            ]);
            
            /*
            //$path = "download/2024719__earth.obj";
            $path = "/download/bankpank_woman.jpeg";
            //$url = Storage::disk('s3')->url($path);
            //$url = Storage::cloud('s3')->url($path);
            //dd($url);
            //$file = Storage::disk("s3")->get($path);
            //dd($file);
            $url = Storage::disk("s3")->temporaryUrl($path, now()->addMinute(5));
            echo "<img src='{$url}' />";
            exit;
            */
        //}
    }

    public function objectLineUpData(Request $request)
    {
        $objectLineup = $this->objectService->getObjectLineUp();
        
        if($objectLineup) {
            return response()->json([
                "result" => true,
                "status" => 200,
                "message" => "ユーザー情報を取得しました。",
                "data" => $objectLineup,
            ]);
        }

        return response()->json([
            "result" => true,
            "status" => 401,
            "message" => "オブジェクトが存在しません。",
        ]);
    }
}
