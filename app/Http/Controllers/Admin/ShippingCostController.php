<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingCost;
use Illuminate\Http\Request;

class ShippingCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippingAreas = ShippingCost::latest()->get();
        return view('admin.shipping-cost.index', compact('shippingAreas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'area_name' => 'required | string',
            'cost'      => 'required | int',
        ]);
        try {
            ShippingCost::create($request->all());
            return redirect()->back()->withSuccess('Shipping Area Added');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShippingCost  $shippingCost
     * @return \Illuminate\Http\Response
     */
    public function edit($shippingCostId)
    {
        $cost = ShippingCost::findOrFail($shippingCostId);
        return view('admin.shipping-cost.edit', compact('cost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShippingCost  $shippingCost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $shippingCostId)
    {
        $request->validate([
            'area_name' => 'required | string',
            'cost'      => 'required | int',
        ]);
        try {
            ShippingCost::findOrFail($shippingCostId)->update($request->all());
            return redirect()->route('admin.shipping.cost')->withSuccess('Shipping Area Updated');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShippingCost  $shippingCost
     * @return \Illuminate\Http\Response
     */
    public function destroy($shippingCostId)
    {
        try {
            ShippingCost::findOrFail($shippingCostId)->delete();
            return redirect()->route('admin.shipping.cost')->withSuccess('Shipping Area Deleted');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }
}