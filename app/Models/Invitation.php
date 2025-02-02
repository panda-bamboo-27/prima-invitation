<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\InvitationContent;
use App\Models\InvitationCategory;
use App\Models\Theme;

class Invitation extends Model
{
    use HasFactory;
    /**
     * Get the contents for the invitation.
     */
    public function contents(): HasMany
    {
        return $this->hasMany(InvitationContent::class,'invitation_id','id');
    }

    /**
     * Get the invitation category for the invitation.
     */
    public function invitationCategory(): BelongsTo
    {
        return $this->belongsTo(InvitationCategory::class,'invitation_category_id','id');
    }

    /**
     * Get the theme for the invitation.
     */
    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class,'theme_id','id');
    }
}
