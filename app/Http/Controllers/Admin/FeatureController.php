<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\FeatureRequest;
use App\Http\Shared\ImageService;
use App\Models\Feature;

class FeatureController extends Controller
{
    public function getNetwork()
    {
        $network = Feature::find(1);
        return view('panel.network', compact('network'));
    }

    public function getNfc()
    {
        $nfc = Feature::whereIn('id',[5,6,7])->get();
        return view('panel.nfc', compact('nfc'));
    }

    public function getFeatures()
    {
        $features = Feature::whereIn('id',[2,3,4])->get();
        return view('panel.features', compact('features'));
    }

    public function update(FeatureRequest $request, $id)
    {
        $feature = Feature::findOrFail($id);
        $data = $request->validated();
        if ($request->hasFile('image')) {
            ImageService::delete($feature->image);
            $data['image'] = ImageService::save($request, 'features');
        }
        Feature::find($id)->update($data);

        return back()->with('message', 'Done Successfully');
    }

}
