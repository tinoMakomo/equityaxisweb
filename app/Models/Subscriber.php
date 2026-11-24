<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    public $fillable = [
        "email",
        "full_name",
        "mobile_number",
        "company",
        'news_updates',
        'e_newspaper',
        'email_services',
    ];


    public function getServices()
    {
        $services = [];
        if($this->news_updates == 1){
            $services[] = "News Updates";
        }
        if($this->e_newspaper == 1){
            $services[] = "E-Newspaper";
        }
        if($this->email_services == 1){
            $services[] = "Email Services";
        }
        return $services;
    }
}
