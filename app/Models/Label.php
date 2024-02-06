<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    public function tickets()
    {
        return $this->belongsToMany(Ticket::class, 'ticket_labels','label_id', 'ticket_id');
    }
}
