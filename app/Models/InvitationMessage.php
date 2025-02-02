<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Invitation;

class InvitationMessage extends Model
{
    use HasFactory;
    /**
     * Get the messages sent by user for the invitation.
     */
    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class,'invitation_id','id');
    }
}
