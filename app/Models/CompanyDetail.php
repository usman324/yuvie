<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    use HasFactory;
    protected $fillable=[
        'company_id',
        'company_location_state',
        'company_location_title',
        'company_location_event',
        'company_group',
        'latitude',
        'longitude',
        'company_website_url',
        'company_destination_url',
        'company_button_text',
        'company_ftp_protocol',
        'company_ftp_host',
        'company_ftp_username',
        'company_ftp_password',
        'company_ftp_directory',
    ];
}
