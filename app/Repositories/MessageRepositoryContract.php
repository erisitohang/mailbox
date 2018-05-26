<?php

namespace App\Repositories;


use App\Entities\Message;

interface MessageRepositoryContract
{
    public function create(Message $message);
    public function all(int $limit, int $page);
    public function archive(int $limit, int $page);
    public function findById(int $id);
    public function update($message, string $field, $value);
    public function prepareDate($sender, $subject,  $message);
}