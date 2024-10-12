<?php

require_once 'base.php';

class Payments extends Base
{
    public function createPayment($data)
    {
        $query = $this->db->prepare("
            INSERT INTO payments 
            (reservation_id, 
            method_id, 
            amount, 
            status, 
            payment_date)
            VALUES (?, ?, ?, ?, NOW())
        ");
        return $query->execute([
            $data['reservation_id'],
            $data['method_id'],
            $data['amount'],
            $data['status']
        ]);
    }

    public function getPaymentById($payment_id)
    {
        $query = $this->db->prepare("
        SELECT 
            payment_id, 
            reservation_id, 
            method_id, 
            amount, 
            payment_date, 
            status 
        FROM 
            payments 
        WHERE 
            payment_id = ?
    ");
        $query->execute([$payment_id]);
        return $query->fetch();
    }
}
