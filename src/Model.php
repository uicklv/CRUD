<?php

namespace App;

 abstract class Model
{



     public function insert()
     {
         $table = self::pluralize(2, strtolower(end(explode('\\', static::class))));
         $pdo = new \PDO('mysql:host=mysql;dbname=docker', 'root', 'password');
         $sql = 'INSERT INTO ' . $table .  ' (' . implode(', ' , array_keys(get_object_vars($this))) . ') VALUES' . ' (:' . implode(', :', array_keys(get_object_vars($this))) . ')';
         $stmt = $pdo->prepare($sql);
         foreach (get_object_vars($this) as $field => $value)
         {
             if ($field == 'id' && $value === null){
                 $stmt->bindValue(':' . $field, $value, \PDO::PARAM_NULL);
                 continue;
             }
             $stmt->bindValue(':' . $field, $value);
         }

         $stmt->execute();

     }

     public function update()
     {
         $table = self::pluralize(2, strtolower(end(explode('\\', static::class))));
         $pdo = new \PDO('mysql:host=mysql;dbname=docker', 'root', 'password');
         $params = array();
         foreach (get_object_vars($this) as $field => $value) {
             if ($field !== 'id') {
                 $params[] = $field . " = '" . $value . "' ";
             }
         }

         $sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $params) . ' WHERE id = :id';
         $stmt = $pdo->prepare($sql);
         $stmt->bindValue(':id', $this->id);
         $stmt->execute();

     }
     public static function find($id)
    {
        $table = self::pluralize(2, strtolower(end(explode('\\', static::class))));
        $pdo = new \PDO('mysql:host=mysql;dbname=docker', 'root', 'password');

        $sql = 'SELECT * FROM ' . $table . ' WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data === false)
        {
            throw new \Exception('Record does not exist.');
        }

        return $data;
    }


     public function delete()
     {
         $table = self::pluralize(2, strtolower(end(explode('\\', static::class))));
         $pdo = new \PDO('mysql:host=mysql;dbname=docker', 'root', 'password');
         $sql = 'DELETE FROM ' . $table . ' WHERE id = :id';
         $stmt = $pdo->prepare($sql);
         $stmt->bindValue(':id', $this->id);
         $stmt->execute();
     }

     public static function pluralize($quantity, $singular, $plural=null) {
         if($quantity==1 || !strlen($singular)) return $singular;
         if($plural!==null) return $plural;

         $last_letter = strtolower($singular[strlen($singular)-1]);
         switch($last_letter) {
             case 'y':
                 return substr($singular,0,-1).'ies';
             case 's':
                 return $singular.'es';
             default:
                 return $singular.'s';
         }
     }

}