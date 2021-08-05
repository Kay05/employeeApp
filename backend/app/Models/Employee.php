<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'dob',
        'contact_number',
        'address',
        'city',
        'postal_code',
        'country'
    ];

    protected $_numbers = '0123456789';
    protected $_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';


    public function skills()
    {
        return $this->belongsToMany('App\Models\Skill')->withPivot('experience', 'rating')->withTimestamps();;
    }

    /**
     * Create Employee Id
     *
     * @return string
     */
    public function generateEmployeeId()
    {
        return $this->generate() . $this->generate(true);
    }


    /**
     * Generate Random number and letters function
     *
     * @param boolean $number
     * @return string
     */
    private function generate($number = false)
    {
        $length = 0;
        $charactersLength = 0;

        if ($number) {
            $length = 4;
            $charactersLength = strlen($this->_numbers);
            $randomNumber = '';
            for ($i = 0; $i < $length; $i++) {
                $randomNumber .= $this->_numbers[rand(0, $charactersLength - 1)];
            }

            return $randomNumber;
        } else {
            $length = 2;
            $charactersLength = strlen($this->_numbers);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $this->_letters[rand(0, $charactersLength - 1)];
            }

            return $randomString;
        }
    }


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->employeeID = $model->generateEmployeeId();
        });
    }
}
