<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Invitation;

class InvitationContent extends Model
{
    use HasFactory;
    /**
     * Get the invitation header for the content.
     */
    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class,'invitation_id','id');
    }
}
