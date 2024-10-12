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

    public function getPaymentMethodById($payment_method_id)
    {
        $query = $this->db->prepare("
        SELECT 
            method_id, 
            method_name
        FROM 
            payment_methods 
        WHERE 
            payment_method_id = ?");
        $query->execute([$payment_method_id]);
        return $query->fetch();
    }
}
