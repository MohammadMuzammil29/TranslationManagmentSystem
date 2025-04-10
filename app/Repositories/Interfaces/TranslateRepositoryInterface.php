<?php

namespace App\Repositories\Interfaces;

interface TranslateRepositoryInterface
{
    public function create(array $data);
    public function get();
    public function update(int $id, array $data);
    public function search(array $filters);
}
