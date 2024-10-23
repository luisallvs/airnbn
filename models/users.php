<?php

require_once("base.php");

class Users extends Base
{

    public function getAll()
    {
        $query = $this->db->query("
        SELECT 
            user_id, 
            name, 
            email, 
            role, 
            phone,
            created_at
        FROM 
            users");

        $query->execute();

        return $query->fetchAll();
    }

    public function countUsers()
    {
        $query = $this->db->prepare("
        SELECT COUNT(*) 
        FROM 
            users");

        $query->execute();
        return $query->fetchColumn();
    }

    public function getLastFiveUsers()
    {
        $query = $this->db->prepare("
            SELECT 
                user_id, 
                name, 
                email, 
                role, 
                created_at
            FROM 
                users
            ORDER BY 
                created_at DESC
            LIMIT 
                5
        ");

        $query->execute();
        return $query->fetchAll();
    }


    public function getById($user_id)
    {
        $query = $this->db->prepare("
        SELECT 
            user_id, 
            name, 
            email, 
            password,
            role, 
            phone, 
            profile_picture,
            created_at
        FROM 
            users 
        WHERE 
            user_id = ?");

        $query->execute([$user_id]);

        return $query->fetch();
    }

    public function getByEmail($email)
    {
        $query = $this->db->prepare("
            SELECT 
                user_id, 
                name, 
                email, 
                password, 
                role, 
                phone,
                profile_picture
            FROM 
                users
            WHERE 
                email = ?
        ");

        $query->execute([$email]);

        return $query->fetch();
    }

    public function create($data)
    {
        $query = $this->db->prepare("
            INSERT INTO users 
                (name, 
                email, 
                password, 
                role, 
                phone, 
                profile_picture,
                created_at) 
            VALUES 
                (?, ?, ?, ?, ?, ?, NOW())
        ");

        $query->execute([
            $data['name'],
            $data['email'],
            $data['password'],
            $data['role'],
            $data['phone'],
            $data['profile_picture']
        ]);

        return $this->db->lastInsertId();
    }

    public function update($user_id, $data)
    {

        /* prepare base query */
        $query = "
            UPDATE 
                users
            SET
                name = ?,
                email = ?,
                phone = ?
        ";

        /* store params */
        $params = [
            $data['name'],
            $data['email'],
            $data['phone']
        ];

        /* add password if exists */
        if (isset($data['password'])) {
            $query .= ", password = ?";
            $params[] = $data['password'];
        }

        /* add profile picture if exists */
        if (isset($data['profile_picture'])) {
            $query .= ", profile_picture = ?";
            $params[] = $data['profile_picture'];
        }

        /* add role if exists */
        if (isset($data['role'])) {
            $query .= ", role = ?";
            $params[] = $data['role'];
        }

        /* where clause */
        $query .= "
            WHERE
                user_id = ?
        ";
        $params[] = $user_id;

        /* prepare and execute query */
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function delete($user_id)
    {
        $query = $this->db->prepare("
        DELETE FROM 
            users 
        WHERE 
            user_id = ?");

        return $query->execute([$user_id]);
    }
}
