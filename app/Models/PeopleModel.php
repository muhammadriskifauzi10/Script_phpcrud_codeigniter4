<?php

namespace App\Models;

use CodeIgniter\Model;

class PeopleModel extends Model
{
  protected $table      = 'peoples';
  protected $primaryKey = 'id';
  protected $dateFormat    = 'datetime';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'name',
    'slug',
    'jenis_kelamin',
    'gambar',
  ];

  public function getPeople($slug = false) {
    if($slug == false) {
      return $this->findAll();
    }

    return $this->where('slug', $slug)->first();
  }
}
