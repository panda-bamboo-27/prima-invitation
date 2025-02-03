<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Invitation;

class InvitationContent extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'header',
        'content',
        'invitation_id',
    ];
    
    /**
     * Get the invitation header for the content.
     */
    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class,'invitation_id','id');
    }
}
