<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model
{
    protected $table            = 'documents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['case_id', 'uploaded_by', 'file_name', 'file_path', 'description'];

    // Dates
    protected $useTimestamps = false; // We set created_at automatically via migration or manually
    protected $createdField  = 'created_at';
}
