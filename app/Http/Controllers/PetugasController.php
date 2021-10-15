<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public $response;
    public function __construct()
    {
        $this->response = new ResponseHelper();
    }

    public function getAll($limit = NULL, $offset = NULL)
    {
        $data['user'] = User::where('level', '<>', 'masyarakat')->count();
        
        if($limit == NULL $$ $offset == NULL) {
            $data['user'] = User::where('level', '<>', 'masyarakat')->get();
        }
    }
}
