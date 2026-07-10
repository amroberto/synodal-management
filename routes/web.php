<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Position\Edit as PositionEdit;
use App\Livewire\Position\Index as PositionIndex;
use App\Livewire\Position\Create as PositionCreate;
use App\Livewire\RevenueCategory\Edit as RevenueCategoryEdit;
use App\Livewire\RevenueCategory\Index as RevenueCategoryIndex;
use App\Livewire\RevenueCategory\Create as RevenueCategoryCreate;
use App\Livewire\Sector\Edit as SectorEdit;
use App\Livewire\Sector\Index as SectorIndex;
use App\Livewire\Sector\Create as SectorCreate;
use App\Livewire\Community\Edit as CommunityEdit;
use App\Livewire\Community\Index as CommunityIndex;
use App\Livewire\Community\Create as CommunityCreate;
use App\Livewire\Leadership\Edit as LeadershipEdit;
use App\Livewire\Leadership\Index as LeadershipIndex;
use App\Livewire\Leadership\Create as LeadershipCreate;
use App\Livewire\AccountPlan\Index as AccountPlanIndex;
use App\Livewire\AccountPlan\Show as AccountPlanShow;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route crud Positions
Route::middleware(['auth', 'verified'])->prefix('positions')->group(function () {
    Route::get('/', PositionIndex::class)->name('positions.index');
    Route::get('/create', PositionCreate::class)->name('position.create');
    Route::get('/{position}/edit', PositionEdit::class) ->name('positions.edit');

});

// Route crud Sectors
Route::middleware(['auth', 'verified'])->prefix('sectors')->group(function () {
    Route::get('/', SectorIndex::class)->name('sectors.index');
    Route::get('/create', SectorCreate::class)->name('sector.create');
    Route::get('/{sector}/edit', SectorEdit::class) ->name('sectors.edit');

});

// Route crud Communities
Route::middleware(['auth', 'verified'])->prefix('communities')->group(function () {
    Route::get('/', CommunityIndex::class)->name('communities.index');
    Route::get('/create', CommunityCreate::class)->name('communities.create');
    Route::get('/{community}/edit', CommunityEdit::class)->name('communities.edit');
});

// Route crud Leaderships
Route::middleware(['auth', 'verified'])->prefix('leaderships')->group(function () {
    Route::get('/', LeadershipIndex::class)->name('leaderships.index');
    Route::get('/create', LeadershipCreate::class)->name('leaderships.create');
    Route::get('/{leadership}/edit', LeadershipEdit::class)->name('leaderships.edit');
});

// Route crud RevenueCategory
Route::middleware(['auth', 'verified'])->prefix('revenue_categories')->group(function () {
    Route::get('/', RevenueCategoryIndex::class)->name('revenue_categories.index');
    Route::get('/create', RevenueCategoryCreate::class)->name('revenue_categories.create');
    Route::get('/{revenue_category}/edit', RevenueCategoryEdit::class)->name('revenue_categories.edit');
});

Route::prefix('account-plans')
    ->middleware(['auth'])
    ->group(function () {

        Route::get('/', AccountPlanIndex::class)
            ->name('account-plans.index');

        Route::get('/{accountPlan}', AccountPlanShow::class)
            ->name('account-plans.show');

    });

require __DIR__.'/settings.php';
