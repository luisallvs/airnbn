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
            country,
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
            properties.property_id,
            properties.name,
            properties.description,
            properties.city,
            properties.country,
            properties.price_per_night,
            properties.max_guests,
            properties.availability_start,
            properties.availability_end,
            property_images.image_url
        FROM 
            properties
        LEFT JOIN 
            property_images ON properties.property_id = property_images.property_id
        WHERE 
            properties.user_id = ?
        GROUP BY 
            properties.property_id
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
    public function delete($property_id, $user_id)
    {
        $query = $this->db->prepare("
            DELETE FROM 
                properties 
            WHERE 
                property_id = ? 
            AND 
                user_id = ?
        ");

        return $query->execute([$property_id, $user_id]);
    }
}
