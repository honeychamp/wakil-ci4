<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table      = 'blogs';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'title', 'slug', 'category', 'excerpt',
        'content', 'image', 'author', 'status'
    ];

    /**
     * Get only published blogs ordered by latest
     */
    public function getPublished()
    {
        return $this->where('status', 'published')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Find a single published blog by slug
     */
    public function getBySlug(string $slug)
    {
        return $this->where('slug', $slug)
                    ->where('status', 'published')
                    ->first();
    }

    /**
     * Generate a URL-friendly slug from a title
     */
    public static function makeSlug(string $title): string
    {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return $slug;
    }
}
