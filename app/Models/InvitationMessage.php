<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Invitation;

class InvitationMessage extends Model
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
        'sender_name',
        'sender_messages',
        'attendance_status',
        'number_of_attendance',
        'invitation_id',
        'img_thumbnail_url'
    ];

    /**
     * Get the messages sent by user for the invitation.
     */
    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class,'invitation_id','id');
    }
}
