<?php

namespace App\Http\Controllers;

use App\Http\Requests\WidgetPostRequest;
use App\Http\Requests\WidgetPutRequest;
use App\Http\Resources\WidgetCollection;
use App\Http\Resources\WidgetResource;
use App\Models\Widget;
use Illuminate\Http\Resources\Json\JsonResource;

class WidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $widgets = Widget::all();

        return WidgetCollection::make($widgets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  WidgetPostRequest  $request
     * @return JsonResource
     */
    public function store(WidgetPostRequest $request): JsonResource
    {
        $widget = new Widget();
        $widget->fill($request->toArray());

        $widget->save();

        return WidgetResource::make($widget);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Widget  $widget
     * @return JsonResource
     */
    public function show(Widget $widget): JsonResource
    {
        return WidgetResource::make($widget);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  WidgetPutRequest  $request
     * @param  \App\Models\Widget  $widget
     * @return JsonResource
     */
    public function update(WidgetPutRequest $request, Widget $widget): JsonResource
    {
        $widget->fill($request->toArray());
        $widget->save();

        return WidgetResource::make($widget);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Widget  $widget
     */
    public function destroy(Widget $widget)
    {
        $widget->delete();
    }
}
