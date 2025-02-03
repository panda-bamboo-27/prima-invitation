<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ThemeCategory;
use App\Models\InvitationCategory;
use App\Models\User;

class Theme extends Model
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
        'theme_name',
        'theme_description',
        'theme_price',
        'is_active',
        'theme_category_id',
        'invitation_category_id',
        'theme_author_id'
    ];
    
    /**
     * Get the theme category associated with the theme.
     */
    public function themeCategory(): BelongsTo
    {
        return $this->belongsTo(ThemeCategory::class,'theme_category_id');
    }

    /**
     * Get the invitation category associated with the theme.
     */
    public function invitationCategory(): BelongsTo
    {
        return $this->belongsTo(InvitationCategory::class,'invitation_category_id');
    }

    /**
     * Get the user who made the theme.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'theme_author_id');
    }

    /**
     * Get the tags associated with the theme'
     * The third argument is the foreign key name of the model on which you are defining the relationship, while the fourth argument is the foreign key name of the model that you are joining to:
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(ThemeTag::class,'tags','theme_id','tag_id')->withTimestamps();
    }
}
