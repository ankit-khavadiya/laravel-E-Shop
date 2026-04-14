<?php

namespace App\Http\Traits;

use Yajra\DataTables\Facades\DataTables;

trait ApiParsing
{
    function sendResponse($message,$data,$code = 200){
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data
        ],$code);
    }

    function sendErrorResponse($message,$data,$code = 400){
        return response()->json([
            'status'  => false,
            'message' => $message,
            'error'    => $data
        ],$code);
    }

    function sendException($message)
    {
        return response()->json([
            'status'  => false,
            'message' => ERROR_500,
            'error'   => $message
        ],500);
    }

    function sendSuccess($message,$code = 200){
        return response()->json([
            'status'  => true,
            'message' => $message
        ],$code);
    }

    function sendError($message, $code = 400){
        return response()->json([
            'status'  => false,
            'message' => $message
        ],$code);
    }

    function sendValidationError($data){
        return response()->json([
            'status'  => false,
            'error'    => $data
        ],400);
    }

    function sendDataTableError($message = DT_ERROR, $extra = array(), $status = 400){
        $arr = array();
        return DataTables::of($arr)
            ->with(['recordsFiltered'=> 0, 'recordsTotal' => 0, 'message' => $message])
            ->with($extra)
            ->skipPaging()
            ->make( false)
            ->setStatusCode($status);
    }
}
