<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unique_id', 'email', 'expired', 'expires_at'
    ];


    /**
     * Create the mail account.
     *
     * @return int|static
     */
    public static function generate() {

        $account = self::generateUniqueId();
        $email = $account.'@'.config('custom.mail_domain');
        $expires_at = \Carbon\Carbon::createFromTimestamp(strtotime("+10 MIN"));

        $account = Account::create([
            'unique_id'  => $account,
            'email'      => $email,
            'expired'    => false,
            'expires_at' => $expires_at
        ]);
        return $account;
    }


    /**
     * @return int
     */
    public static function generateUniqueId() {
        $number = mt_rand(1000, 999999); // better than rand()

        // call the same function if the barcode exists already
        if (self::whereUniqueId($number)->exists()) {
            return generateBarcodeNumber();
        }

        // otherwise, it's valid and can be used
        return $number;
    }
}
