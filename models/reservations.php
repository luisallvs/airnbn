<?php

require_once 'base.php';

class Reservations extends Base
{

    public function createReservation($data)
    {
        $query = $this->db->prepare("
            INSERT INTO reservations 
                (user_id, 
                property_id, 
                check_in, 
                check_out, 
                total_price, 
                status, 
                is_paid,
                created_at) 
            VALUES 
                (?, ?, ?, ?, ?, 'pending', ?, NOW())
        ");

        $query->execute([
            $data['user_id'],
            $data['property_id'],
            $data['check_in'],
            $data['check_out'],
            $data['total_price'],
            $data['is_paid']
        ]);

        return $this->db->lastInsertId();
    }

    public function getReservationById($reservation_id)
    {
        $query = $this->db->prepare("
            SELECT 
            r.reservation_id, 
            r.user_id, 
            r.property_id, 
            p.name AS property_name, 
            p.address AS property_address, 
            p.city AS property_city, 
            r.check_in, 
            r.check_out, 
            r.total_price, 
            r.status, 
            r.is_paid,
            r.created_at 
        FROM 
            reservations r
        INNER JOIN 
            properties p ON r.property_id = p.property_id
        WHERE 
            r.reservation_id = ?
        ");

        $query->execute([$reservation_id]);
        return $query->fetch();
    }

    public function getReservationsByUser($user_id)
    {
        $query = $this->db->prepare("
            SELECT 
                r.reservation_id, 
                r.property_id, 
                p.name AS property_name, 
                r.check_in, 
                r.check_out, 
                r.total_price, 
                r.status, 
                r.is_paid,
                r.created_at 
            FROM 
                reservations r
            INNER JOIN 
                properties p ON r.property_id = p.property_id
            WHERE 
                r.user_id = ?
            ORDER BY 
                r.created_at DESC
        ");

        $query->execute([$user_id]);
        return $query->fetchAll();
    }

    public function getReservationsByHost($host_user_id)
    {
        $query = $this->db->prepare("
        SELECT 
            r.reservation_id,
            r.user_id,
            r.property_id,
            r.check_in,
            r.check_out,
            r.total_price,
            r.status,
            r.is_paid,
            r.created_at,
            r.updated_at,
            p.name AS property_name
        FROM 
            reservations r
        JOIN 
            properties p ON r.property_id = p.property_id
        WHERE 
            p.user_id = ?
    ");
        $query->execute([$host_user_id]);

        return $query->fetchAll();
    }

    public function getReservationsByProperty($property_id)
    {
        $query = $this->db->prepare("
            SELECT 
                r.reservation_id, 
                r.user_id, 
                u.name AS user_name, 
                r.check_in, 
                r.check_out, 
                r.total_price, 
                r.status, 
                r.is_paid,
                r.created_at 
            FROM 
                reservations r
            INNER JOIN 
                users u ON r.user_id = u.user_id
            WHERE 
                r.property_id = ?
            ORDER BY 
                r.created_at DESC
        ");

        $query->execute([$property_id]);
        return $query->fetchAll();
    }

    public function updateReservationStatus($reservation_id, $status)
    {
        $query = $this->db->prepare("
            UPDATE 
                reservations 
            SET 
                status = ? 
            WHERE 
                reservation_id = ?
        ");

        return $query->execute([$status, $reservation_id]);
    }

    public function isAvailable($property_id, $check_in, $check_out)
    {
        $query = $this->db->prepare("
        SELECT 
            reservation_id
        FROM 
            reservations 
        WHERE 
            property_id = ? 
            AND status IN ('pending', 'confirmed')
            AND (
                (check_in < ? AND check_out > ?)  -- new reservaton check in falls within an existing reservation.
                OR 
                (check_in < ? AND check_out > ?)  -- new reservation check out falls within an existing reservation.
                OR
                (check_in >= ? AND check_out <= ?)  -- new reservation completely overlaps an existing reservation.
            )
    ");

        $query->execute([
            $property_id,
            $check_out,  // check if the new check out date overlaps with existing reservations.
            $check_in,   // check if the new check in date overlaps with existing reservations.
            $check_out,  // check if the new check out date falls within an existing reservation.
            $check_in,   // check if the new check in date falls within an existing reservation.
            $check_in,   // check if the new reservation completely overlaps an existing reservation.
            $check_out   // check if the new reservation completely overlaps an existing reservation.
        ]);

        /* If no rows are returned then the reservation is available */
        return $query->rowCount() === 0;
    }

    public function getUnavailableDates($property_id)
    {
        $query = $this->db->prepare("
        SELECT 
            check_in, 
            check_out
        FROM 
            reservations 
        WHERE 
            property_id = ? 
            AND status = 'confirmed'
    ");

        $query->execute([$property_id]);
        return $query->fetchAll();
    }

    public function markAsPaid($reservation_id)
    {
        $query = $this->db->prepare("
        UPDATE 
            reservations 
        SET 
            is_paid = 1 
        WHERE 
            reservation_id = ?
    ");
        return $query->execute([$reservation_id]);
    }
}
