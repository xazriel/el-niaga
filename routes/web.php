<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\JneController;
use App\Http\Controllers\Admin\SizeGuideController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminLoyaltyController;
use App\Http\Controllers\Admin\SalesAnalysisController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Customer\CustomerProductCatalogController;
use App\Http\Controllers\Customer\CustomerArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [HomeController::class, 'show'])->name('product.details');

Route::get('/products',        [CustomerProductCatalogController::class, 'index'])->name('products.index');
Route::get('/articles',        [CustomerArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [CustomerArticleController::class, 'show'])->name('articles.show');
Route::view('/about-us',       'about')->name('about-us');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',               [CartController::class, 'index'])->name('index');
    Route::post('/add/{id}',      [CartController::class, 'add'])->name('add');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::patch('/update/{id}',  [CartController::class, 'update'])->name('update');
});

Route::post('/midtrans/callback', [CheckoutController::class, 'midtransCallback'])
    ->name('midtrans.callback')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard');

    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/address-update', [AddressController::class, 'update'])->name('profile.address.update');

    Route::get('/profile/orders',                [ProfileController::class, 'index'])->name('profile.orders');
    Route::get('/profile/orders/{order_number}', [ProfileController::class, 'orderDetail'])->name('profile.orders.detail');

    Route::get('/profile/track/{awb}',        [ProfileController::class, 'trackResi'])->name('tracking.resi');
    Route::get('/profile/track-detail/{awb}', [ProfileController::class, 'trackResi'])->name('tracking.show');

    Route::prefix('profile/addresses')->name('address.')->group(function () {
        Route::get('/',             [AddressController::class, 'index'])->name('index');
        Route::get('/create',       [AddressController::class, 'create'])->name('create');
        Route::post('/',            [AddressController::class, 'store'])->name('store');
        Route::get('/{id}/edit',    [AddressController::class, 'edit'])->name('edit');
        Route::put('/{id}',         [AddressController::class, 'update'])->name('update');
        Route::post('/{id}/select', [AddressController::class, 'select'])->name('select');
        Route::delete('/{id}',      [AddressController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/',                        [CheckoutController::class, 'index'])->name('index');
        Route::post('/store',                  [CheckoutController::class, 'store'])->name('store');
        Route::get('/waiting/{order_number}',  [CheckoutController::class, 'waiting'])->name('waiting');
        Route::get('/success/{order_number}',  [CheckoutController::class, 'success'])->name('success');
        Route::patch('/cancel/{order_number}', [CheckoutController::class, 'cancel'])->name('cancel');
    });

    Route::get('/api/locations',      [JneController::class,      'searchLocation'])->name('api.locations');
    Route::post('/api/shipping-cost', [CheckoutController::class, 'calculateShipping'])->name('api.shipping');
    Route::post('/profile/redeem-voucher/{id}', [ProfileController::class, 'redeemVoucher'])->name('profile.redeem-voucher');
    Route::post('/api/check-voucher',           [CheckoutController::class, 'checkVoucher'])->name('api.check-voucher');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [SalesAnalysisController::class, 'index'])->name('dashboard');

    Route::resource('categories',  CategoryController::class);
    Route::resource('products',    ProductController::class);
    Route::resource('sliders',     SliderController::class);
    Route::resource('size-guides', SizeGuideController::class);

    Route::delete('/product-images/{id}',            [ProductController::class, 'destroyImage'])->name('products.images.destroy');
    Route::patch('/product-images/{id}/set-primary', [ProductController::class, 'setPrimary'])->name('products.images.setPrimary');

    // export HARUS di atas /{order_number} agar tidak ditangkap sebagai wildcard
    Route::get('/orders/export',                  [AdminOrderController::class, 'export'])->name('orders.export');
    Route::get('/orders',                         [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order_number}',          [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order_number}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Kelola Pelanggan (CRM)
    Route::get('/customers',      [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}', [AdminCustomerController::class, 'show'])->name('customers.show');

    // Loyalty Points (CRM) & Vouchers CMS
    Route::get('/loyalty',                  [AdminLoyaltyController::class, 'index'])->name('loyalty.index');
    Route::post('/loyalty/adjust/{userId}', [AdminLoyaltyController::class, 'adjust'])->name('loyalty.adjust');
    Route::get('/loyalty/vouchers',         [AdminLoyaltyController::class, 'vouchersIndex'])->name('loyalty.vouchers');
    Route::post('/loyalty/vouchers',        [AdminLoyaltyController::class, 'vouchersStore'])->name('loyalty.vouchers.store');
    Route::put('/loyalty/vouchers/{id}',    [AdminLoyaltyController::class, 'vouchersUpdate'])->name('loyalty.vouchers.update');
    Route::delete('/loyalty/vouchers/{id}', [AdminLoyaltyController::class, 'vouchersDestroy'])->name('loyalty.vouchers.destroy');

    // Sales Analysis & BI Dashboard
    Route::get('/analysis',                [SalesAnalysisController::class, 'index'])->name('analysis.index');
    Route::post('/analysis/clearance/{id}', [SalesAnalysisController::class, 'applyClearanceDiscount'])->name('analysis.clearance');

    // Articles CMS
    Route::resource('articles', AdminArticleController::class);

    // Report Generator
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');

    // Settings Editor
    Route::get('/settings',  [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';