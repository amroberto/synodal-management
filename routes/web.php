<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Position\Edit as PositionEdit;
use App\Livewire\Position\Index as PositionIndex;
use App\Livewire\Position\Create as PositionCreate;
use App\Livewire\CostCenter\Edit as CostCenterEdit;
use App\Livewire\CostCenter\Index as CostCenterIndex;
use App\Livewire\CostCenter\Create as CostCenterCreate;

use App\Livewire\Synod\Edit as SynodEdit;

use App\Livewire\Sector\Edit as SectorEdit;
use App\Livewire\Sector\Index as SectorIndex;
use App\Livewire\Sector\Create as SectorCreate;
use App\Livewire\Entity\Edit as EntityEdit;
use App\Livewire\Entity\Index as EntityIndex;
use App\Livewire\Entity\Create as EntityCreate;
use App\Livewire\Leadership\Edit as LeadershipEdit;
use App\Livewire\Leadership\Index as LeadershipIndex;
use App\Livewire\Leadership\Create as LeadershipCreate;
use App\Livewire\AccountPlan\Index as AccountPlanIndex;
use App\Livewire\AccountPlan\Show as AccountPlanShow;

use App\Livewire\OfferDestination\Index as OfferDestinationIndex;
use App\Livewire\OfferDestination\Create as OfferDestinationCreate;
use App\Livewire\OfferDestination\Edit as OfferDestinationEdit;

use App\Livewire\OfferPlan\Index as OfferPlanIndex;
use App\Livewire\OfferPlan\Show as OfferPlanShow;
use App\Livewire\OfferPlan\Create as OfferPlanCreate;
use App\Livewire\OfferPlan\Edit as OfferPlanEdit;

use App\Livewire\FinancialAccount\Create as FinancialAccountCreate;
use App\Livewire\FinancialAccount\Edit as FinancialAccountEdit;
use App\Livewire\FinancialAccount\Index as FinancialAccountIndex;

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

// Route crud Entities
Route::middleware(['auth', 'verified'])->prefix('entities')->group(function () {
    Route::get('/', EntityIndex::class)->name('entities.index');
    Route::get('/create', EntityCreate::class)->name('entities.create');
    Route::get('/{entity}/edit', EntityEdit::class) ->name('entities.edit');
});

// Route crud Leaderships
Route::middleware(['auth', 'verified'])->prefix('leaderships')->group(function () {
    Route::get('/', LeadershipIndex::class)->name('leaderships.index');
    Route::get('/create', LeadershipCreate::class)->name('leaderships.create');
    Route::get('/{leadership}/edit', LeadershipEdit::class)->name('leaderships.edit');
});

Route::prefix('account-plans')->middleware(['auth'])->group(function () {
        Route::get('/', AccountPlanIndex::class)->name('account-plans.index');
        Route::get('/{accountPlan}', AccountPlanShow::class)->name('account-plans.show');
    });

// Route to Edit Synod
Route::middleware(['auth', 'verified'])->prefix('synods')->group(function() {
    Route::get('/{synod}/edit', SynodEdit::class)->name('synods.edit');
});

// CRUD OfferDestination
Route::middleware(['auth', 'verified'])->prefix('offer-destinations')->group(function () {
        Route::get('/', OfferDestinationIndex::class)->name('offer-destinations.index');
        Route::get('/create', OfferDestinationCreate::class)->name('offer-destinations.create');
        Route::get('/{offerDestination}/edit', OfferDestinationEdit::class)->name('offer-destinations.edit');
    });

// CRUD OfferPlan
Route::middleware(['auth', 'verified'])->prefix('offer-plans')->group(function () {
        Route::get('/', OfferPlanIndex::class)->name('offer-plans.index');
        Route::get('/create', OfferPlanCreate::class)->name('offer-plans.create');
        Route::get('/{offerPlan}', OfferPlanShow::class)->name('offer-plans.show');
        Route::get('/{offerPlan}/edit', OfferPlanEdit::class)->name('offer-plans.edit');
    });

// CRUD CostCenter
Route::middleware(['auth', 'verified'])->prefix('cost-centers')->group(function () {
        Route::get('/', CostCenterIndex::class)->name('cost-centers.index');
        Route::get('/create', CostCenterCreate::class)->name('cost-centers.create');
        Route::get('/{costCenter}/edit', CostCenterEdit::class)->name('cost-centers.edit');
    });

Route::middleware(['auth'])->group(function () {

    Route::get('/financial-accounts', FinancialAccountIndex::class)->name('financial-accounts.index');
    Route::get('/financial-accounts/create', FinancialAccountCreate::class)->name('financial-accounts.create');
    Route::get('/financial-accounts/{financialAccount}/edit', FinancialAccountEdit::class)->name('financial-accounts.edit');
});

require __DIR__.'/settings.php';
