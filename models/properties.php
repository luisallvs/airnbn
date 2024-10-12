<?php

require_once 'base.php';

class Properties extends Base
{

    /* Create a new property */
    public function create($data)
    {
        $query = $this->db->prepare("
            INSERT INTO properties 
                (user_id, 
                name, 
                description, 
                address, 
                city, 
                country, 
                price_per_night, 
                max_guests, 
                availability_start, 
                availability_end) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $query->execute([
            $data['user_id'],
            $data['name'],
            $data['description'],
            $data['address'],
            $data['city'],
            $data['country'],
            $data['price_per_night'],
            $data['max_guests'],
            $data['availability_start'],
            $data['availability_end']
        ]);

        return $this->db->lastInsertId();
    }

    /* Get all properties */

    public function getAll()
    {
        $query = $this->db->prepare("
        SELECT 
            property_id, 
            name, 
            description, 
            city, 
            price_per_night, 
            max_guests, 
            availability_start, 
            availability_end
        FROM 
            properties 
        WHERE 
            availability_end >= CURDATE()
    ");

        $query->execute();
        return $query->fetchAll();
    }

    /* GEt properties for a specific user */
    public function getByUserId($user_id)
    {
        $query = $this->db->prepare("
            SELECT 
                property_id, 
                user_id, 
                name, 
                description, 
                address, 
                city, 
                country, 
                price_per_night, 
                max_guests, 
                availability_start, 
                availability_end, 
                created_at, 
                updated_at
            FROM 
                properties 
            WHERE 
                user_id = ?
        ");
        $query->execute([$user_id]);
        return $query->fetchAll();
    }

    /* Get a specific property by its ID */
    public function getById($property_id)
    {
        $query = $this->db->prepare("
            SELECT 
                property_id, 
                user_id, 
                name, 
                description, 
                address, 
                city, 
                country, 
                price_per_night, 
                max_guests, 
                availability_start, 
                availability_end, 
                created_at, 
                updated_at
            FROM 
                properties 
            WHERE 
                property_id = ?
        ");

        $query->execute([$property_id]);

        return $query->fetch();
    }

    public function getPropertiesByHost($host_user_id)
    {
        $query = $this->db->prepare("
        SELECT
            property_id,
            user_id,
            name,
            description,
            address,
            city,
            country,
            price_per_night,
            max_guests,
            availability_start,
            availability_end
            created_at,
            updated_at
        FROM 
            properties 
        WHERE user_id = ?
    ");
        $query->execute([$host_user_id]);
        return $query->fetchAll();
    }

    /* Update a property */
    public function update($data)
    {
        $query = $this->db->prepare("
            UPDATE properties 
            SET 
                name = ?,
                description = ?, 
                address = ?, 
                city = ?, 
                country = ?, 
                price_per_night = ?, 
                max_guests = ?, 
                availability_start = ?, 
                availability_end = ?
            WHERE 
                property_id = ? AND user_id = ?
        ");

        return $query->execute([
            $data['name'],
            $data['description'],
            $data['address'],
            $data['city'],
            $data['country'],
            $data['price_per_night'],
            $data['max_guests'],
            $data['availability_start'],
            $data['availability_end'],
            $data['property_id'],
            $data['user_id']
        ]);
    }

    /* Delete a property */
    public function delete($property_id, $user_id)
    {
        $query = $this->db->prepare("
            DELETE FROM properties 
            WHERE 
                property_id = ? 
            AND 
                user_id = ?
        ");

        return $query->execute([$property_id, $user_id]);
    }
}
