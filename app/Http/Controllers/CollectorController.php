<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AiRange;
use Illuminate\Support\Facades\Auth;
use App\Models\Collector;
use App\Models\district;
use App\Models\As_center;
use App\Models\Province;
use App\Models\RiceSeason;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CollectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public  $thisSeasonId;
    public $thisSeason;
    public function __construct()
    {
        $season = new RiceSeasonController;
        $this->thisSeason =  $season->getSeasson(); // change this for add old data -  2024, 'yala'
        $this->thisSeasonId =  $this->thisSeason['seasonId'];
    }

    public function index()
    {
        $userId = Auth::id();

        // Check if a collector exists for the current season
        $latestSeasonCollector = Collector::where('user_id', $userId)
            ->where('rice_season_id', $this->thisSeasonId)
            ->latest()
            ->first();

        if (!$latestSeasonCollector) {
            $season = $this->thisSeason['seasonName'];
            return view('collectors.create', ['season' => $season]);
        }

        // Build query with filters
        $query = Collector::with(['riceSeason', 'getDistrict', 'getAsCenter', 'getAiRange', 'commonDataCollect'])
            ->where('user_id', $userId);

        if (request('season')) {
            $query->whereHas('riceSeason', fn($q) => $q->where('name', request('season')));
        }

        if (request('district')) {
            $query->whereHas('getDistrict', fn($q) => $q->where('name', request('district')));
        }

        if (request('established')) {
            $query->whereDate('date_establish', request('established'));
        }

        if (request('created')) {
            $query->whereDate('created_at', request('created'));
        }

        $collectors = $query->orderByDesc('rice_season_id')->get();

        return view('collectors.index', [
            'collectors' => $collectors,
            'seasons' => RiceSeason::all(),
            'districts' => District::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $id = Auth::user()->id;
        $collector  = Collector::where('user_id', $id)->where('rice_season_id', $this->thisSeasonId)->latest()->first();

        if (empty($collector) || $collector->rice_season_id != $this->thisSeasonId) {
            $season = $this->thisSeason['seasonName'];
            return view('collectors.create', ['season' => $season]);
        } else {
            return redirect(route('collector.index'));
        }
    }

    public function adminCollectorView($id)
    {
        $collectors = Collector::where('user_id', $id)
            ->orderBy('rice_season_id', 'desc')
            ->get();
        return view('collectors.admin-index', ['collectors' => $collectors, 'user' => User::find($id)]);
    }
    public function adminCollectorDestroy($id)
    {
        Collector::destroy($id);
        return redirect()->back();

        // return redirect('collector')->with('flash_message', 'collector deleted!');
    }
    public function newCollector()
    {
        $season = $this->thisSeason['seasonName'];
        return view('collectors.create', ['season' => $season]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if (!RiceSeason::find($this->thisSeason['seasonId'])) {
            RiceSeason::create([
                'id' => $this->thisSeason['seasonId'],
                'name' => $this->thisSeason['seasonName'],
                'start_date' => $this->thisSeason['startDate'],
                'end_date' => $this->thisSeason['endDate'],
            ]);
        }


        $request->validate([
            'phone_no' => 'required',
            'region' => 'required',
            'province' => 'required',
            'district' => 'required',
            'as_center' => 'required',
            'ai_range' => 'required',
            'village' => 'required',
            //  'gps_lati' => 'required',
            //  'gps_long' => 'required',
            'rice_variety' => 'required',
            'date_establish' => 'required',
            'established_method' => 'required',

        ]);

        $dateEstablish = Carbon::createFromFormat('d-m-Y', $request->get('date_establish'))->format('Y-m-d');

        $collector = new Collector([
            'user_id' => Auth::user()->id,
            // 'rice_season_id' => 20242024,
            'rice_season_id' => $this->thisSeasonId,
            'phone_no' => $request->get('phone_no'),
            'region_id' => $request->get('region'),
            'province' => $request->get('province'),
            'district' => $request->get('district'),
            'asc' => $request->get('as_center'),
            'ai_range' => $request->get('ai_range'),
            'village' => $request->get('village'),
            'gps_lati' => $request->get('gps_lati'),
            'gps_long' => $request->get('gps_long'),
            'rice_variety' => $request->get('rice_variety'),
            'date_establish' => $dateEstablish,
            'established_method' => $request->get('established_method'),
        ]);

        $collector->save();
        if (has_role('collector')) {
            session()->flash('success', 'Collector Created successfully!');
            return redirect(route('collector.index'));
        } elseif (has_role('admin')) {
            $collectors = Collector::all();
            return redirect(route('admin.collector.records'))->with('success', 'Collector updated successfully.');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $collector = Collector::find($id);
        return view('collectors.show')->with('collectors', $collector);
    }
    public function view()
    {
        $collector = Collector::join('users', 'collectors.user_id', '=', 'users.id')
            ->join('districts', 'collectors.district', '=', 'districts.id')
            ->join('as_centers', 'collectors.asc', '=', 'as_centers.id')
            ->select('collectors.user_id', 'collectors.phone_no', 'collectors.ai_range', 'collectors.village', 'collectors.gps_lati', 'collectors.gps_long', 'collectors.rice_variety', 'collectors.date_establish', 'users.name', 'users.email', 'districts.name as dname', 'as_centers.name as asname')->get();
        return view('collectors.show-collectors')->with('collectors', $collector);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $collector = Collector::find($id);
        $seasonId = $collector->rice_season_id;
        $season = RiceSeason::find($seasonId)->name;
        $provinces = Province::all();
        $districts = district::all();
        $as_centers = As_center::all();
        $ai_ranges = AiRange::all();
        $collector->date_establish = Carbon::createFromFormat('Y-m-d', $collector->date_establish)->format('d-m-Y');
        if (has_role('admin')) {
            return view('livewire.collector.edit', compact('collector',  'provinces', 'districts', 'as_centers', 'ai_ranges', 'season'));
        } else {
            return view('collectors.edit', compact('collector',  'provinces', 'districts', 'as_centers', 'ai_ranges', 'season'));
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $collectorId)
    {

        $collector = Collector::findorfail($collectorId);
        $request->validate([
            'phone_no' => 'required',
            'region' => 'required',
            'province' => 'required',
            'district' => 'required',
            'as_center' => 'required',
            'ai_range' => 'required',
            'village' => 'required',
            // 'gps_lati' => 'required',
            // 'gps_long' => 'required',
            'rice_variety' => 'required',
            'date_establish' => 'required',
            'established_method' => 'required',
        ]);

        $dateEstablish = Carbon::createFromFormat('d-m-Y', $request->get('date_establish'))->format('Y-m-d');
        $collector->phone_no = $request->phone_no;
        if (Auth::user()->name == 'npssoldata') {
            $collector->rice_season_id = $request->season;
        }
        $collector->region_id = $request->region;
        $collector->province = $request->province;
        $collector->district = $request->district;
        $collector->asc = $request->as_center;
        $collector->ai_range = $request->ai_range;
        $collector->village = $request->village;
        $collector->gps_lati = $request->gps_lati;
        $collector->gps_long = $request->gps_long;
        $collector->rice_variety = $request->rice_variety;
        $collector->date_establish = $dateEstablish;
        $collector->established_method = $request->established_method;
        $collector->save();
        if (has_role('collector')) {
            session()->flash('success', 'Collector Updated successfully!');
            return redirect(route('collector.index'));
        } elseif (has_role('admin')) {
            $collectors = Collector::all();
            return redirect()->route('admin.collector.records');
        }
    }

    // In your controller


    public function getDistricts($provinceId)
    {
        $districts = District::where('province_id', $provinceId)->get();
        return response()->json($districts);
    }

    public function getAsCenters($districtId)
    {
        $ascs = As_center::where('district_id', $districtId)->get();
        return response()->json($ascs);
    }

    public function getAiRanges($ascId)
    {
        $airRanges = AiRange::where('as_center_id', $ascId)->get();
        return response()->json($airRanges);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Collector::destroy($id);
        return redirect(route('admin.collector.records'));


        // return redirect('collector')->with('flash_message', 'collector deleted!');
    }
    public function collectordestroy($id)
    {
        Collector::destroy($id);
        return redirect()->back();
        // return redirect('collector')->with('flash_message', 'collector deleted!');
    }

    public function getCollectorCount($seasonId = null, $provinceId = null, $districtId = null, $asCenterId = null, $aiRangeId = null)
    {
        if ($seasonId = null) {
            $collectorCount = Collector::all()->count();
            return $collectorCount;
        } elseif ($provinceId != null) {
            $collectorCount = Collector::where('rice_season_id', $seasonId)->where('province', $provinceId)->count();
        } elseif ($districtId != null) {
            $collectorCount = Collector::where('rice_season_id', $seasonId)->where('district', $districtId)->count();
        } elseif ($asCenterId != null) {
            $collectorCount = Collector::where('rice_season_id', $seasonId)->where('asc', $asCenterId)->count();
        } elseif ($aiRangeId != null) {
            $collectorCount = Collector::where('rice_season_id', $seasonId)->where('ai_range', $aiRangeId)->count();
        } else {
            dd('No Collector data found');
        }
    }
}
