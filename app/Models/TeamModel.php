<?php

namespace App\Models;

use CodeIgniter\Model;

class TeamModel extends Model
{
    protected $table      = 'team_members';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'name', 'position', 'specialization', 'bio', 'photo',
        'email', 'password', 'linkedin', 'sort_order'
    ];

    /**
     * Find the first available lawyer specializing in a given law area.
     * Used for auto-assigning cases submitted from the public website.
     */
    public function findBySpecialization($specialization)
    {
        return $this->where('specialization', $specialization)
                    ->where('password IS NOT NULL')
                    ->first();
    }

    /**
     * Get all team members ordered by sort_order
     */
    public function getOrdered()
    {
        return $this->orderBy('sort_order', 'ASC')
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }
}
