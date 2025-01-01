<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LinkRequest;
use App\Http\Resources\LinkCollection;
use App\Http\Resources\LinkLibraryCollection;
use App\Http\Resources\LinkTypeCollection;
use App\Http\Shared\ImageService;
use App\Models\Link;
use App\Models\LinkLibrary;
use App\Models\LinkType;
use App\Models\Store;

class LinkController extends Controller
{
    public function getTypes()
    {
        return successResponse(data: LinkTypeCollection::collection(LinkType::all()));
    }

    public function getLibrary()
    {
        return successResponse(data: LinkLibraryCollection::collection(LinkLibrary::all()));
    }

    public function index()
    {
        $user = auth('user')->user();
        if (!$store = Store::firstWhere('user_id', $user->id)) {
            return failResponse(__('messages.store_not_found'));
        }
        $links = Link::where('store_id', $store->id)->get();
        return successResponse(data: LinkCollection::collection($links));
    }

    public function store(LinkRequest $request)
    {
        $user = auth('user')->user();
        $data = $request->validated();
        if (!$store = Store::firstWhere('user_id', $user->id)) {
            return failResponse(__('messages.store_not_found'));
        }
        if ($request->link_library_id) {
            $link_library = LinkLibrary::find($request->link_library_id);
            $data['name_en'] = $link_library->name_en;
            $data['name_ar'] = $link_library->name_ar;
            $data['image'] = $link_library->image;
        }else {
            $data['image'] = ImageService::save($request, 'links', 'image');
        }
        $data['store_id'] = $store->id;
        Link::create($data);
        return successResponse();
    }

    public function update(LinkRequest $request, $id)
    {
        $user = auth('user')->user();
        if (!$store = Store::firstWhere('user_id', $user->id)) {
            return failResponse(__('messages.store_not_found'));
        }
        $link = Link::where('id', $id)->where('store_id', $store->id)->first();
        if (!$link) {
            return failResponse(__('messages.link_not_found'));
        }
        $data = $request->validated();
        $link->update($data);
        return successResponse();
    }

    public function delete($id)
    {
        $user = auth('user')->user();
        if (!$store = Store::firstWhere('user_id', $user->id)) {
            return failResponse(__('messages.store_not_found'));
        }
        $link = Link::where('id', $id)->where('store_id', $store->id)->first();
        if (!$link) {
            return failResponse(__('messages.link_not_found'));
        }
        $link->delete();
        return successResponse();
    }
}
