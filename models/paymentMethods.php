<?php

require_once 'base.php';

class PaymentMethods extends Base
{
    public function getAllPaymentMethods()
    {
        $query = $this->db->prepare("
        SELECT 
            method_id, 
            method_name 
        FROM 
            payment_methods
        ");
        $query->execute();
        return $query->fetchAll();
    }
}
