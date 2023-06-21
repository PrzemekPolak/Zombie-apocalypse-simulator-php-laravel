<?php

namespace App\Http\Controllers;

use App\Models\Human;
use Illuminate\Http\Request;

class HumanController extends Controller
{
    public function getHumansCountByProfession(Request $request)
    {
        return Human::all(); // TODO: finish it
    }
}
