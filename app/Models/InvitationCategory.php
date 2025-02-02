<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\InvitationCategory;

class InvitationCategory extends Model
{
    use HasFactory;
    
    /**
     * Get the invitations for the category.
     */
    public function contents(): HasMany
    {
        return $this->hasMany(InvitationContent::class,'invitation_id','id');
    }
}
