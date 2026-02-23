<?php

namespace App\Models;

use CodeIgniter\Model;

class AlatModel extends Model
{
    protected $table            = 'alat';
    protected $primaryKey       = 'id_alat';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_alat',
        'id_category',
        'harga_alat',
        'kondisi',
        'stok',
        'status'
    ];

    public function getAlatWithCategory()
    {
        return $this->select('alat.*, category.nama_category')
            ->join('category', 'category.id_category = alat.id_category', 'left')
            ->findAll();
    }

    public function getAlatFiltered($keyword = null, $category = null)
    {
        $builder = $this->select('alat.*, category.nama_category');

        if ($keyword) {
            $builder->groupStart()
                ->like('nama_alat', $keyword)
                ->orLike('status', $keyword)
                ->orLike('kondisi', $keyword)
                ->groupEnd();
        }

        if ($category) {
            $builder->where('alat.id_category', $category);
        }

        return $builder;
    }

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
