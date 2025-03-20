<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return view('coupons.index', compact('coupons'));
    }
    public function create()
    {
    return view('coupons.create');
    }
public function store(Request $request)
{
    $request->validate([
        'code' => 'required|unique:coupons',
        'discount' => 'required|numeric',
        'valid_from' => 'required|date',
        'valid_to' => 'required|date|after:valid_from',
    ]);

    Coupon::create($request->all());

    return redirect()->route('coupons.index')->with('success', 'Coupon created successfully.');
}
public function edit(Coupon $coupon)
{
    return view('coupons.edit', compact('coupon'));
}
public function update(Request $request, Coupon $coupon)
{
    $request->validate([
        'code' => 'required|unique:coupons,code,' . $coupon->id,
        'discount' => 'required|numeric',
        'valid_from' => 'required|date',
        'valid_to' => 'required|date|after:valid_from',
    ]);

    $coupon->update($request->all());

    return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully.');
}
public function destroy(Coupon $coupon)
{
    $coupon->delete();
    return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully.');
}

    }