<?php

namespace App\Models;

use Eloquent as Model;
use App\Helpers\ImageUploaderTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App\Models
 * @version May 18, 2020, 11:27 am UTC
 *
 * @property string $name
 * @property string $description
 * @property string $photo
 */
class Product extends Model
{
    /**
     * Trait Used.
     */
    use SoftDeletes, ImageUploaderTrait;

    /**
     * Table Name.
     *
     * @var array
     */
    public $table = 'products';

    /**
     * Dates attributes.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * Fillable attributes.
     *
     * @var array
     */
    public $fillable = [
        'category_id',
        'name',
        'description',
        'start_price',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'photo' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|min:3',
        'description' => 'required|string|min:3',
        'start_bid_price' => 'required',
        'min_bid_price' => 'required',
        'category_id' => 'required',
    ];


    #################################################################################
    ################################### Appends #####################################
    #################################################################################

    protected $appends = ['rate', 'first_photo'];


    /**
     * append rateing for product.
     */
    public function getRateAttribute()
    {
        if ($this->reviewsProduct()) {

            return $this->attributes['rate'] = $this->reviewsProduct()->avg('rate');
        }

        return $this->attributes['rate'] = 0;
    }

    /**
     * append firs photo for product.
     */
    public function getFirstPhotoAttribute()
    {
        $gallery = $this->gallery;
        foreach ($gallery as $item) {
            return $this->attributes['first_photo'] = $item->photo;
        }
    }

    #################################################################################
    ################################### Relations ###################################
    #################################################################################

    /**
     * Get Categories for product.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }


    /**
     * Get Reviews for product.
     */
    public function reviews()
    {
        return $this->belongsToMany('App\Models\User', 'product_reviews', 'product_id', 'user_id')->withPivot(['rate', 'comment']);
    }

    /**
     * Get Colors for product.
     */
    public function reviewsProduct()
    {
        return $this->hasMany('App\Models\ProductReview', 'product_id', 'id');
    }
    /**
     * Get Colors for product.
     */
    public function gallery()
    {
        return $this->hasMany('App\Models\ProductGallery', 'product_id', 'id');
    }

    #################################################################################
    ################################### Functions ###################################
    #################################################################################

    /**
     * Deprecated.
     */
    public function avgReview()
    {
        return 3;
    }

    /**
     * Deprecated.
     */
    public function quantityPrice()
    {
        return $this->pivot->quantity * $this->price();
    }

    #################################################################################
    ################################### Scopes ######################################
    #################################################################################

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }


    #################################################################################
    ############################## Accessors & Mutators #############################
    #################################################################################

    /**
     * append firs photo for product.
     */
    public function getStatusAttribute()
    {

        switch ($this->attributes['status']) {
            case 0:
                return 'Not Approved';
                break;
            case 1:
                return 'Active';
                break;
            case 2:
                return 'Pending';
                break;
            case 3:
                return 'Finished';
                break;

            default:
                return 'Not Approved';
                break;
        }
    }
}
