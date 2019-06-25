<?php
namespace App\Larapen\Models;

use App\Larapen\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class BusinessImage extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'businessImages';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    // protected $primaryKey = 'id';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    // public $timestamps = false;
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['biz_id', 'filename', 'google_ref', 'posted_by', 'active'];
    
    /**
     * The attributes that should be hidden for arrays
     *
     * @var array
     */
    // protected $hidden = [];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope(new ActiveScope());
        
        // before delete() method call this
        static::deleting(function ($picture) {
            // Delete all pictures files
            if (!empty($picture->filename)) {
                $picture_path = public_path() . '/uploads/pictures/';
                if (File::exists($picture_path . $picture->filename)) {
                    File::delete($picture_path . $picture->filename);
                } else {
                    $picture_path = public_path() . '/';
                    if (File::exists($picture_path . $picture->filename)) {
                        File::delete($picture_path . $picture->filename);
                    }
                }
            }
        });
    }
    
    public function getAdTitleHtml()
    {
        if ($this->business) {
            return '<a href="/' . config('app.locale') . '/' . slugify($this->business->title) . '/' . $this->business->id . '.html" target="_blank">' . $this->business->title . '</a>';
        } else {
            return 'no-link';
        }
    }
    
    public function getFilenameHtml()
    {
        return '<img src="' . url('pic/x/cache/small/' . $this->filename) . '">';
    }
    
    public function getActiveHtml()
    {
        if ($this->active == 1) {
            return '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
        } else {
            return '<i class="fa fa-square-o" aria-hidden="true"></i>';
        }
    }
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function business()
    {
        return $this->belongsTo('App\Larapen\Models\Business', 'biz_id');
    }
    
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
