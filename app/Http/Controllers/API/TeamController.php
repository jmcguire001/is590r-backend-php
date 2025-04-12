<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Conference;
use App\Models\Division;
use App\Models\ConferenceDivision;
use AWS\CRT\HTTP\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use function PHPSTORM_META\map;

class TeamController extends BaseController
{
    public function index()
    {
        // $teams = Team::orderBy(column: 'name', direction:'asc')->get(); // select * from teams

        $teams = Team::orderBy(column: 'name', direction:'asc')->with(relations:['conference','division','sponsors'])->get(); // select * from teams

        foreach($teams as $team) {
            $team->logo=$this->getS3Url($team->logo);
        }

        return $this->sendResponse($teams, 'Teams');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'abbr'=>'required',
            'city'=>'required',
            'state'=>'required',
            'country'=>'required',
            'stadium'=>'required'
        ]);

        if($validator->fails()){
            return $this->sendError(error:'Validation Error',errorMessages: $validator->errors());
        }

        $team = new Team();

        if ($request->hasFile('logo')) {
            $extension = request()->file('logo')->getClientOriginalExtension();
            $image_name = time().'_logo.'.$extension;
            $path = $request->file('logo')->storeAs(
                path:'images',
                name:$image_name,
                options:'s3'
            );
            Storage::disk('s3')->setVisibility($path,'public');
            if(!$path) {
                return $this->sendError(error: $path, errorMessages: 'Team logo failed to upload!');
            }

            $team->logo = $path;
        }

        $team->name = $request['name'];
        $team->abbr = $request['abbr'];
        $team->confId = $request['confId'];
        $team->divId = $request['divId'];
        $team->city = $request['city'];
        $team->state = $request['state'];
        $team->country = $request['country'];
        $team->stadium = $request['stadium'];
        $team->mascot = $request['mascot'];

        $team->save();

        if(isset($team->logo)){
            $team->logo = $this->getS3Url(path:$team->logo);
        }
        else{
            $team->logo = null;
        }

        // Replace this section in TeamController.php store method
        $sponsor = json_decode($request['sponsorIds'], true); // Decode as array

        // Only process sponsors if the array is not empty
        if (!empty($sponsor) && is_array($sponsor)) {
            foreach ($sponsor as $sponsorId) {
                DB::table('team_sponsors')->insert([
                    'teamId' => $team->id,
                    'sponsorId' => $sponsorId
                ]);
            }
        }

        // After saving the team in the store method
        $team->load('sponsors'); // Ensure sponsors are loaded
        $success['team'] = $team;

        return $this->sendResponse($success,'Team created successfully!');
    }

    public function updateTeamLogo(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|file|image|max:2048'
        ]);
    
        $team = Team::findOrFail($request->teamId);
    
        if ($request->hasFile('logo')) {
            if ($team->logo) {
             
                Storage::disk('s3')->delete($team->logo);
            }
    
            $path = $request->file('logo')->store('images', 's3');
            $team->logo = $path;
            $team->save();
        }
    
        return response()->json(['message' => 'Logo updated successfully', 'logo' => $team->logo]);
    }    

    public function update(Request $request, $id)
    {
        $validator = Validator::make(data: $request->all(), rules: [
            'name'=>'required',
            'abbr'=>'required',
            'city'=>'required',
            'state'=>'required',
            'country'=>'required',
            'stadium'=>'required'
        ]);

        if($validator->fails()){
            return $this->sendError(error:'Validation Error',errorMessages: $validator->errors());
        }

        $team = Team::findOrFail(id:$id);
        $team->name = $request['name'];
        $team->abbr = $request['abbr'];
        $team->confId = $request['confId'];
        $team->divId = $request['divId'];
        $team->city = $request['city'];
        $team->state = $request['state'];
        $team->country = $request['country'];
        $team->stadium = $request['stadium'];
        $team->mascot = $request['mascot'];
        $team->save();

        if(isset($team->logo)){
            $team->logo = $this->getS3Url(path:$team->logo);
        }

        // Delete existing relationships
        DB::table('team_sponsors')->where('teamId', $team->id)->delete();

        // Replace this section in TeamController.php store method
        $sponsor = json_decode($request['sponsorIds'], true); // Decode as array

        // Only process sponsors if the array is not empty
        if (!empty($sponsor) && is_array($sponsor)) {
            foreach ($sponsor as $sponsorId) {
                DB::table('team_sponsors')->insert([
                    'teamId' => $team->id,
                    'sponsorId' => $sponsorId
                ]);
            }
        }

        // After saving the team in the store method
        $team->load('sponsors'); // Ensure sponsors are loaded

        $success['team'] = $team;
        return $this->sendResponse($success,'Team updated successfully!');
    }

    public function destroy($id)
    {
        $team = Team::findOrFail(id:$id);

        if($team->logo){
            Storage::disk('s3')->delete($team->logo);            
        }

        $team->delete();

        $success['team'] = $id;
        return $this->sendResponse($success, message:'Team deleted successfully!');
    }

    public function getConferences()
    {
        $conferences = Conference::orderBy(column: 'name', direction:'asc')->with('divisions')->get(); // Get all conferences with divisions
        return $this->sendResponse($conferences, 'Conferences retrieved successfully');
    }

    public function getSponsors()
    {
        $sponsors = DB::table('sponsors')->orderBy(column: 'name', direction:'asc')->get(); // Get all sponsors
        return $this->sendResponse($sponsors, 'Sponsors retrieved successfully');
    }
}