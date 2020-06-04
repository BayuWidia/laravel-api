<?php

namespace App\Helpers;

use Carbon\Carbon;


use Auth;

class ResponseCode
{

   public static function RESPONSE_SUCCESS($data)
   {
     return response()->json([
        'message' => 'SUCCESS',
        'status' => 200,
        'data' => $data
      ]);
   }

   public static function RESPONSE_CREATED($data)
   {
     return response()->json([
        'message' => 'SUCCESS INSERT',
        'status' => 201,
        'data' => $data
      ]);
   }

   public static function RESPONSE_ACCEPTED($data)
   {
     return response()->json([
        'message' => 'SUCCESS',
        'status' => 202,
        'data' => $data
      ]);
   }

   public static function RESPONSE_UPDATE($data)
   {
     return response()->json([
        'message' => 'SUCCESS UPDATE',
        'status' => 203,
        'data' => $data
      ]);
   }

   public static function RESPONSE_DELETE($data)
   {
     return response()->json([
        'message' => 'SUCCESS DELETE',
        'status' => 204,
        'data' => $data
      ]);
   }

   public static function RESPONSE_UNAUTHORIZED()
   {
     return response()->json([
        'message' => 'FAILED',
        'status' => 401,
        'data' => 'UNAUTHORIZED'
      ]);
   }

   public static function RESPONSE_PASSWORD()
   {
     return response()->json([
        'message' => 'FAILED',
        'status' => 402,
        'data' => 'PASSWORD FAILED'
      ]);
   }

   public static function RESPONSE_EXIST()
   {
     return response()->json([
        'message' => 'FAILED',
        'status' => 403,
        'data' => 'DATA ALREADY EXISTS'
      ]);
   }

   public static function RESPONSE_NOT_FOUND()
   {
     return response()->json([
        'message' => 'FAILED',
        'status' => 404,
        'data' => 'DATA NOT FOUND'
      ]);
   }

   public static function RESPONSE_ERROR()
   {
     return response()->json([
        'message' => 'ERROR',
        'status' => 500,
        'data' => 'DATA NOT ERROR'
      ]);
   }


}
