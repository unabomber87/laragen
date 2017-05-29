<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Artisan;
use Illuminate\Http\Request;
use InfyOm\GeneratorBuilder\Requests\BuilderGenerateRequest;
use Response;

class GeneratorBuilderController extends Controller
{
    public function generate(BuilderGenerateRequest $request)
    {
        $data = $request->all();
        dd(json_encode($data));
        $res = Artisan::call($data['commandType'], [
            'model' => $data['modelName'],
            '--jsonFromGUI' => json_encode($data)
        ]);
        return Response::json("Files created successfully");
    }
}
