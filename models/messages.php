<?php

require_once 'base.php';

class Messages extends Base
{
    public function sendMessage($sender_id, $receiver_id, $property_id, $content)
    {
        $query = $this->db->prepare("
        INSERT INTO 
            messages 
                (sender_id, receiver_id, property_id, content) 
            VALUES 
                (?, ?, ?, ?)");

        $query->execute([$sender_id, $receiver_id, $property_id, $content]);
        return $this->db->lastInsertId();
    }

    public function getConversation($sender_id, $receiver_id, $property_id)
    {
        $query = $this->db->prepare("
            SELECT 
                * 
            FROM 
                messages 
            WHERE 
                ((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)) AND property_id = ? 
            ORDER BY 
                created_at ASC");

        $query->execute([$sender_id, $receiver_id, $receiver_id, $sender_id, $property_id]);
        return $query->fetchAll();
    }

    public function markMessagesAsRead($receiver_id, $property_id)
    {
        $query = $this->db->prepare("
        UPDATE 
            messages
        SET 
            is_read = 1
        WHERE 
            receiver_id = ? AND property_id = ? AND is_read = 0
    ");
        $query->execute([$receiver_id, $property_id]);
    }

    public function getUserConversations($user_id)
    {
        $query = $this->db->prepare("
        SELECT 
            m.property_id, 
            p.name AS property_name, 
            CASE 
                WHEN m.sender_id = ? THEN m.receiver_id 
                ELSE m.sender_id 
            END AS user_id, 
            u.name AS other_user_name, 
            MAX(m.created_at) AS last_message_time, 
            MAX(m.is_read) AS last_is_read 
        FROM 
            messages m 
        JOIN 
            users u ON (u.user_id = CASE WHEN m.sender_id = ? THEN m.receiver_id ELSE m.sender_id END) 
        JOIN 
            properties p ON m.property_id = p.property_id
        WHERE 
            m.sender_id = ? OR m.receiver_id = ? 
        GROUP BY 
            m.property_id, user_id, other_user_name, property_name
        ORDER BY 
            last_message_time DESC
    ");

        $query->execute([$user_id, $user_id, $user_id, $user_id]);
        return $query->fetchAll();
    }


    public function getUnreadMessagesCount($user_id)
    {
        $query = $this->db->prepare("
        SELECT COUNT(*) 
        FROM 
            messages 
        WHERE 
            receiver_id = ? AND is_read = 0
    ");

        $query->execute([$user_id]);
        return $query->fetchColumn();
    }
}
