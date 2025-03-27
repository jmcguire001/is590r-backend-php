<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeamController extends BaseController
{
    public function index()
    {
        $teams = Team::all();

        foreach($teams as $team) {
            $team->teamLogo=$this->getS3Url($team->teamLogo);
        }

        return $this->sendResponse($teams, 'Teams');
    }
}