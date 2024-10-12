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
            SELECT image_url FROM property_images
            WHERE property_id = ?
        ");
        $query->execute([$property_id]);
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }
}
