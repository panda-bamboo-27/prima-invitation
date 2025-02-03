<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Theme;

class ThemeTemplate extends Model
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
        'template_header',
        'template_content',
        'version',
        'theme_id',
    ];
    
    /**
     * Get the theme associated with the tags
     */
    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class,'theme_id','id');
    }
}
