<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminNewPatient;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\BackBtnController;
use App\Http\Controllers\OTPPageController;
use App\Http\Controllers\SaveBtnController;
use App\Http\Controllers\EmailOTPController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginPageController;
use App\Http\Controllers\LogOutBtnController;
use App\Http\Controllers\DeleteFileController;
use App\Http\Controllers\QRCodeViewController;
use App\Http\Controllers\SeemoreBtnController;
use App\Http\Controllers\UpdateFileController;
use App\Http\Controllers\MedicalLogsController;
use App\Http\Controllers\SettingsBtnController;
use App\Http\Controllers\AdminSaveBtnController;
use App\Http\Controllers\ConfirmEmailController;
use App\Http\Controllers\DeleteAvatarController;
use App\Http\Controllers\SearchResultController;
use App\Http\Controllers\SettingsSaveController;
use App\Http\Controllers\AddImageIndexController;
use App\Http\Controllers\AdminLoginBtnController;
use App\Http\Controllers\OTPConfirmBtnController;
use App\Http\Controllers\StaffLoginBtnController;
use App\Http\Controllers\UpdateAccountController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GenerateQRCodeController;
use App\Http\Controllers\UpdatePasswordController;
use App\Http\Controllers\AccountListViewController;
use App\Http\Controllers\ActivateAccountController;
use App\Http\Controllers\PatientFullInfoController;
use App\Http\Controllers\PatientListViewController;
use App\Http\Controllers\UploadNewAvatarController;
use App\Http\Controllers\ViewMedicalLogsController;
use App\Http\Controllers\AccountListFetchController;
use App\Http\Controllers\ConsultationListController;
use App\Http\Controllers\DeleteImageIndexController;
use App\Http\Controllers\EditStaffAccountController;
use App\Http\Controllers\SearchResultViewController;
use App\Http\Controllers\DeactivateAccountController;
use App\Http\Controllers\EmailOTPSubmitBtnController;
use App\Http\Controllers\PatientListFilterController;
use App\Http\Controllers\UpdatePasswordBtnController;
use App\Http\Controllers\ViewMedicalImagesController;
use App\Http\Controllers\ViewPatientRecordController;
use App\Http\Controllers\AdminCreateAccountController;
use App\Http\Controllers\DashboardFetchDataController;
use App\Http\Controllers\SettingsUpdateViewController;
use App\Http\Controllers\AdminCreateAccountBtnController;
use App\Http\Controllers\ViewMedicalLogsImagesController;
use App\Http\Controllers\RedirectToSettingsUpdateController;
use App\Http\Controllers\RedirectUpdateAccountBtnController;
use App\Http\Controllers\PatientBasicInfoUpdateBtnController;
use App\Http\Controllers\PatientBasicInfoRedirectingBtnController;
use App\Http\Controllers\PatientFullInformationUpdateViewController;



// Guest
Route::middleware(['GuestMiddleware'])->group(function () {
// IPT System Routes
Route::get('/Login-Page',[LoginPageController::class,'ViewLoginPage'])->name('Login');
Route::post('/Login-Admin-Page',[AdminLoginBtnController::class,'AdminLoginBtn'])->name('Login.AdminProcess');
Route::post('/Login-Staff-Page',[StaffLoginBtnController::class,'StaffLoginBtn'])->name('Login.StaffProcess');
Route::get('/Forgot-Password-Page',[ForgotPasswordController::class,'ForgotPasswordPageView'])->name('Forgot.Password');
Route::post('/Forgot-Password-Confirm',[ConfirmEmailController::class,'ConfirmEmail'])->name('ForgotPassword.Confirm');
// Forgot Password page
});
Route::middleware(['ForgotPasswordMiddle'])->group(function () {
    Route::get('/Forgot-Password-OTP',[EmailOTPController::class,'EmailOTP'])->name('ForgotPassword.OTP');
    Route::post('/Forgot-Password-OTP',[EmailOTPSubmitBtnController::class,'EmailOTPSubmitBtn'])->name('ForgotPassword.Verfication');
    //  OTP Forgot Password
    Route::get('/Update-Password', [UpdatePasswordController::class,'UpdatePasswordView'])->name('Update.Password');
    Route::post('/Update-New-Password', [UpdatePasswordBtnController::class,'UpdatePasswordBtn'])->name('Update.NewPassword');
});


// OTP for Admin Only
Route::middleware(['auth','AdminMiddle:Admin'])->group(function () {
    Route::get('/OTP-Admin-Page',[OTPPageController::class,'ViewAdminOTPPage'])->name('AdminOTP.Page');
    Route::post('/OTP-Admin-Page-Cofirmation',[OTPConfirmBtnController::class,'AdminOTPConfirmBtn'])->name('AdminOTP.Confirm');
});


// Staff Only
Route::middleware(['auth','StaffMiddle:Staff'])->group(function () {
    Route::get('/OTP-Staff-Page',[OTPPageController::class,'ViewStaffOTPPage'])->name('StaffOTP.Page');                                                                                                                                                                                                             
    Route::post('/OTP-Staff-Page-Cofirmation',[OTPConfirmBtnController::class,'StaffOTPConfirmBtn'])->name('StaffOTP.Confirm');
});

// Admin Only Pages 
Route::middleware(['auth','AdminOTPMiddle'])->group(function () {          
    Route::get('/Create-Account',[AdminCreateAccountController::class,'ViewAdminCreateAccount'])->name('Admin.Create');
    Route::post('/Create-Account',[AdminCreateAccountBtnController::class,'CreateAccountBtn'])->name('Admin.Store');                                                                                                                                                                                              

    Route::get('/Account-List', [AccountListViewController::class,'ViewAccountList'])->name('Account.List');
    Route::get('/Account-List-Fetch', [AccountListFetchController::class,'FetchAllAccountsData'])->name('Fetch.AccountList');

    Route::get('/Account-Redirect', [RedirectUpdateAccountBtnController::class, 'RedirectToUpdateAccount'])->name('Redirect.UpdateAccount');
    Route::get('/Update-Account', [UpdateAccountController::class, 'UpdateAccount'])->name('Update.Account');
    Route::put('/Updating-Staff-Account', [EditStaffAccountController::class, 'EditStaffAccount'])->name('Updating.Staff');

    Route::put('/Account-Deactivated',[DeactivateAccountController::class,'DeactivateAcc'])->name('Admin.Deactivated');
    Route::put('/Account-Activate',[ActivateAccountController::class,'ActivateAcc'])->name('Admin.Activated');
    
    Route::get('/Add-New-Program', [ConsultationListController::class,'ConsultationListPage'])->name('Admin.AddProgramView');
    Route::post('/Add-Consultation', [ConsultationListController::class,'ConsultationList'])->name('Admin.AddProgram');
    Route::put('/Edit-Consultation', [ConsultationListController::class,'EditConsultation'])->name('Admin.EditProgram');
    Route::post('/Log-out', [LogOutBtnController::class,'LogoutBtn'])->name('Log-Out');
});


Route::middleware(['auth','CombineMiddle'])->group(function () {  
    Route::get('/RHU-Dashboard', [DashboardController::class, 'ShowDashboard'])->name('Admin.Dashboard');
    Route::get('/RHU-Dashboard-Fetch', [DashboardFetchDataController::class,'DashboardFetchData'])->name('Dashboard.fetchData');
    Route::get('/New-Patient',[AdminNewPatient::class,'ViewAdminNewPatient'])->name('Admin.New');
    Route::post('/New-Patient',[AdminSaveBtnController::class,'AdminSaveBtn'])->name('Admin.Save');
    
    Route::get('/Search-Result',[SearchResultController::class,'SearchResult'])->name('Admin.Result');
    Route::get('/Search-Result-View',[SearchResultViewController::class,'SearchResultView'])->name('Admin.SearchResult');
    Route::get('/Search-View',[SeemoreBtnController::class,'SeemoreBtn'])->name('Admin.FullView');

    // Qr-Code
    Route::get('/Generate-QR-Code',[GenerateQRCodeController::class,'GenerateQRCode'])->name('Generate.QrCode');
    Route::get('/QR-Code',[QRCodeViewController::class,'QRCodePage'])->name('View.QrCode');

    Route::get('/Patient-Full-Informations/{Stamp_Token}',[PatientFullInfoController::class,'ViewFullInfo'])->name('Admin.patientFullView');
    Route::post('/Patient-Full-Informations', [SaveBtnController::class,'SaveBtn'])->name('Admin.SaveMedicalLogs');


    Route::get('/Patient-Full-Informations-Update-Btn',[PatientBasicInfoRedirectingBtnController::class,'RedirectingToUpdatePage'])->name('Redirect.Update');
    Route::get('/Patient-Full-Informations-Update',[PatientFullInformationUpdateViewController::class,'ViewUpdatePage'])->name('BasicInfo.Update');
    Route::put('/Patient-Full-Informations-Updated',[PatientBasicInfoUpdateBtnController::class,'UpdatePatientInfo'])->name('BasicInfo.Updated');
    

    Route::get('/Patient-Medical-Logs',[ViewMedicalLogsController::class,'ViewMedicalLogs'])->name('Admin.ViewMedicalLogs');
    Route::get('/Patient-Medical-Logs-Records',[MedicalLogsController::class,'ViewMedicalLogsRecords'])->name('Admin.ViewMedicalLogsRecords');
    
    Route::get('/Patient-Medical-Logs-Records-View',[ViewMedicalImagesController::class,'ViewMedicalRecords'])->name('Admin.ViewMedicalRecords');
    
    Route::get('/View-Medical-Logs-Image/{PatientNumber}/{id}',[ViewMedicalLogsImagesController::class,'ViewMedicalLogsImages'])->name('Admin.ViewImages');
    Route::get('/PatientMedicalLogs',[BackBtnController::class,'BackBtn'])->name('Admin.BackBtn');
    
    Route::patch('/View-Medical-Logs-Image/delete',[DeleteImageIndexController::class,'DeleteImageIndex'])->name('Admin.DeleteIndex');
    Route::put('/View-MedicalLogs-Image/update', [AddImageIndexController::class, 'AddImageIndex'])->name('Admin.AddNewImages');
    
    Route::put('/View-Medical-Logs-Image/{PatientNumber}/{id}/update', [UpdateFileController::class,'UpdateFile'])->name('Admin.UpdateFile');
    
    Route::delete('/View-Medical-Logs-Image/{PatientNumber}/delete', [DeleteFileController::class,'DeleteFile'])->name('Admin.DeleteFile');
    Route::get('/View-Medical-Logs-Image/Filter', [FilterController::class, 'Filter'])->name('Admin.Filter');
    Route::get('/Patient-List-View', [PatientListViewController::class,'PatientListView'])->name('Admin.PatientList');
    Route::get('/Patient-List-View-Filtered', [PatientListFilterController::class,'PatientListFilter'])->name('Admin.PatientListFilter');

    Route::get('/Patient-Full-Information',[ViewPatientRecordController::class,'ViewMore'])->name('Admin.ViewMore');

    Route::get('/Redirect-To-Settings', [SettingsBtnController::class,'ToSettingPage'])->name('RedirectTo.Settings');
    Route::get('/Settings', [SettingsController::class,'SettingsView'])->name('Settings.View');
    Route::get('/Redirect-To-Update-Settings', [RedirectToSettingsUpdateController::class,'RedirectToUpdateSettings'])->name('RedirectTo.UpdateSettings');
    Route::get('/Settings-Update', [SettingsUpdateViewController::class,'SettingsUpdateView'])->name('Settings.Update');
    Route::put('/Settings-Save', [SettingsSaveController::class,'SaveAccountUpdate'])->name('Settings.UpdateSave');

    Route::put('/Settings-Update-Avatar', [UploadNewAvatarController::class,'UploadNewAvatar'])->name('Update.Avatar');
    Route::delete('/Settings-Delete-Avatar', [DeleteAvatarController::class,'DeleteAvatar'])->name('Delete.Avatar');
    
    Route::post('/Log-out', [LogOutBtnController::class,'LogoutBtn'])->name('Log-Out');
});



   
    
// web.php
Route::get('/db-check', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection is successful!';
    } catch (\Exception $e) {
        return 'Could not connect to the database. Please check your configuration. Error: ' . $e->getMessage();
    }
});






// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
