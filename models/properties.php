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
            p.property_id, 
            p.name, 
            p.description, 
            p.city, 
            p.country,
            p.price_per_night, 
            p.max_guests, 
            p.availability_start, 
            p.availability_end,
            u.name AS owner_name,
            p.created_at
        FROM 
            properties p
        JOIN 
            users u ON p.user_id = u.user_id
        WHERE 
            p.availability_end >= CURDATE()
    ");

        $query->execute();
        return $query->fetchAll();
    }


    public function countProperties()
    {
        $query = $this->db->prepare("
        SELECT COUNT(*)  
        FROM 
            properties
    ");

        $query->execute();
        return $query->fetchColumn();
    }

    public function getLastFiveProperties()
    {
        $query = $this->db->prepare("
            SELECT 
                property_id, 
                name, 
                user_id, 
                price_per_night, 
                created_at
            FROM 
                properties
            ORDER BY 
                created_at DESC
            LIMIT 
                5
        ");

        $query->execute();
        return $query->fetchAll();
    }


    public function getAllWithImages()
    {
        $query = $this->db->prepare("
        SELECT 
            p.property_id, 
            p.name, 
            p.description, 
            p.city, 
            p.country, 
            p.price_per_night, 
            p.max_guests,
            p.availability_start,
            p.availability_end,
            pi.image_url
        FROM 
            properties p
        LEFT JOIN 
            property_images pi ON p.property_id = pi.property_id
        GROUP BY 
            p.property_id
    ");

        $query->execute();
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
            p.property_id,
            p.name,
            p.description,
            p.city,
            p.country,
            p.price_per_night,
            p.max_guests,
            p.availability_start,
            p.availability_end,
            MIN(pi.image_url) AS image_url -- ensure that gets tje first image
        FROM 
            properties p
        LEFT JOIN 
            property_images pi ON p.property_id = pi.property_id
        WHERE 
            p.user_id = ?
        GROUP BY 
            p.property_id, 
            p.name, 
            p.description, 
            p.city, 
            p.country, 
            p.price_per_night, 
            p.max_guests, 
            p.availability_start, 
            p.availability_end
    ");
        $query->execute([$host_user_id]);
        return $query->fetchAll();
    }

    /* Update a property */
    public function update($data)
    {
        $query = $this->db->prepare("
        UPDATE 
            properties 
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
            property_id = ?
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
            $data['property_id']
        ]);
    }

    public function hasActiveOrFuturePayments($property_id)
    {
        $query = $this->db->prepare("
            SELECT 
                COUNT(p.payment_id) 
            FROM 
                payments p
            JOIN 
                reservations r ON p.reservation_id = r.reservation_id
            WHERE 
                r.property_id = ?
            AND 
                r.check_out > CURDATE()  -- Check if the reservation's check-out date is in the future or today
        ");
        $query->execute([$property_id]);
        return $query->fetchColumn() > 0;  // Returns true if there are active or future payments
    }

    /* Delete a property */
    public function delete($property_id)
    {
        $query = $this->db->prepare("
            DELETE FROM 
                properties 
            WHERE 
                property_id = ? 
        ");

        return $query->execute([$property_id]);
    }
}
