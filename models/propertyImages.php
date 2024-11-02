<?php

require_once 'base.php';

class PropertyImages extends Base
{
    public function create($data)
    {
        $query = $this->db->prepare("
            INSERT INTO property_images 
                (property_id, 
                image_url, 
                created_at)
            VALUES 
                (?, ?, NOW())
        ");
        return $query->execute([
            $data['property_id'],
            $data['image_url']
        ]);
    }


    public function getByPropertyId($property_id)
    {
        $query = $this->db->prepare("
            SELECT 
                images_id,
                property_id,
                image_url
            FROM 
                property_images
            WHERE 
                property_id = ?
        ");
        $query->execute([$property_id]);
        return $query->fetchAll();
    }

    public function delete($image_id)
    {
        $query = $this->db->prepare("
        DELETE FROM 
            property_images 
        WHERE 
            images_id = ?
    ");
        return $query->execute([$image_id]);
    }
}
