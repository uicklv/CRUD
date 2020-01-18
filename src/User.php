<?php

namespace App;

class User extends Model
{

    protected $id;
    protected $email;


    public function __construct($id, $email)
    {
        $this->setId($id);
        $this->setEmail($email);
    }

    public static function find($id)
    {
        $data = parent::find($id);

        return new self($data['id'], $data['email']);

    }

    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
    }


    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }
}