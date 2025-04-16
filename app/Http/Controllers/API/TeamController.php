<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Conference;
use App\Models\Division;
use App\Models\ConferenceDivision;
use App\Models\Stadium;
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
        $teams = Team::orderBy('name', 'asc')
            ->with(['conference', 'division', 'sponsors'])
            ->get();
    
        foreach($teams as $team) {
            $stadium = DB::selectOne('SELECT * FROM stadiums WHERE id = ?', [$team->stadium]);
            $team->stadium = $stadium;
            $team->logo = $this->getS3Url($team->logo);
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
        $team->mascot = $request['mascot'];

        // Try to find the stadium by name
        $existingStadium = DB::select('SELECT * FROM stadiums WHERE name = ?', [$request['stadium']]);

        if (empty($existingStadium)) {
            // Insert new stadium
            DB::insert('INSERT INTO stadiums (name, created_at) VALUES (?, NOW())', [$request['stadium']]);
            $stadiumId = DB::getPdo()->lastInsertId(); // Get the new ID
        } else {
            $stadiumId = $existingStadium[0]->id;

            // Check if stadium is already assigned to another team
            $taken = DB::select('SELECT * FROM teams WHERE stadium = ?', [$stadiumId]);
            if (!empty($taken)) {
                return $this->sendError('Stadium already assigned to a team.');
            }
        }

        $team->stadium = $stadiumId;

        $team->save();

        if(isset($team->logo)){
            $team->logo = $this->getS3Url(path:$team->logo);
        }
        else{
            $team->logo = null;
        }

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
        $team->mascot = $request['mascot'];

        // Try to find the stadium by name
        $existingStadium = DB::select('SELECT * FROM stadiums WHERE name = ?', [$request['stadium']]);

        if (empty($existingStadium)) {
            // Insert new stadium
            DB::insert('INSERT INTO stadiums (name, created_at) VALUES (?, NOW())', [$request['stadium']]);
            $stadiumId = DB::getPdo()->lastInsertId(); // Get the new ID
        } else {
            $stadiumId = $existingStadium[0]->id;

            // Check if stadium is already assigned to another team
            $taken = DB::select('SELECT * FROM teams WHERE stadium = ?', [$stadiumId]);
            if (!empty($taken)) {
                return $this->sendError('Stadium already assigned to a team.');
            }
        }

        $team->stadium = $stadiumId;

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

    public function getStadiums()
    {
        $stadiums = DB::table('stadiums')->orderBy(column: 'name', direction:'asc')->get(); // Get all stadiums
        return $this->sendResponse($stadiums, 'Stadiums retrieved successfully');
    }

    public function checkStadium(Request $request)
    {
        $stadiumName = $request->query('name');
    
        // Check if the stadium exists
        $stadium = DB::select('SELECT * FROM stadiums WHERE name = ?', [$stadiumName]);
        
        if (empty($stadium)) {
            return response()->json(['status' => 'new']); 
        }
        
        // Check if the stadium is already associated with a team
        $team = DB::select('SELECT * FROM teams WHERE stadium = ?', [$stadium[0]->id]);
        
        if ($team) {
            return response()->json(['status' => 'taken']); 
        }
        
        // Stadium is available
        return response()->json(['status' => 'available', 'stadium' => $stadium[0]->name]);
    }
}