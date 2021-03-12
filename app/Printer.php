<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public static function capability_profiles()
    {
        $profiles = [
            'default' => 'Default',
            'simple' => 'Simple',
            'SP2000' => 'Star Branded',
            'TEP-200M' => 'Espon Tep',
            'P822D' => 'P822D'
        ];

        return $profiles;
    }

    public static function capability_profile_srt($profile)
    {
        $profiles = Printer::capability_profiles();

        return isset($profiles[$profile]) ? $profiles[$profile] : '';
    }

    public static function connection_types()
    {
        $types = [
            'network' => 'Network',
            'windows' => 'Windows',
            'linux' => 'Linux'
        ];

        return $types;
    }

    public static function connection_type_str($type)
    {
        $types = Printer::connection_types();

        return isset($types[$type]) ? $types[$type] : '';
    }

    /**
     * Return list of printers for a business
     *
     * @param int $business_id
     * @param boolean $show_select = true
     *
     * @return array
     */
    public static function forDropdown($business_id, $show_select = true)
    {
        $query = Printer::where('business_id', $business_id);

        $printers = $query->pluck('name', 'id');
        if ($show_select) {
            $printers->prepend(__('messages.please_select'), '');
        }
        return $printers;
    }
}
