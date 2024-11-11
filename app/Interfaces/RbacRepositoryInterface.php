<?php

namespace App\Interfaces;

interface RbacRepositoryInterface
{
    public function index(): mixed;
    public function getById($id): mixed;
    public function store(array $data): mixed;
    public function update(array $data,$id): mixed;
    public function delete($id): mixed;
    public function update_role_permission(array $attributes): mixed;
}
