<?php

namespace App;

class Post extends Model
{

    protected $id;
    protected $name;
    protected $created_at;

    public function __construct($id, $name, $created_at)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setCreatedAt($created_at);
    }

    public static function find($id)
    {
        $data = parent::find($id);

        return new self($data['id'], $data['name']);

    }


    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }


    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
    }


    public function getName()
    {
        return $this->name;
    }


    public function setName($name)
    {
        $this->name = $name;
    }
}