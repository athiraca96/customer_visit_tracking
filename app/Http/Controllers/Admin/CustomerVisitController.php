<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerCallRequest;
use App\Models\CustomerVisit;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CustomerVisitController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth',
            'role:admin',
        ];
    }

    /**
     * Show the customer call page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.customer_call');
    }

    /**
     * Customer call.
     *
     * @param  LoginRequest  $request
     * @return RedirectResponse
     */
    public function store(CustomerCallRequest $request)
    {
        $input = $request->validated();

        $imageData = $request->image_data;
        $imageName = 'name_board_images/' . uniqid() . '.png';
        Storage::disk('public')->put($imageName, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData)));

        CustomerVisit::create([
            'visit_type' => 'new_call',
            'latitude' => $input['latitude'],
            'longitude' => $input['longitude'],
            'gst_number' => $input['gst_number'],
            'pincode' => $input['pincode'],
            'name_board_image' => $imageName ?? null,
        ]);

        return redirect()->back()->with('success', 'Entry submitted successfully!');
    }
}
