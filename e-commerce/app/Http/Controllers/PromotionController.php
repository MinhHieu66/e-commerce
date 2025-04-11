<?php
namespace App\Http\Controllers;

use App\Models\Promotion;

class PromotionController extends Controller
{
    /**
     * List of Promotions
     */
    public function listPromotion()
    {
        // if (Auth::check()) {
        $promotions = Promotion::all();
        return view('crud.coupon-list', ['promotions' => $promotions]);

        // return redirect("login")->withSuccess('You are not allowed to access');
    }
}
