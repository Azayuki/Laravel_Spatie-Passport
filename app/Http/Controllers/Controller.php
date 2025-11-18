<?php

namespace App\Http\Controllers;

abstract class Controller
{
    // REQUESTS
    // 400 -> bad request
    // with validator error
    protected function BadRequest($validator){
        // response()->json(object, request_code);
        return response()->json(['ok'=>false, 'errors'=> $validator->errors()], 400);
    }

    // without validator error
    protected function Error($message = "Something went wrong.", $data = null){
        return response()->json(['ok'=>false,'data'=>$data, 'message'=>$message], 400);
    }

    // 200 -> ok request
    protected function Ok($data = null, $message = "OK", $others = null){
        return response()->json(['ok'=>true,'data'=>$data, 'message'=>$message, 'others'=>$others], 200);
    }

    // 404 -> not found
    protected function NoDataFound(){
        return response()->json(['ok'=> false, 'message'=>'No Data Found.'],404);
    }

    // 401 -> unauthorized
    protected function Unauthorized($message = "Unauthorized!"){
        return response()->json(['ok'=>false, 'message'=> $message], 401);
    }

    // 201 -> created
    protected function Created($data = null, $message = "Created!"){
        return response()->json(['ok'=>true,'data'=>$data, 'message'=>$message], 201);
    }

    // 204 -> no content
    protected function NoContent($message = "No Content"){
        return response()->json(['ok'=>true, 'message'=>$message], 204);
    }
}