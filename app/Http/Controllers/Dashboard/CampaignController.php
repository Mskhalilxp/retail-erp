<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!isSuperAdmin(), 403);
        if ($request->ajax())
        {
            if($request['columns'][3]['search']['value'] && $request['columns'][4]['search']['value'])
            {
                $modifiedRequest = $request->all();
                $dateRanges = $request['columns'][3]['search']['value'] . ' - ' . $request['columns'][4]['search']['value'];

                $modifiedRequest['columns'][3]['search']['value'] = $modifiedRequest['columns'][4]['search']['value'] =  $dateRanges;
            }
            else
                $modifiedRequest['columns'][3]['search']['value'] = $modifiedRequest['columns'][4]['search']['value'] = null;

            $data = getModelData( model: new Campaign(), modifiedRequest: $modifiedRequest );

            return response()->json($data);
        }

        return view('dashboard.campaigns.index');
    }

    public function create()
    {
        abort_if(!isSuperAdmin(), 403);
        return view('dashboard.campaigns.create');
    }

    public function edit(Campaign $campaign)
    {
        abort_if(!isSuperAdmin(), 403);
        return view('dashboard.campaigns.edit',compact('campaign'));
    }

    public function store(StoreCampaignRequest $request)
    {
        abort_if(!isSuperAdmin(), 403);
        $data = $request->validated();
        Campaign::create($data);
    }

    public function update(UpdateCampaignRequest $request , Campaign $campaign)
    {
        abort_if(!isSuperAdmin(), 403);
        $data = $request->validated();
        $campaign->update($data);
    }


    public function destroy(Request $request, Campaign $campaign)
    {
        abort_if(!isSuperAdmin(), 403);
        if($request->ajax())
            $campaign->delete();
    }
}
