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
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function createdBy()
{
    return $this->belongsTo(User::class, 'created_user_id');
}
}
