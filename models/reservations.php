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

    public function getAll()
    {
        $query = $this->db->prepare("
        SELECT 
            r.reservation_id, 
            r.user_id, 
            u.name AS user_name,
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
        INNER JOIN 
            users u ON r.user_id = u.user_id 
        ORDER BY 
            r.created_at DESC
    ");

        $query->execute();
        return $query->fetchAll();
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
                CASE WHEN r.is_paid = 1 THEN 'Paid' ELSE 'Not Paid' END AS payment_status,
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

    public function getRecentReservations()
    {
        $query = $this->db->prepare("
            SELECT 
                r.reservation_id, 
                u.name AS user_name, 
                p.name AS property_name, 
                r.check_in, 
                r.check_out, 
                r.status
            FROM 
                reservations r
            JOIN 
                users u ON r.user_id = u.user_id
            JOIN 
                properties p ON r.property_id = p.property_id
            ORDER BY 
                r.created_at DESC
            LIMIT 
                5
        ");

        $query->execute();
        return $query->fetchAll();
    }

    public function countReservations()
    {
        $query = $this->db->query("
        SELECT COUNT(*) 
        FROM 
            reservations");

        $query->execute();
        return $query->fetchColumn();
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

    public function updateReservation($reservation_id, $data)
    {
        $query = $this->db->prepare("
            UPDATE reservations 
            SET 
                check_in = ?, 
                check_out = ?, 
                status = ?
            WHERE 
                reservation_id = ?
        ");

        return $query->execute([
            $data['check_in'],
            $data['check_out'],
            $data['status'],
            $reservation_id
        ]);
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

    public function updateIsPaid($reservationId, $isPaid)
    {
        $query = $this->db->prepare("
        UPDATE 
            reservations 
        SET 
            is_paid = ? 
        WHERE 
            reservation_id = ?
    ");
        return $query->execute([$isPaid, $reservationId]);
    }

    /* Get recent activities by host */
    public function getRecentActivitiesByHost($user_id)
    {
        $query = $this->db->prepare("
        SELECT 
            r.reservation_id, 
            r.check_in, 
            r.check_out, 
            r.status, 
            r.created_at, 
            p.name as property_name
        FROM 
            reservations r
        JOIN 
            properties p ON r.property_id = p.property_id
        WHERE 
            p.user_id = ?
        ORDER BY 
            r.created_at DESC
        LIMIT 
            10
    ");
        $query->execute([$user_id]);
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

    public function delete($reservation_id)
    {
        $query = $this->db->prepare("
            DELETE FROM 
                reservations 
            WHERE 
                reservation_id = ?
        ");

        return $query->execute([$reservation_id]);
    }
}
