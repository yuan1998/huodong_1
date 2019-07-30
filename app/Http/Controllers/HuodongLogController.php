<?php
namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\HuodongLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HuodongLogController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->only(['name' , 'department' , 'number']);

        $huodong = HuodongLog::create($data);

        return response($huodong , 200);
    }

    public function  uploadImage(Request $request , ImageUploadHandler $uploadHandler , HuodongLog $huodongLog ) {
        Log::debug($huodongLog);

        $result = $uploadHandler->save($request->image , 'huodong', $huodongLog->id);

        $huodongLog->image = $result['path'];
        $huodongLog->save();
        return response(null , 204);

    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getNumber ()
    {
        $number = $this->randomNumber();

        return response($number, 200);
    }

    /**
     * @return string
     */
    public function randomNumber(): string
    {
        $number = (string)rand(0, 10000);
        if (strlen($number) < 4) {
            $number = str_pad($number, 4, '0', STR_PAD_LEFT);
        }
        if ($this->numberExists($number)) {
            return $this->randomNumber();
        }

        return $number;
    }

    /**
     * @param $number string
     * @return bool
     */
    public function numberExists($number): bool
    {

        return HuodongLog::query()->where('number', $number)->exists();
    }
}
