<?php
namespace App\Repositories\User;

use App\Repositories\User\Interfaces\UserInterface as UserInterface;
use App\Models\User;
use \Cache;

class UserRepository implements UserInterface {
    
    protected $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {
        $data = User::all();
        return $data;
    }

    public function getAllPagination($page)
    {
        $data = User::paginate($page);
        return $data;
    }

    public function getUserRedis()
    {
        return Cache::remember('cache.user', $minutes='60', function()
        {
            return User::all();
        });
    }

    public function getUserRedisById($id)
    {
        return Cache::remember("cache.user.{$id}", $minutes='60', function() use($id)
        {
            if(Cache::has('cache.user')) return Cache::has('cache.user')->find($id); 

            return User::find($id);
        });
    }
    
    public function findById($id)
    {
        $data =  User::where('id','=',$id)->get();
        return $data;
    }

    public function findByEmail($email)
    {
        $data = User::where('email', $email)->first();
        return $data;
    }

    public function searchByName($name)
    {
        $data = User::Where('name', 'like', '%' . $name . '%')->get();
        return $data;
    }

    public function create(array $attributes)
    {
        return User::create($attributes);
    }

    public function update(array $attributes, $id)
    {
        $record = User::find($id);
        $record->update($attributes);
        return $record;
    }

    public function delete($id)
    {
        return User::destroy($id);
    }
}