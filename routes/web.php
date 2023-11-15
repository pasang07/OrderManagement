<?php

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

//Auth::routes();
Route::get('lang/{locale}', 'FrontEnd\Home\HomeController@lang');

Route::group(['prefix' => 'system'], function ($router) {
    $router->get('login', 'Auth\SuperAdminLoginController@showLoginForm')->name('superadmin.login');
    $router->post('login', 'Auth\SuperAdminLoginController@login')->name('superadmin.login');
    $router->get('logout', 'Auth\SuperAdminLoginController@logout')->name('superadmin.logout');
});
Route::group(['middleware' => 'superadmin', 'prefix' => 'super-admin'], function ($router) {
    $router->get('/dashboard', 'SuperAdmin\Dashboard\DashboardController@index')->name('superadmin.dashboard');
    /*Change Password Routes*/
    $router->get('user/change-password', ['uses' => 'SuperAdmin\User\UserController@updateCredentialForm'])->name('user.change-password-form');
    $router->post('user/change-password', ['uses' => 'SuperAdmin\User\UserController@updateCredential'])->name('user.change-password');
    /*User Routes*/
    $router->get('user/search', ['uses' => 'SuperAdmin\User\UserController@search'])->name('user.search');
    $router->resource('user','SuperAdmin\User\UserController')->except(['show']);
    $router->post('user/{id}/update', ['uses' => 'SuperAdmin\User\UserController@update'])->name('user.update');
    $router->get('user/{id}/destroy', ['uses' => 'SuperAdmin\User\UserController@destroy'])->name('user.destroy');


    /*Client Routes*/
    $router->get('client/search', ['uses' => 'SuperAdmin\User\ClientController@search'])->name('client.search');
    $router->resource('client','SuperAdmin\User\ClientController')->except(['show']);
//    $router->get('client-list','SuperAdmin\User\ClientController@clientIndex')->name('all.client');
    $router->post('client/{id}/update', ['uses' => 'SuperAdmin\User\ClientController@update'])->name('client.update');
    $router->get('client/{id}/destroy', ['uses' => 'SuperAdmin\User\ClientController@destroy'])->name('client.destroy');
    $router->post('client-update-password', ['uses' => 'SuperAdmin\User\ClientController@updatePassword'])->name('client-update.password');
    $router->get('reset-client-password/{clientId}', ['uses' => 'SuperAdmin\User\ClientController@resetClientPassword'])->name('reset-client-password');

    /*Agent Routes*/
    $router->get('agent/search', ['uses' => 'SuperAdmin\User\AgentController@search'])->name('agent.search');
    $router->resource('agent','SuperAdmin\User\AgentController')->except(['show']);
    $router->post('agent/{id}/update', ['uses' => 'SuperAdmin\User\AgentController@update'])->name('agent.update');
    $router->get('agent/{id}/destroy', ['uses' => 'SuperAdmin\User\AgentController@destroy'])->name('agent.destroy');
    $router->post('agent-update-password', ['uses' => 'SuperAdmin\User\AgentController@updatePassword'])->name('agent-update.password');
    $router->get('reset-agent-password/{agentId}', ['uses' => 'SuperAdmin\User\AgentController@resetAgentPassword'])->name('reset-agent-password');

    /*Upload Profile Routes*/
    $router->get('user/profile-setting/{id}', ['uses' => 'SuperAdmin\User\UserController@updateProfileForm'])->name('user.profile-setting-form');
    $router->post('user/profile/{id}', ['uses' => 'SuperAdmin\User\UserController@updateProfile'])->name('user.profile.setting');

    $router->get('my-profile/{id}', ['uses' => 'SuperAdmin\User\UserController@displayProfile'])->name('user.profile-view');


    /*Product Routes*/
    $router->get('product/search', ['uses' => 'SuperAdmin\Product\ProductController@search'])->name('product.search');
    $router->resource('product','SuperAdmin\Product\ProductController')->except(['show']);
    $router->post('product/{id}/update', ['uses' => 'SuperAdmin\Product\ProductController@update'])->name('product.update');
    $router->get('product/{id}/destroy', ['uses' => 'SuperAdmin\Product\ProductController@destroy'])->name('product.destroy');
    $router->get('change/product-status', ['uses' => 'SuperAdmin\Product\ProductController@changeProductStatus'])->name('change-status-button');

    /*Product Batch*/
    $router->get('productbatch', ['uses' => 'SuperAdmin\Product\ProductBatchController@index'])->name('productbatch.index');
    $router->post('productbatch/store', ['uses' => 'SuperAdmin\Product\ProductBatchController@store'])->name('productbatch.store');
    $router->post('productbatch/{id}/update', ['uses' => 'SuperAdmin\Product\ProductBatchController@update'])->name('productbatch.update');
    $router->get('productbatch/{id}/destroy', ['uses' => 'SuperAdmin\Product\ProductBatchController@destroy'])->name('productbatch.destroy');
    $router->post('productbatch/insert', 'SuperAdmin\Product\ProductBatchController@insert')->name('productbatch.insert');

    /*MOQ Routes*/
    $router->resource('moq','SuperAdmin\Product\MoqController')->except(['show']);
    $router->post('moq/{id}/update', ['uses' => 'SuperAdmin\Product\MoqController@update'])->name('moq.update');
    $router->get('moq/{id}/destroy', ['uses' => 'SuperAdmin\Product\MoqController@destroy'])->name('moq.destroy');
    $router->get('productBatch', ['uses' => 'SuperAdmin\Product\MoqController@productBatchDetail'])->name('get-productBatch');

    /*OrderList Routes*/
    $router->post('order-list/{id}/update', ['uses' => 'SuperAdmin\OrderList\OrderListController@update'])->name('order-list.update');
    $router->get('order-list/{id}/destroy', ['uses' => 'SuperAdmin\OrderList\OrderListController@destroy'])->name('order-list.destroy');

    /*Admin Order Routes*/
    $router->get('order-query', ['uses' => 'SuperAdmin\OrderList\OrderListController@adminViewIndex'])->name('order-query.index');
    $router->get('view-order/{orderNo}', ['uses' => 'SuperAdmin\OrderList\OrderListController@adminViewOrderDetails'])->name('order-view');
    $router->post('view-order/{id}/manage', ['uses' => 'SuperAdmin\OrderList\OrderListController@manageOrderByAdmin'])->name('manage-OrderByAdmin');
    $router->post('send-order/{id}/review', ['uses' => 'SuperAdmin\OrderList\OrderListController@reviewConfirmedByAdmin'])->name('review.order.send');
    $router->get('confirm-order-details/{orderNo}', ['uses' => 'SuperAdmin\OrderList\OrderListController@confirmedOrderPage'])->name('confrim-order.details');

    $router->resource('order-list','SuperAdmin\OrderList\CustomerOrderListController')->except(['show']);
    $router->get('order-list/confirm', ['uses' => 'SuperAdmin\OrderList\CustomerOrderListController@confirmOrderList'])->name('confirm-order-list.index');
    $router->get('order-list/cancel', ['uses' => 'SuperAdmin\OrderList\CustomerOrderListController@cancelOrderList'])->name('cancel-order-list.index');
    $router->get('place-order', ['uses' => 'SuperAdmin\OrderList\CustomerOrderListController@placeOrder'])->name('place-order');
    $router->get('check-product', ['uses' => 'SuperAdmin\OrderList\CustomerOrderListController@checkedProductDetail'])->name('get-check-product');
    $router->get('check-moq', ['uses' => 'SuperAdmin\OrderList\CustomerOrderListController@checkMoq'])->name('checkMOQ');
    $router->get('view-place-order/{orderNo}', ['uses' => 'SuperAdmin\OrderList\CustomerOrderListController@viewPlacedOrder'])->name('view.place-order');
    $router->get('individual-cancel-order/{orderId}', ['uses' => 'SuperAdmin\OrderList\CustomerOrderListController@individualCancelOrderByCustomer'])->name('individual-cancel.order');
    $router->get('order-for-confirmation/{orderNo}', ['uses' => 'SuperAdmin\OrderList\CustomerOrderListController@viewOrderToConfirm'])->name('for-order-confirmation');
    $router->get('individual-order-approve/{orderId}', ['uses' => 'SuperAdmin\OrderList\CustomerOrderListController@individualApproveOrderByCustomer'])->name('individual-approve.order');
    $router->get('individual-order-reject', ['uses' => 'SuperAdmin\OrderList\CustomerOrderListController@individualRejectOrderByCustomer'])->name('individual-reject.order');
    $router->get('send-order-confirmation/{orderNo}', ['uses' => 'SuperAdmin\OrderList\CustomerOrderListController@sendOrderConfirmation'])->name('send-order.confirmation');
    $router->get('order-full-details/{orderNo}', ['uses' => 'SuperAdmin\OrderList\CustomerOrderListController@detailsAfterOrderConfirmation'])->name('order-full-details');
    $router->get('detail/{orderNo}', ['uses' => 'SuperAdmin\OrderList\CustomerOrderListController@detailsRejectOrder'])->name('reject-order-details');
    $router->get('send/{orderNo}', ['uses' => 'SuperAdmin\OrderList\CustomerOrderListController@allOrderReject'])->name('all-order.reject');

    /*Refer Customer By Agent*/
    $router->resource('refer-customer','SuperAdmin\ReferCustomer\ReferCustomerController')->except(['show']);
    $router->post('refer-customer/{id}/update', ['uses' => 'SuperAdmin\ReferCustomer\ReferCustomerController@update'])->name('refer-customer.update');
    $router->get('refer-customer/{id}/destroy', ['uses' => 'SuperAdmin\ReferCustomer\ReferCustomerController@destroy'])->name('refer-customer.destroy');

    /*Admin Action on Referred Customer*/
    $router->resource('admin-refer-customer','SuperAdmin\ReferCustomer\AdminActionReferCustomerController')->except(['show']);
    $router->get('admin-refer-customer/{id}/approve', ['uses' => 'SuperAdmin\ReferCustomer\AdminActionReferCustomerController@approve'])->name('admin-refer-customer.approve');
    $router->get('admin-refer-customer/{id}/reject', ['uses' => 'SuperAdmin\ReferCustomer\AdminActionReferCustomerController@destroy'])->name('admin-refer-customer.reject');

    /*Set Agent Commission Routes*/
    $router->get('agent-commission', ['uses' => 'SuperAdmin\AgentCommission\AgentCommissionController@index'])->name('agent-commission.index');
    $router->get('manage-commission/{id}', ['uses' => 'SuperAdmin\AgentCommission\AgentCommissionController@manage'])->name('manage-commission.index');
    $router->get('change/commission-status', ['uses' => 'SuperAdmin\AgentCommission\AgentCommissionController@changeCommissionStatus'])->name('change-commission-status');
    $router->get('view-commission/{id}', ['uses' => 'SuperAdmin\AgentCommission\AgentCommissionController@viewCommission'])->name('view-commission.index');
    $router->post('agent-commission/store', ['uses' => 'SuperAdmin\AgentCommission\AgentCommissionController@store'])->name('agent-commission.store');
    $router->post('agent-commission/{id}/update', ['uses' => 'SuperAdmin\AgentCommission\AgentCommissionController@update'])->name('agent-commission.update');

    /*Commission Routes*/
    $router->get('commission-lists', ['uses' => 'SuperAdmin\Commission\CommissionController@index'])->name('commission-list.index');
    $router->get('agent-wise-commission/{id}', ['uses' => 'SuperAdmin\Commission\CommissionController@detail'])->name('agent-wise-commission');

    /* Menu */
    $router->resource('nav','SuperAdmin\Menu\NavController')->except(['show']);
    $router->get('nav/parent/{id}',['uses' => 'SuperAdmin\Menu\NavController@parent'])->name('nav.parent.index');
    $router->get('nav/create/{id?}', ['uses' => 'SuperAdmin\Menu\NavController@create'])->name('nav.create');
    $router->post('nav/{id}/update', ['uses' => 'SuperAdmin\Menu\NavController@update'])->name('nav.update');
    $router->get('nav/{id}/destroy', ['uses' => 'SuperAdmin\Menu\NavController@destroy'])->name('nav.destroy');
    $router->get('nav/search', ['uses' => 'SuperAdmin\Menu\NavController@search'])->name('nav.search');
    $router->post('nav/change-type-create', ['uses' => 'SuperAdmin\Menu\NavController@ChangeTypeCreate'])->name('nav.change-type-create');
    $router->post('nav/change-type-update', ['uses' => 'SuperAdmin\Menu\NavController@ChangeTypeUpdate'])->name('nav.change-type-update');

    /*Site Settings Routes*/
    $router->get('site-setting/{id}/edit', ['uses' => 'SuperAdmin\SiteSetting\SiteSettingController@edit'])->name('site-setting.edit');
    $router->post('site-setting/{id}/update', ['uses' => 'SuperAdmin\SiteSetting\SiteSettingController@update'])->name('site-settings.update');
    /*Ajax Call for Status And Delete Action*/
    $router->post('change-status',['uses' => 'Api\ActionApiController@updateStatus'])->name('change.status');
    $router->post('action-delete',['uses' => 'Api\ActionApiController@deletePost'])->name('delete.post');
    /*SEO Routes*/
    $router->get('seo/search', ['uses' => 'SuperAdmin\SEO\SEOController@search'])->name('seo.search');
    $router->resource('seo','SuperAdmin\SEO\SEOController')->except(['show']);
    $router->post('seo/{id}/update', ['uses' => 'SuperAdmin\SEO\SEOController@update'])->name('seo.update');
    $router->get('seo/{id}/destroy', ['uses' => 'SuperAdmin\SEO\SEOController@destroy'])->name('seo.destroy');

    /*Ajax Call for Sort table*/
    $router->post('ajax/sortable',['uses' => 'Api\SortableController@sortable'])->name('ajax.sortable');
});

/*Front End Routes*/
Route::get('/', 'Auth\SuperAdminLoginController@showLoginForm')->name('home.index');
Route::get('/verify/{email}/{remember_token}', 'SuperAdmin\User\ClientController@verifyCustomer')->name('verify.customer');
Route::get('/activate/{email}/{remember_token}', 'SuperAdmin\User\AgentController@activate');
/*Captcha Code*/
Route::get('refresh-captcha', 'CaptchaController@refreshCaptcha')->name('refresh-captcha');
