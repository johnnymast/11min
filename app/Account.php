<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Account extends Model
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unique_id',
        'email',
        'expired',
        'expires_at'
    ];


    public function getExpiredAccounts()
    {
        return $this->where('expired', true)->get();
    }


    public function getInactiveAccounts()
    {
        return $this->whereBetween('last_check', [
                Carbon::now()->subHours(1),
                Carbon::now()
            ])->where('expired', false)->where('expires_at', '<', Carbon::now())->get();
    }


    /**
     * Create the mail account.
     *
     * @return int|static
     */
    public static function generate()
    {

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
    public static function generateUniqueId()
    {
        $number = mt_rand(1000, 999999); // better than rand()

        // call the same function if the barcode exists already
        if (self::whereUniqueId($number)->exists()) {
            return generateBarcodeNumber();
        }

        // otherwise, it's valid and can be used
        return $number;
    }
}
