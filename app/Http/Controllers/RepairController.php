<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRepairesRequest;
use App\Http\Requests\UpdateRepairRequest;
use App\Models\Repair;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class RepairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
      $repairs = Repair::latest()->paginate(5);
      return view('admin.repairs', compact('repairs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRepairesRequest $request){
        $validated = $request->validated();

        try {
            $ticket_number = 'TKN-' . Str::ulid();


            $repair = Repair::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'model' => $validated['model'],
                'category' => $validated['category'],
                'estimated_cost' => $validated['estimated_cost'],
                'ticket_number' => $ticket_number
            ]);


            return response()->json([
                'message' => 'Ticket registered successfully!',
                'data' => $repair
            ], 201);

        } catch (Exception $e) {
            Log::error('Repair Ticket Creation Failed: ' . $e->getMessage(), [
                'input_payload' => $validated,
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);


            return response()->json([
                'message' => 'Something went wrong on our end. Please try again later.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Repair $repair)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Repair $repair)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateRepairRequest $request, Repair $repair)
    {
        // Precognition intercepts here automatically if it's just a background validation test run!
        $validated = $request->validated();

        try {
            // Direct targeted column execution overwrite
            $repair->update([
                'name'           => $validated['name'],
                'description'    => $validated['description'],
                'model'          => $validated['model'],
                'category'       => $validated['category'],
                'estimated_cost' => $validated['estimated_cost'],
                'status'         => $validated['status'],
            ]);

            return response()->json([
                'message' => 'Ticket updated successfully!',
                'data'    => $repair
            ], 200);

        } catch (Exception $e) {
            Log::error('Repair Ticket Update Failed: ' . $e->getMessage(), [
                'id'            => $repair->id,
                'input_payload' => $validated
            ]);

            return response()->json([
                'message' => 'Something went wrong on our end while updating.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Repair $repair)
    {
        //
    }
}
