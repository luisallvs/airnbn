<?php

require_once("base.php");

class Users extends Base
{

    public function getAll()
    {
        $query = $this->db->query("
        SELECT user_id, name, email, role, phone 
        FROM users");

        $query->execute();

        return $query->fetchAll();
    }

    public function getById($id)
    {
        $query = $this->db->prepare("
        SELECT user_id, name, email, role, phone 
        FROM users 
        WHERE id = ?");

        $query->execute([$id]);

        return $query->fetch();
    }

    public function getByEmail($email)
    {
        $query = $this->db->prepare("
            SELECT user_id, name, email, password, role, phone
            FROM users
            WHERE email = ?
        ");

        $query->execute([$email]);

        return $query->fetch();
    }

    public function create($data)
    {
        // Hash the password
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $query = $this->db->prepare("
            INSERT INTO users 
            (name, email, password, role, phone, created_at) 
            VALUES (?, ?, ?, ?, ?, Default)
        ");

        $query->execute([
            $data['name'],
            $data['email'],
            $hashedPassword,
            $data['role'],
            $data['phone']
        ]);

        // Return the last inserted ID
        return $this->db->lastInsertId();
    }
}
