<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WelcomeController@welcome')->name('home');
Route::view('/welcome', 'welcome')->name('welcome');
Route::view('/whats-new', 'pages.whats-new')->name('whats-new');
Route::view('/changelog', 'pages.changelog')->name('changelog');
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/donate', 'pages.donate', ['title'=>'Support the site']);
Route::get('/account-migrated', 'WelcomeController@account_migrated')->name('account-migrated');
Route::get('/account-migrated-acknowledge', 'WelcomeController@account_migrated_acknowledge')->name('account-migrated-acknowledge');

Route::get('/terms-and-conditions', 'AgreementController@view')->name('terms-and-conditions');
Route::get('/privacy-policy', 'PolicyController@view')->name('privacy-policy');

Route::get('/prompt-tos', 'AgreementController@show')->name('prompt-tos');
Route::get('/agreement-accepted', 'AgreementController@accept')->name('agreement-accepted');

Route::get('invite/accept', 'InviteController@accept')->name('invite.accept')->middleware(['auth', 'agreement']);
Route::get('invite/reject', 'InviteController@showRejectConfirmation')->name('invite.reject-confirm')->middleware(['auth', 'agreement']);
Route::post('invite/reject', 'InviteController@reject')->name('invite.reject')->middleware(['auth', 'agreement']);
Route::get('invite/register', 'InviteController@register')->name('invite.register')->middleware(['register', 'signed:relative']);

// Calendar management
Route::get('calendars/{calendar}/print', 'CalendarController@print')->name('calendars.print')->middleware('agreement');
Route::get('calendars/{calendar}/export', 'CalendarController@export')->name('calendars.export')->middleware('agreement');
Route::resource('calendars', 'CalendarController')->middleware('agreement');


// User auth
Auth::routes(['verify' => true]);
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/admin/loginas/{userid}', 'AdminController@loginas')->name('admin.loginas')->middleware('admin');


// Subscription management
// Pricing page
Route::get('/pricing', 'SubscriptionController@pricing')->name('subscription.pricing');

// List current subscription
Route::get('/subscription', 'SubscriptionController@index')->name('subscription.index');

// They want to subscribe!
Route::get('/subscription/subscribe/{level}/{interval}', 'SubscriptionController@subscribe')->name('subscription.subscribe')->middleware('agreement');
Route::post('/subscription/subscribe', 'SubscriptionController@createsubscription')->name('subscription.create')->middleware('agreement');

// They want to cancel =(
Route::get('/subscription/cancel', 'SubscriptionController@cancellation')->name('subscription.cancel')->middleware('agreement');
Route::post('/subscription/cancel', 'SubscriptionController@cancel')->name('subscription.cancelpost')->middleware('agreement');

// They want to resume! =)
Route::get('/subscription/resume', 'SubscriptionController@resume')->name('subscription.resume')->middleware('agreement');

// They want to upgrade
Route::post('/subscription/update/{level}/{plan}', 'SubscriptionController@update')->name('subscription.update')->middleware('agreement');

Route::post('pricing/coupon', 'SubscriptionController@coupon');

// User profile
Route::get('/profile', 'SettingsController@profile')->middleware(['auth', 'agreement'])->name('profile');
Route::post('/profile', 'SettingsController@update')->name('settings.update')->middleware(['auth', 'agreement']);
Route::post('/profile/password', 'SettingsController@updatePassword')->middleware(['auth', 'agreement']);

Route::get('/error/unavailable', 'ErrorsController@calendarUnavailable')->name('errors.calendar_unavailable');
// Manual error page routes for the moment
Route::get('/403', 'ErrorsController@error403');

Route::get('/404', 'ErrorsController@error404');

Route::get('/{path}', 'CalendarController@legacy')->where(['url' => 'calendar.php|calendar']);
Route::get('{path}', 'ErrorsController@error404');
