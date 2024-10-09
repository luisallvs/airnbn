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
            phone 
        FROM 
            users");

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
                phone
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
        // Hash the password
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        /* handle profile picure */
        $profilePicturePath = null;
        if (!empty($data['profile_picture'])) {
            /* decode base64 */
            $decodedImage = base64_decode($data['profile_picture']);

            /* create a unique file name */
            $fileName = bin2hex(random_bytes(16)) . '.jpg';

            /* define path where image will be stored */
            $imageDirectory = __DIR__ . '/../images';

            if (!is_dir($imageDirectory)) {
                mkdir($imageDirectory, 0777, true);
            }

            $filePath = $imageDirectory . '/' . $fileName;

            /* save image */
            file_put_contents($filePath, $decodedImage);

            /* store the relative path */
            $profilePicturePath = "/images/" . $fileName;
        }

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
                (?, ?, ?, ?, ?, ?, Default)
        ");

        $query->execute([
            $data['name'],
            $data['email'],
            $hashedPassword,
            $data['role'],
            $data['phone'],
            $profilePicturePath
        ]);

        // Return the last inserted ID
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

        /* check if password is provide */
        if (!empty($data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $query .= ", password = ?";
            $params[] = $hashedPassword;
        }

        /* check if profile picture is provided */
        if (!empty($data["profile_picture"])) {
            /* decode base64 */
            $decodedImage = base64_decode($data['profile_picture']);
            $fileName = bin2hex(random_bytes(16)) . '.jpg';
            $imageDirectory = __DIR__ . '/../images';

            if (!is_dir($imageDirectory)) {
                mkdir($imageDirectory, 0777, true);
            }

            $filePath = $imageDirectory . '/' . $fileName;

            /* save image */
            file_put_contents($filePath, $decodedImage);

            /* store the relative path */
            $profilePicturePath = "/images/" . $fileName;

            $query .= ", profile_picture = ?";
            $params[] = $profilePicturePath;
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
}
