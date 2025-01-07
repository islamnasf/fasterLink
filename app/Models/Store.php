<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'username',
        'category_id',
        'city_id',
        'user_id',
        'package_id',
        'full_description_en',
        'full_description_ar',
        'logo',
        'cover_type',
        'cover_images',
        'cover_video_url',
        'expiry_date',
        'active',
        'multi_branches',
        'start_date',
        'default_page',
        'products_show_method',
        'identity_color',
        'ratings_active',
        'views_active',

        'effect_button',
        'introduction_screen',
        'ad_bar',
        'background_image',
    ];

    protected $casts = [
        'effect_button' => 'array',
        'introduction_screen' => 'array',
        'ad_bar' => 'array',
        'background_image' => 'array',
    ];

    public function getIntroductionScreenAttribute($value)
    {
        $data = json_decode($value, true);
        if (isset($data['active'])) {
            $data['active'] = (int) $data['active'];
        }
        return $data;
    }

    public function setIntroductionScreenAttribute($value)
    {
        if (isset($value['active'])) {
            $value['active'] = (int) $value['active'];
        }
        $this->attributes['introduction_screen'] = json_encode($value);
    }

    public function getBackgroundImageAttribute($value)
    {
        $data = json_decode($value, true);
        if (isset($data['active'])) {
            $data['active'] = (int) $data['active'];
        }
        return $data;
    }

    public function setBackgroundImageAttribute($value)
    {
        if (isset($value['active'])) {
            $value['active'] = (int) $value['active'];
        }
        $this->attributes['background_image'] = json_encode($value);
    }

    protected function coverImages(): Attribute
    {
        return Attribute::make(
            get: fn(string $value = null) => json_decode($value),
            set: fn(array $value = null) => json_encode($value),
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
    public function ratings()
{
    return $this->hasMany(Rating::class, 'store_id');
}
public function departments()
{
    return $this->hasMany(Department::class, 'store_id');
}

}
