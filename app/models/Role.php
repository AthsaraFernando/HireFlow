<?php

class Role
{
    use Model;
    protected $table = 'roles';
    protected $allowedColumns = [
        'id',
        'role_name',
    ];
}