<?php

namespace App\Models;

/**
 * Class Bank_detail
 * @package App\Models
 */
class Bank_detail extends BaseModel
{
    protected $fillable = ['employee_id', 'account_name', 'account_number', 'bank', 'pan', 'ifsc', 'branch','transaction_type_code','payment_type'];
    protected $guarded = [''];

    /**
     * @return mixed
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
