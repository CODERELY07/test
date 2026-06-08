<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepairController;
use App\Models\Repair;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/repairs', [RepairController::class, 'destroy'])
    ->name('repairs.destroy')
    ->middleware([HandlePrecognitiveRequests::class]);
    Route::resource('/repairs', RepairController::class)->middleware([HandlePrecognitiveRequests::class]);
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/repair/{repair}/receipt', function(Repair $repair) {
        // Generate as standard SVG text stream (requires NO extra php extensions)
        $qrCodeSvg = QrCode::format('svg')
            ->size(400)
            ->errorCorrection('H')
            ->generate($repair->ticket_number);

        return view('admin.repairs.receipt', [
            'repair' => $repair,
            'qrCodeSvg' => $qrCodeSvg
        ]);
    })->name('repair.reciept');
});

Route::get('/track-repair/{ticket}', function ($ticket) {
    $cleanTicket = ltrim(trim($ticket), '#');

    $repair = Repair::where('ticket_number', $cleanTicket)
        ->orWhere('ticket_number', '#' . $cleanTicket)
        ->first();

    if (!$repair) {
        return response()->json(['found' => false]);
    }

    return response()->json([
        'found' => true,
        'ticket_number' => $repair->ticket_number,
        'status' => Str::lower($repair->status->value ?? $repair->status),
        'model' => $repair->model,
        'category' => $repair->category,
        'description' => $repair->description ?? 'No diagnostic notes provided.',
        'estimated_cost' => number_format((float)$repair->estimated_cost, 2),
        'downpayment' => number_format((float)$repair->estimated_cost, 2),
    ]);
});

require __DIR__.'/auth.php';
