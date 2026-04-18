<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'payment_card_id',
        'billing_address_id',
        'visit_day',
        'total_amount',
        'payment_date',
        'status'
    ];

    protected $casts = [
        'visit_day' => 'date',
        'payment_date' => 'date',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function paymentCard()
    {
        return $this->belongsTo(PaymentCard::class);
    }

    public function billingAddress()
    {
        return $this->belongsTo(BillingAddress::class);
    }
}
