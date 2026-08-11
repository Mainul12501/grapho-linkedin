<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderPayment extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'invoice_number',
        'payment_method',
        'total_amount',
        'paid_amount',
        'bank_trans_id',
        'gateway_val_id',
        'gateway_status',
        'payment_status',
        'status',
        'notes',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'order_payments';

    public static function placeOrderPayment($user, $subscriptionPlan, $sslData = null, $requestData = null)
    {
        $orderPayment = new self();
        $orderPayment->user_id = $user->id;
        $orderPayment->subscription_plan_id = $subscriptionPlan->id;
        $orderPayment->invoice_number = $sslData->tran_id ?? self::generateOrderNumber();
        $orderPayment->payment_method = 'ssl';
        $orderPayment->total_amount = $requestData->total_amount ?? 0;
        $orderPayment->paid_amount = $sslData->amount ?? 0;
        $orderPayment->bank_trans_id = $requestData->bank_trans_id ?? '';
        $orderPayment->gateway_val_id = $requestData->gateway_val_id ?? '';
        $orderPayment->gateway_status = $requestData->gateway_status ?? '';
        $orderPayment->payment_status = 'completed';
        $orderPayment->status = 'approved';
        $orderPayment->notes = $requestData->notes ?? '';
        $orderPayment->save();
        return $orderPayment;
    }

    public static function generateOrderNumber ()
    {
        $number = rand(1000000, 9999999);
        $existNumber = OrderPayment::where('invoice_number', $number)->first();
        if (!empty($existNumber) && count($existNumber) > 0)
        {
            self::generateOrderNumber();
        }
        return $number;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}
