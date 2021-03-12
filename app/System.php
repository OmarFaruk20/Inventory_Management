<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = ['id'];

    /**
     * Return the value of the property
     *
     * @param $key string
     * @return mixed
     */
    public static function getProperty($key)
    {
        $row = System::where('key', $key)
                ->first();

        if (isset($row->value)) {
            return $row->value;
        } else {
            return null;
        }
    }

    /**
     * Return the value of the multiple properties
     *
     * @param $keys array
     * @return array
     */
    public static function getProperties($keys, $pluck = false)
    {
        if ($pluck == true) {
            return System::whereIn('key', $keys)
                ->pluck('value', 'key');
        } else {
            return System::whereIn('key', $keys)
                ->get()
                ->toArray();
        }
    }

    /**
     * Return the system default currency details
     *
     * @param void
     * @return object
     */
    public static function getCurrency()
    {
        $c_id = System::where('key', 'app_currency_id')
                ->first()
                ->value;

        $currency = Currency::find($c_id);
        
        return $currency;
    }

    /**
     * Set the property
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    public static function setProperty($key, $value)
    {
        System::where('key', $key)
            ->update(['value' => $value]);
    }
}
