<?php

namespace App\Repositories\User\Interfaces;

interface UserInterface {
    
    public function getAll();

    public function getAllPagination($page);

    public function getUserRedis();

    public function getUserRedisById($id);

    public function findById($id);

    public function findByEmail($email);

    public function searchByName($name);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);
}