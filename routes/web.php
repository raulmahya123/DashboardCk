<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PowerBIController;

use Illuminate\Support\Facades\DB;

Route::get('/powerbi', function (Request $request) {
    $userId = auth()->user()->id ?? "xupj10rts"; // Ganti sesuai kebutuhan
    $formType = $request->query('FormType');

    if (!$formType) {
        return response()->json(['error' => 'FormType is required'], 400);
    }

    $redirectUrl = User::getPowerBILink($userId, $formType);

    if (!$redirectUrl) {
        return response()->json(['error' => 'No data found or failed to generate URL'], 404);
    }

    return Redirect::to($redirectUrl);
});
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/test-session', function () {
    Session::put('test_key', 'Hello World');
    Session::save();
    return response()->json(['session_test' => Session::get('test_key')]);
});

Route::get('/check-db-connection', function () {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'status' => 'success',
            'message' => 'Database connection successful!',
            'database' => DB::connection()->getDatabaseName(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Database connection failed!',
            'error' => $e->getMessage(),
        ], 500);
    }
});
