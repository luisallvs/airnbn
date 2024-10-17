<?php

require_once 'base.php';

class Reviews extends Base
{
    /* Get reviews by property */
    public function getReviewsByProperty($property_id)
    {
        $query = $this->db->prepare("
            SELECT 
                r.review_id, 
                r.rating, 
                r.comment, 
                r.created_at, 
                u.name as reviewer_name 
            FROM 
                reviews r 
            JOIN 
                users u ON r.user_id = u.user_id
            WHERE 
                r.property_id = ?
            ORDER BY 
                r.created_at DESC
        ");
        $query->execute([$property_id]);
        return $query->fetchAll();
    }

    /* Add a review */
    public function addReview($data)
    {
        $query = $this->db->prepare("
            INSERT INTO reviews 
                (user_id, 
                property_id, 
                reservation_id,
                rating, 
                comment, 
                created_at)
            VALUES 
                (?, ?, ?, ?, ?, NOW())
        ");
        return $query->execute([
            $data['user_id'],
            $data['property_id'],
            $data['reservation_id'],
            $data['rating'],
            $data['comment']
        ]);
    }

    public function reviewExistsForReservation($reservation_id)
    {
        $query = $this->db->prepare("
            SELECT
                COUNT(*) 
            FROM 
                reviews 
            WHERE 
                reservation_id = ?
        ");
        $query->execute([$reservation_id]);
        return $query->fetchColumn() > 0;
    }
}
