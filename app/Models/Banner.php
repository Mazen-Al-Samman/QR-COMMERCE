<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    const ROLE_PREFIX = 'banner';
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'is_published',
        'title',
        'body',
        'image',
        'vendor_id',
    ];

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }

    public function getAllBanners()
    {
        return self::paginate(10);
    }

    /**
     * @param $request
     * @return bool
     */
    public function createBanner($request)
    {
        if (empty(auth()->user()->id)) {
            abort(404);
        }
        $banner = new self();
        $banner->title = $request->title;
        $banner->body = $request->body;
        $banner->vendor_id = $request->vendor_id;

        $banner->is_published = isset($request['is_published']);

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path() . "/assets/images/uploads/banners/", $name);
            $banner->image = $name;
        }
        return $banner->save();
    }

    /**
     * @param $id
     * @param $request
     */
    public function updateBanner($id, $request)
    {
        if (empty(auth()->user()->id)) {
            abort(404);
        }

        $banner = self::find($id);
        $banner->title = $request->title;
        $banner->body = $request->body;
        if (isset($request->vendor_id)) {
            $banner->vendor_id = $request->vendor_id;
        }
        $banner->is_published = isset($request->is_published);
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path() . "/assets/images/uploads/banners/", $name);
            $banner->image = $name;
        }
        return $banner->save();
    }

    public static function BannersSliderApi()
    {
        return self::select([
            'banners.*',
            'vendors.id',
            'vendors.name as vendor_name',
            'vendors.country as vendor_country',
            'vendors.city as vendor_city',
        ])->join('vendors', 'banners.vendor_id', '=', 'vendors.id')
            ->where([
                'banners.is_published' => 1,
                'vendors.status' => Vendor::STATUS_ACTIVE
            ])
            ->orderBy('banners.created_at', 'DESC')
            ->limit(10)
            ->get()->toArray();
    }
}
