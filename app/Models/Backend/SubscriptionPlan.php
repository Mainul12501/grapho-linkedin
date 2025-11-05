<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPlan extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'price',
        'duration_in_days',
        'plan_features',
        'note',
        'status',
        'slug',
        'subscription_for',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'subscription_plans';

    public static function createOrUpdateSubscription($request, $subscription = null)
    {
        if ($subscription == null)
        {
            $subscription = new SubscriptionPlan();
        }
        $subscription->title = $request->title;
        $subscription->price = $request->price;
        $subscription->duration_in_days = $request->duration_in_days;
        $subscription->subscription_for = $request->subscription_for;
        $subscription->plan_features = $request->plan_features;
        $subscription->note = $request->note;
        $subscription->status = $request->status == 'on' ? 1 : 0;
        $subscription->slug = str_replace(' ', '-', $request->title);
        $subscription->save();
        return $subscription;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function scopeActive($query)
    {
        return $query->whereRaw('DATE_ADD(created_at, INTERVAL duration_in_days DAY) > NOW()');
    }
}
