<?php

use Illuminate\Http\Request;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAccessController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\NewPasswordController;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/email/verify', function () {
    return 'Email not verified';
})->middleware('auth:sanctum')->name('verification.notice');

Route::middleware('auth:sanctum', 'verified')->get('user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('reset-password', [NewPasswordController::class, 'resetPassword']);
Route::post('update-password', [NewPasswordController::class, 'updatePassword']);

Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

// Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
//     $enableViews = config('fortify.views', true);

//     // Password Reset...
//     if (Features::enabled(Features::resetPasswords())) {

//         Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
//             ->middleware(['guest:' . config('fortify.guard')])
//             ->name('password.email');

//         Route::post('/reset-password', [NewPasswordController::class, 'store'])
//             ->middleware(['guest:' . config('fortify.guard')])
//             ->name('password.update');
//     }

//     // Registration...
//     if (Features::enabled(Features::registration())) {
//         if ($enableViews) {
//             Route::get('/register', [RegisteredUserController::class, 'create'])
//                 ->middleware(['guest:' . config('fortify.guard')])
//                 ->name('register');
//         }

//         Route::post('/register', [RegisteredUserController::class, 'store'])
//             ->middleware(['guest:' . config('fortify.guard')]);
//     }

//     // Email Verification...
//     if (Features::enabled(Features::emailVerification())) {
//         if ($enableViews) {
//             Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
//                 ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
//                 ->name('verification.notice');
//         }

//         Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
//             ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard'), 'signed', 'throttle:' . $verificationLimiter])
//             ->name('verification.verify');

//         Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//             ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard'), 'throttle:' . $verificationLimiter])
//             ->name('verification.send');
//     }

//     // Profile Information...
//     if (Features::enabled(Features::updateProfileInformation())) {
//         Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
//             ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
//             ->name('user-profile-information.update');
//     }

//     // Passwords...
//     if (Features::enabled(Features::updatePasswords())) {
//         Route::put('/user/password', [PasswordController::class, 'update'])
//             ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
//             ->name('user-password.update');
//     }

//     // Password Confirmation...
//     if ($enableViews) {
//         Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])
//             ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')]);
//     }

//     Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])
//         ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
//         ->name('password.confirmation');

//     Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
//         ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
//         ->name('password.confirm');

//     // Two Factor Authentication...
//     if (Features::enabled(Features::twoFactorAuthentication())) {
//         if ($enableViews) {
//             Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])
//                 ->middleware(['guest:' . config('fortify.guard')])
//                 ->name('two-factor.login');
//         }

//         Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
//             ->middleware(array_filter([
//                 'guest:' . config('fortify.guard'),
//                 $twoFactorLimiter ? 'throttle:' . $twoFactorLimiter : null,
//             ]));

//         $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
//             ? [config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard'), 'password.confirm']
//             : [config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')];

//         Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
//             ->middleware($twoFactorMiddleware)
//             ->name('two-factor.enable');

//         Route::post('/user/confirmed-two-factor-authentication', [ConfirmedTwoFactorAuthenticationController::class, 'store'])
//             ->middleware($twoFactorMiddleware)
//             ->name('two-factor.confirm');

//         Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
//             ->middleware($twoFactorMiddleware)
//             ->name('two-factor.disable');

//         Route::get('/user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
//             ->middleware($twoFactorMiddleware)
//             ->name('two-factor.qr-code');

//         Route::get('/user/two-factor-secret-key', [TwoFactorSecretKeyController::class, 'show'])
//             ->middleware($twoFactorMiddleware)
//             ->name('two-factor.secret-key');

//         Route::get('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
//             ->middleware($twoFactorMiddleware)
//             ->name('two-factor.recovery-codes');

//         Route::post('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
//             ->middleware($twoFactorMiddleware);
//     }
// });
