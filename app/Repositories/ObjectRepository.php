<?php

namespace App\Repositories;

use App\Models\ObjectLineup;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class ObjectRepository
{
    protected $objectLineup;

    const DESC = "desc";
    const ASC = "asc";

    public function __construct(ObjectLineup $objectLineup)
    {
        $this->objectLineup = $objectLineup;
    }

    public function search($objectId, $name, $amount, $started_at, $ended_at, $sort) 
    {
        $objectLineup = $this->objectLineup->newQuery();

        if($objectId != null) {
            $objectLineup = $objectLineup->where("id", "=", $objectId);
        }

        if($name != null) {
            $objectLineup = $objectLineup->where("name", "=", $name);
        }

        if($amount != null) {
            $objectLineup = $objectLineup->where("amount", "=", $amount);
        }

        if($started_at != null) {
            $objectLineup = $objectLineup
                ->where("created_at", ">", $started_at)
                ->where("created_at", "<", $ended_at);
        }

        if($sort == "降順") {
            return $objectLineup
                ->orderBy("id", self::DESC)
                ->paginate(10);
        }else {
            return $objectLineup
                ->orderBy("id", self::ASC)
                ->paginate(10);
        }
    }

    public function findBy($field, $operator, $value)
    {
        return $this->objectLineup
            ->newQuery()
            ->where($field, $operator, $value)
            ->first();
    }

    public function createOrUpdate($id, $name, $description, $amount, $previewFile, $downloadFile)
    {
        $objectLineup = $this->objectLineup->newQuery();

        $objectFile = $objectLineup->find($id);

        if($previewFile == null)
        {
            if($objectFile->preview_file == null) {
                $fullPreviewFilePath = null;
            }else {
                $fullPreviewFilePath = $objectFile->preview_file;
            }
        }else {
            $objectPreviewFile = $previewFile;

            $objectPreviewFile = $previewFile->getClientOriginalName();
            
            $now = Carbon::now();

            $fileName = $now->year . $now->month. $now->day . '_' . Str::random() . "_" . $previewFile->getClientOriginalName();

            $path = "/preview/" . $fileName;

            /**
             * @var UploadedFile $previewFile
             */
            $uploaded = $previewFile->storeAs("/preview", $fileName, "s3");
            
            if($uploaded){
                $fullPreviewFilePath = Storage::cloud('s3')->url($path);
            }

        }

        if($downloadFile == null)
        {
            if($objectFile->download_file == null) {
                $fulldownloadFilePath = null;
            }else {
                $fulldownloadFilePath = $objectFile->download_file;
            }
        }else {
            $objectDownloadFile = $downloadFile;

            $now = Carbon::now();

            $fileName = $now->year . $now->month. $now->day . '_' . Str::random() . "_" . $objectDownloadFile->getClientOriginalName();

            $path = '/download/' . $fileName;

            /**
             * @var UploadedFile $previewFile
             */
            //S3にアップロード
            $uploaded = $downloadFile->storeAs("/download", $fileName, "s3");
            
            if($uploaded){
                //フルパスの取得
                $fulldownloadFilePath = Storage::cloud('s3')->url($path);
            }
        }

        $objectLineup = $objectLineup->updateOrCreate(
            [
                "id" => $id
            ],
            [
                "name" => $name,
                "description" => $description,
                "amount" => $amount,
                "preview_file" => $fullPreviewFilePath,
                "download_file" => $fulldownloadFilePath,
            ],
        );

        return $objectLineup;
    }

    public function deleteObject($id)
    {
        return $this->objectLineup
            ->newQuery()
            ->where("id", $id)
            ->delete();
    }

    public function getObjectLineUp()
    {
        return $this->objectLineup
            ->newQuery()
            ->get();
    }
}