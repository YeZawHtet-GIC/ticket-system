<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    public function labels()
    {
        return $this->belongsToMany(Label::class, 'ticket_labels');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'ticket_categories');
    }
}
