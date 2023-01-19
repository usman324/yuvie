<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
class CompanyController extends Controller
{
    const TITLE = 'Companies';
    const VIEW = 'admin/company';
    const URL = 'admin/companies';

    public function __construct()
    {
        view()->share([
            'url' => url(self::URL),
            'title' => self::TITLE,
            // 'image_url' => env('APP_IMAGE_URL') . 'class',
        ]);
    }
    public function index(Request $request)
    {
        return view(self::VIEW . '.index', get_defined_vars());
    }
   
    public function create()
    {
        return view(self::VIEW . '.create', get_defined_vars());
    }

    
    public function store(Request $request)
    {
        
    }

   
    public function destroy($id)
    {
        
    }
}
