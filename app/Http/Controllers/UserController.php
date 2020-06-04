<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Helpers\ResponseCode;
use App\Repositories\User\Interfaces\UserInterface as UserInterface;

class UserController extends Controller
{
    //

    private $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            'type' => 'required'
        ]);
        
        $user = $this->userRepository->findByEmail($request->email);

        //check password
        if (!Hash::check($request->password, $user->password)) {
            //return failed
            return ResponseCode::RESPONSE_PASSWORD();
        }
        //check auth role
        // jika role admin maka bisa create dan insert data users
        // selain role admin hanya bisa ngeliat users
        $setRole = $user->role == 'admin' ? ['user:index', 'user:create', 'user:update', 'user:delete']:['user:index'];
        return ResponseCode::RESPONSE_ACCEPTED($user->createToken($request->type, $setRole)->plainTextToken);

    }

    public function index()
    {
        $users = $this->userRepository->getAllPagination(5);
        return ResponseCode::RESPONSE_SUCCESS($users);
    }

    public function show($id)
    {
        $user = $this->userRepository->findById($id);

        if(count($user) > 0){ //mengecek apakah data kosong atau tidak
            return ResponseCode::RESPONSE_SUCCESS($user);
        }
        else{
            return ResponseCode::RESPONSE_NOT_FOUND();
        }
    }

    public function searchByName($name)
    {

        $users = $this->userRepository->searchByName($name);
        if(count($users) > 0){ //mengecek apakah data kosong atau tidak
            return ResponseCode::RESPONSE_SUCCESS($users);
        }
        else{
            return ResponseCode::RESPONSE_NOT_FOUND();
        }
    }

    public function store(Request $request)
    {
        $checkEmail = $this->userRepository->findByEmail($request->email);
        // dd($checkEmail);
        if ($checkEmail != null) {
          return ResponseCode::RESPONSE_EXIST();
        }

        $user = $request->user();
        //cek role yang dikirimkan ketika pas get token
        if ($user->tokenCan('user:create')) {
            //jika sukses maka insert datanya
            $arrData = array (
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role
            );
            $user = $this->userRepository->create($arrData);
            return ResponseCode::RESPONSE_CREATED($user);
        }
        //jika gagal maka return Unauthorized
        return ResponseCode::RESPONSE_UNAUTHORIZED();
    }


    public function update(Request $request, $id)
    {
        $users = $this->userRepository->findById($id);
        if(count($users) > 0){ 
            //mengecek apakah data kosong atau tidak
            $user = $request->user();
            if ($user->tokenCan('user:update')) {
                $arrData = array (
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'role' => $request->role
                );

                $user = $this->userRepository->update($arrData, $id);
                return ResponseCode::RESPONSE_UPDATE($user);
            }
            //jika gagal maka return Unauthorized
            return ResponseCode::RESPONSE_UNAUTHORIZED();
        }
        else{
            return ResponseCode::RESPONSE_NOT_FOUND();
        }
    }

    public function delete(Request $request, $id)
    {
      // dd($id);
        $users = $this->userRepository->findById($id);
        if(count($users) > 0){ //mengecek apakah data kosong atau tidak
          $user = $request->user();
          if ($user->tokenCan('user:delete')) {
              $this->userRepository->delete($id);
              return ResponseCode::RESPONSE_DELETE($id);
          }
        }
        else{
            return ResponseCode::RESPONSE_NOT_FOUND();
        }
    }

    //method get all token user
    public function getAllUserToken()
    {
        $users = request()->user();
        return ResponseCode::RESPONSE_SUCCESS($users->tokens);
    }

    public function revokeToken()
    {
        $user = request()->user();
        if (request()->token_id) {
            //MAKA HAPUS BERDASARKAN ID TOKEN TERSEBUT
            $user->tokens()->where('id', request()->token_id)->delete();
            return ResponseCode::RESPONSE_SUCCESS($user);
        }
        //SELAIN ITU, HAPUS SEMUA DATA TOKEN
        $user->tokens()->delete();
        return ResponseCode::RESPONSE_SUCCESS($user);
    }

    public function getUserRedis()
    {   
        $user = $this->userRepository->getUserRedis();

        return $user ? ResponseCode::RESPONSE_SUCCESS($user->toArray()) : ResponseCode::RESPONSE_ERROR();
    }

    public function getUserRedisById($id)
    {   
        $user = $this->userRepository->getUserRedisById($id);

        return $user ? ResponseCode::RESPONSE_SUCCESS($user->toArray()) : ResponseCode::RESPONSE_ERROR();
    }

    public function getUserDb()
    {
        $users = $this->userRepository->getAll();
        foreach ($users as $q) {
            echo "<li>{$q->name}</li>";
        }
    }

}
