<?php

use App\Http\Controllers\store;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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



Route::get('/test/posts', 'TestImageController@index')->name('posts.index');
Route::post('/test/posts', 'TestImageController@store')->name('posts.store');
Route::delete('/test/posts/{id}', 'TestImageController@destroy')->name('posts.destroy');
#----------------------------------
Route::get('/test', function(){
	return view('test');
});
Route::get('/test-plantilla', function(){
	return view('testplantilla');
});
Route::get('/test-plantilla-contenido', function(){
	return view('testplantillacontenido');
});

Route::get('/euderm', 'AbbasterPagesController@eudermIndex');
Route::get('/roho-seguros', 'AbbasterPagesController@rohoIndex');

#LINKS DE ABBASTER
Route::get('/', 'AbbasterPagesController@index');
Route::get('/search', 'AbbasterPagesController@search')->name('ababster.search');
Route::get('/como-comprar/', 'AbbasterPagesController@comoComprar');
Route::get('/crece/', 'AbbasterPagesController@crece');

Route::get('/proyectos/', 'AbbasterPagesController@proyectos');
Route::get('/proyectos/detalle/{project_id}', 'AbbasterPagesController@proyecto')->name('project.detail');

Route::get('/ecommerce/', 'AbbasterPagesController@ecommerce');
Route::get('/terminos-y-condiciones/', 'AbbasterPagesController@terminosyCondiciones');
Route::get('/politica-de-privacidad/', 'AbbasterPagesController@politicaDePrivacidad');
Route::get('/access/', 'AbbasterPagesController@access');
Route::post('/customer/register', 'CustomersController@registerCustomer');
#NEW ROUTES FOR COMPONENTES VUE
Route::get('/web/product/comentarios/get/{product_id}', 'WebProductsController@getComentarios');
Route::post('/web/product/comentarios/store', 'WebProductsController@storeComentario');

Route::get('/select-currency','AbbasterPagesController@selectCurrency');


Route::get('/shopping-cart', 'AbbasterPagesController@shoppingCart');
Route::get('/confirm-payment', 'AbbasterPagesController@confirmPayment');

/*----------------------------------------------------------------------------------------- */
/*----------------------------------------------------------------------------------------- */
Route::get('/payment', 'AbbasterPagesController@payment')->name('payment.payment');
Route::get('/payment/show', 'AbbasterPagesController@paymentShow')->name('payment.show');

Route::get('/payment/pay', 'AbbasterPagesController@pay')->name('mp.pay');

Route::post('/mpwebhooks', 'MPWebhooksController');
/*----------------------------------------------------------------------------------------- */
/*----------------------------------------------------------------------------------------- */

Route::post('/confirm-payment/store-address', 'ShoppingCartController@guardarDireccionEnvioCliente');

Route::post('/login-customer', 'Auth\MyLoginController@loginCustomer');


//NUEVOS METODOS PARA SHOPPING CART GNERAL, AXIOS VUE
#Shopping Cart New
Route::get('/shopping-cart/get', 'ShoppingCartController@getShoppingCart');
Route::get('/shopping-cart/get-states', 'ShoppingCartController@getStates');
Route::get('/shopping-cart/get-cities/{state_id}', 'ShoppingCartController@getCities');
Route::post('/shopping-cart/save-purchase', 'ShoppingCartController@savePurchase');
Route::get('/shopping-cart/clear', 'ShoppingCartController@clearShoppingCart');
Route::get('/shopping-cart/discount-code/search/{code}', 'ShoppingCartController@searchDiscountCode');
Route::get('/shopping-cart/discount-code/clear/', 'ShoppingCartController@clearDiscountCode');
Route::put('/shopping-cart/updateQty', 'ShoppingCartController@updateCartQty');
Route::put('/shopping-cart/delete-item', 'ShoppingCartController@deleteItem');
Route::get('/payment/check-loggedin-customer', 'ShoppingCartController@checkLoggedInCustomer');
#Payment
Route::get('/payment/get-purchase', 'PaymentController@getPurchase');
Route::get('/payment/get-prefrence-mercado-pago', 'PaymentController@getPrefrenceMercadoPago');

#--------------------------------------------------------------------------------------------------------------------
#LINKS PAYPAL
// Post payment details for store/process API request

/* LIGAS PAYPAL ANTERIORES 2023
Route::post('/payment/paypal', 'PaypalController@store');
Route::post('/payment/paypal/generate', 'PaypalController@paymentPayPal');
Route::get('/payment/paypal/status', 'PaypalController@getPaymentStatus');
*/
Route::get('/shopping-cart/payment-success', 'ShoppingCartController@paymentSuccessGral')->name('payment.success');
Route::get('/shopping-cart/payment-finish', 'ShoppingCartController@paymentFinishGral');

#--------------------------------------------------------------------------------------------------------------------
#LINKS MERCADO PAGO
Route::post('/payment/mercadopago/preorder', 'MercadoPagoController@payment');
Route::get('/payment/mercadopago/success/{token}', 'MercadoPagoController@success');
Route::get('/payment/mercadopago/failure/{token}', 'MercadoPagoController@failure');
Route::get('/payment/mercadopago/ending/{token}', 'MercadoPagoController@ending');


Auth::routes();
#--------------------------------------------------------------------------------------------------------------------
#Pages Web Public Tiendas Dinamiccas
	Route::get('/shop/{shop_slug}', 'ShopsWebPagesController@index')->name('shops.index');
	Route::get('/shop/{shop_slug}/store', 'ShopsWebPagesController@store')->name('shops.store');
	Route::get('/shop/{shop_slug}/about', 'ShopsWebPagesController@about')->name('shops.about');
	Route::get('/shop/{shop_slug}/services', 'ShopsWebPagesController@services')->name('shops.services');
	Route::get('/shop/{shop_slug}/downloads', 'ShopsWebPagesController@downloads')->name('shops.downloads');

	//Tenemos una ruta para buscar por ID y otra por SLug
	Route::get('/shop/{shop_slug}/category/{category_id}',    'ShopsWebPagesController@category')->name('shops.store.category.id');
	Route::get('/shop/{shop_slug}/categoria/{category_slug}', 'ShopsWebPagesController@categorySlug')->name('shops.store.category.slug');

	//Tenemos una ruta para buscar por ID y otra por SLug
	Route::get('/shop/{shop_slug}/product/{product_id}',    'ShopsWebPagesController@product')->name('shops.store.product.id');
	Route::get('/shop/{shop_slug}/producto/{product_slug}', 'ShopsWebPagesController@productSlug')->name('shops.store.product.slug');

#--------------------------------------------------------------------------------------------------------------------

#--------------------------------------------------------------------------------------------------------------------
#Pages Web Public EagleTek
	#Paginas de infomacion general de la pagina
	Route::get('/eagletekmexico/', 'EagletekPagesController@index')->name('eagletek.index');
	Route::get('/eagletekmexico/about', 'EagletekPagesController@about')->name('eagletek.about');
	Route::get('/eagletekmexico/services', 'EagletekPagesController@services')->name('eagletek.services');
	Route::get('/eagletekmexico/support', 'EagletekPagesController@support')->name('eagletek.support');
	Route::get('/eagletekmexico/search', 'EagletekPagesController@search')->name('eagletek.search');
	Route::get('/eagletekmexico/descargas', 'EagletekPagesController@descargas')->name('eagletek.descargas');
	Route::get('/eagletekmexico/descargas/{file}', 'EagletekPagesController@downloadFile')->name('eagletek.descargas.download.file');

	#---------------------------------------------------------------------------------------------
	#Paginas de store
	Route::get('/eagletekmexico/store', 'EagletekPagesController@store')->name('eagletekmexico.store');

	Route::get('/eagletekmexico/category/{category_id}', 'EagletekPagesController@category')->name('eagletekmexico.store.category');
	Route::get('/eagletekmexico/categoria/{slug}', 'EagletekPagesController@categorySlug')->name('eagletekmexico.store.category.slug');

	Route::get('/eagletekmexico/category/{category_id}/product/{product_id}', 'EagletekPagesController@product')->name('eagletekmexico.store.category.product');
	Route::get('/eagletekmexico/producto/{slug}', 'EagletekPagesController@productSlug')->name('eagletekmexico.store.product.slug');
	#./Paginas de store
	#---------------------------------------------------------------------------------------------

	#Shoppingcart Eagletek
	Route::get('/eagletekmexico/shopping-cart', 'ShoppingCartController@indexEagletek')->name('eagletek.shopping.cart');
	Route::get('/eagletekmexico/shopping-cart/clear', 'ShoppingCartController@clearEagletek');
	Route::get('/eagletekmexico/shopping-cart/confirm-payment', 'ShoppingCartController@confirmPaymentEagletek');
	Route::get('/eagletekmexico/shopping-cart/payment', 'ShoppingCartController@paymentEagletek');
	Route::get('/eagletekmexico/shopping-cart/payment-success', 'ShoppingCartController@paymentSuccessEagletek');
	Route::get('/eagletekmexico/shopping-cart/payment-finish', 'ShoppingCartController@paymentFinishEagletek');





#-/Pages Web Public EagleTek
#--------------------------------------------------------------------------------------------------------------------
#Pages Web Public Ziotrobotic
	Route::get('/ziotrobotik/', 'ZiotrobotikPagesController@index')->name('ziotrobotik.index');
	Route::get('/ziotrobotik/store', 'ZiotrobotikPagesController@store')->name('ziotrobotik.store');
	Route::get('/ziotrobotik/category/{category_id}', 'ZiotrobotikPagesController@category')->name('ziotrobotik.store.category');
	Route::get('/ziotrobotik/category/{category_id}/product/{product_id}', 'ZiotrobotikPagesController@product')->name('ziotrobotik.store.category.product');
	Route::get('/ziotrobotik/categoria/{slug}', 'ZiotrobotikPagesController@categorySlug')->name('ziotrobotik.store.category.slug');
	Route::get('/ziotrobotik/producto/{slug}', 'ZiotrobotikPagesController@productSlug')->name('ziotrobotik.store.product.slug');

	Route::get('/ziotrobotik/about', 'ZiotrobotikPagesController@about')->name('ziotrobotik.about');
	Route::get('/ziotrobotik/services', 'ZiotrobotikPagesController@services')->name('ziotrobotik.services');
	Route::get('/ziotrobotik/support', 'ZiotrobotikPagesController@support')->name('ziotrobotik.support');
	Route::get('/ziotrobotik/descargas', 'ZiotrobotikPagesController@descargas')->name('ziotrobotik.descargas');
	Route::get('/ziotrobotik/descargas/{file}', 'ZiotrobotikPagesController@downloadFile')->name('ziotrobotik.descargas.download.file');

	Route::get('/ziotrobotik/search', 'ZiotrobotikPagesController@search')->name('ziotrobotik.search');

	#Shoppingcart ZiotRobotik
	Route::get('/ziotrobotik/shopping-cart', 'ShoppingCartController@indexZiotrobotik')->name('ziotrobotik.shopping.cart');
	Route::get('/ziotrobotik/shopping-cart/clear', 'ShoppingCartController@clearZiotrobotik');
	Route::get('/ziotrobotik/shopping-cart/confirm-payment', 'ShoppingCartController@confirmPaymentZiotrobotik');
	Route::get('/ziotrobotik/shopping-cart/payment', 'ShoppingCartController@paymentZiotrobotik');

	Route::get('/ziotrobotik/shopping-cart/payment-success', 'ShoppingCartController@paymentSuccessZiotrobotik');
	Route::get('/ziotrobotik/shopping-cart/payment-finish', 'ShoppingCartController@paymentFinishZiotrobotik');
#-/Pages Web Public Ziotrobotic
#--------------------------------------------------------------------------------------------------------------------

#--------------------------------------------------------------------------------------------------------------------
#Pages Web Public Euderm
	Route::get('/euderm/', 'EudermPagesController@index')->name('euderm.index');
	Route::get('/euderm/store', 'EudermPagesController@store')->name('euderm.store');
	Route::get('/euderm/category/{category_id}', 'EudermPagesController@category')->name('euderm.store.category');
	Route::get('/euderm/category/{category_id}/product/{product_id}', 'EudermPagesController@product')->name('euderm.store.category.product');
	Route::get('/euderm/categoria/{slug}', 'EudermPagesController@categorySlug')->name('euderm.store.category.slug');
	Route::get('/euderm/producto/{slug}', 'EudermPagesController@productSlug')->name('euderm.store.product.slug');

	Route::get('/euderm/about', 'EudermPagesController@about')->name('euderm.about');
	Route::get('/euderm/services', 'EudermPagesController@services')->name('euderm.services');
	Route::get('/euderm/support', 'EudermPagesController@support')->name('euderm.support');
	Route::get('/euderm/descargas', 'EudermPagesController@descargas')->name('euderm.descargas');
	Route::get('/euderm/descargas/{file}', 'EudermPagesController@downloadFile')->name('euderm.descargas.download.file');

	Route::get('/euderm/search', 'EudermPagesController@search')->name('euderm.search');

	#Shoppingcart Euderm
	/* #LIGAS SHOPING CART
	Route::get('/euderm/shopping-cart', 'ShoppingCartController@indexZiotrobotik')->name('euderm.shopping.cart');
	Route::get('/euderm/shopping-cart/clear', 'ShoppingCartController@clearZiotrobotik');
	Route::get('/euderm/shopping-cart/confirm-payment', 'ShoppingCartController@confirmPaymentZiotrobotik');
	Route::get('/euderm/shopping-cart/payment', 'ShoppingCartController@paymentZiotrobotik');

	Route::get('/euderm/shopping-cart/payment-success', 'ShoppingCartController@paymentSuccessZiotrobotik');
	Route::get('/euderm/shopping-cart/payment-finish', 'ShoppingCartController@paymentFinishZiotrobotik');
	*/
#-/Pages Web Public Euderm
#--------------------------------------------------------------------------------------------------------------------

#--------------------------------------------------------------------------------------------------------------------
#Pages Web Public Roho
	Route::get('/roho/', 'RohoPagesController@index')->name('roho.index');
	Route::get('/roho/store', 'RohoPagesController@store')->name('roho.store');
	Route::get('/roho/category/{category_id}', 'RohoPagesController@category')->name('roho.store.category');
	Route::get('/roho/category/{category_id}/product/{product_id}', 'RohoPagesController@product')->name('roho.store.category.product');
	Route::get('/roho/categoria/{slug}', 'RohoPagesController@categorySlug')->name('roho.store.category.slug');
	Route::get('/roho/producto/{slug}', 'RohoPagesController@productSlug')->name('roho.store.product.slug');

	Route::get('/roho/about', 'RohoPagesController@about')->name('roho.about');
	Route::get('/roho/services', 'RohoPagesController@services')->name('roho.services');
	Route::get('/roho/support', 'RohoPagesController@support')->name('roho.support');
	Route::get('/roho/descargas', 'RohoPagesController@descargas')->name('roho.descargas');
	Route::get('/roho/descargas/{file}', 'RohoPagesController@downloadFile')->name('roho.descargas.download.file');

	Route::get('/roho/search', 'RohoPagesController@search')->name('roho.search');

	#Shoppingcart Roho
	/* #LIGAS SHOPING CART
	Route::get('/roho/shopping-cart', 'ShoppingCartController@indexZiotrobotik')->name('euderm.shopping.cart');
	Route::get('/roho/shopping-cart/clear', 'ShoppingCartController@clearZiotrobotik');
	Route::get('/roho/shopping-cart/confirm-payment', 'ShoppingCartController@confirmPaymentZiotrobotik');
	Route::get('/roho/shopping-cart/payment', 'ShoppingCartController@paymentZiotrobotik');

	Route::get('/roho/shopping-cart/payment-success', 'ShoppingCartController@paymentSuccessZiotrobotik');
	Route::get('/roho/shopping-cart/payment-finish', 'ShoppingCartController@paymentFinishZiotrobotik');
	*/
#-/Pages Web Public Roho
#--------------------------------------------------------------------------------------------------------------------

#--------------------------------------------------------------------------------------------------------------------
#Pages Web Public Otras
	Route::get('/otras/', 'OtrasPagesController@index')->name('otras.index');
	Route::get('/otras/store', 'OtrasPagesController@store')->name('otras.store');
	Route::get('/otras/category/{category_id}', 'OtrasPagesController@category')->name('otras.store.category');
	Route::get('/otras/category/{category_id}/product/{product_id}', 'OtrasPagesController@product')->name('otras.store.category.product');
	Route::get('/otras/categoria/{slug}', 'OtrasPagesController@categorySlug')->name('otras.store.category.slug');
	Route::get('/otras/producto/{slug}', 'OtrasPagesController@productSlug')->name('otras.store.product.slug');

	Route::get('/otras/about', 'OtrasPagesController@about')->name('otras.about');
	Route::get('/otras/services', 'OtrasPagesController@services')->name('otras.services');
	Route::get('/otras/support', 'OtrasPagesController@support')->name('otras.support');
	Route::get('/otras/descargas', 'OtrasPagesController@descargas')->name('otras.descargas');
	Route::get('/otras/descargas/{file}', 'OtrasPagesController@downloadFile')->name('otras.descargas.download.file');

	Route::get('/otras/search', 'OtrasPagesController@search')->name('otras.search');

	#Shoppingcart Otras
	/* #LIGAS SHOPING CART
	Route::get('/otras/shopping-cart', 'ShoppingCartController@indexZiotrobotik')->name('euderm.shopping.cart');
	Route::get('/otras/shopping-cart/clear', 'ShoppingCartController@clearZiotrobotik');
	Route::get('/otras/shopping-cart/confirm-payment', 'ShoppingCartController@confirmPaymentZiotrobotik');
	Route::get('/otras/shopping-cart/payment', 'ShoppingCartController@paymentZiotrobotik');

	Route::get('/otras/shopping-cart/payment-success', 'ShoppingCartController@paymentSuccessZiotrobotik');
	Route::get('/otras/shopping-cart/payment-finish', 'ShoppingCartController@paymentFinishZiotrobotik');
	*/
#-/Pages Web Public Otras
#--------------------------------------------------------------------------------------------------------------------



#Pages Web Public EagleTek
	#Paginas de infomacion general de la pagina
	Route::get('/solartekmexico/', 'SolartekPagesController@index')->name('solartek.index');
	Route::get('/solartekmexico/about', 'SolartekPagesController@about')->name('solartek.about');
	Route::get('/solartekmexico/services', 'SolartekPagesController@services')->name('solartek.services');
	Route::get('/solartekmexico/support', 'SolartekPagesController@support')->name('solartek.support');
	Route::get('/solartekmexico/search', 'SolartekPagesController@search')->name('solartek.search');
	Route::get('/solartekmexico/descargas', 'SolartekPagesController@descargas')->name('solartek.descargas');
	Route::get('/solartekmexico/descargas/{file}', 'SolartekPagesController@downloadFile')->name('solartek.descargas.download.file');

	#Paginas de store
	Route::get('/solartekmexico/store', 'SolartekPagesController@store')->name('solartek.store');

	Route::get('/solartekmexico/category/{category_id}', 'SolartekPagesController@category')->name('solartek.store.category');
	Route::get('/solartekmexico/categoria/{slug}', 'SolartekPagesController@categorySlug')->name('solartek.store.category.slug');

	Route::get('/solartekmexico/category/{category_id}/product/{product_id}', 'SolartekPagesController@product')->name('solartek.store.category.product');
	Route::get('/solartekmexico/producto/{slug}', 'SolartekPagesController@productSlug')->name('solartek.store.product.slug');


	#Shoppingcart Eagletek
	Route::get('/solartekmexico/shopping-cart', 'ShoppingCartController@indexSolartek')->name('solartek.shopping.cart');
	Route::get('/solartekmexico/shopping-cart/clear', 'ShoppingCartController@clearEagletek');
	Route::get('/solartekmexico/shopping-cart/confirm-payment', 'ShoppingCartController@confirmPaymentEagletek');
	Route::get('/solartekmexico/shopping-cart/payment', 'ShoppingCartController@paymentEagletek');
	Route::get('/solartekmexico/shopping-cart/payment-success', 'ShoppingCartController@paymentSuccessEagletek');
	Route::get('/solartekmexico/shopping-cart/payment-finish', 'ShoppingCartController@paymentFinishEagletek');
#-/Pages Web Public EagleTek
#--------------------------------------------------------------------------------------------------------------------
#ShoppingCart POSTS
	Route::post('/shopping-cart/addToCart', 'ShoppingCartController@addToCart');
	Route::post('/shopping-cart/new-add-to-cart', 'ShoppingCartController@newAddToCart');
	Route::post('/shopping-cart/change-show-tax', 'ShoppingCartController@changeShowTax');
	Route::post('/shopping-cart/get-discount-code', 'ShoppingCartController@getDiscountCode');
	Route::post('/shopping-cart/save-datos-comprador', 'ShoppingCartController@saveDatosComprador');
	Route::post('/shopping-cart/save-compra', 'ShoppingCartController@saveCompra');

	Route::post('/eagletekmexico/updateQtyCart', 'ShoppingCartController@updateCartQtyEagletek');
	Route::post('/eagletekmexico/deleteToCart', 'ShoppingCartController@deleteToCartEagletek');

	Route::post('/ziotrobotik/updateQtyCart', 'ShoppingCartController@updateCartQtyZiotrobotik');
	Route::post('/ziotrobotik/deleteToCart', 'ShoppingCartController@deleteToCartZiotrobotik');

#--------------------------------------------------------------------------------------------------------------------

Route::post('/product/questions/create', 'ProductQuestionsController@store');


#--------------------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth'], function () {
	//Se supone que para entrar a esta ruta hay una session activa
	Route::get('/shopping-cart/check-customer-information/{name_shop}', 'ShoppingCartController@checkAuthCustomer')->name('shoppincart.check.customer');

	Route::get('/customer/','CustomerAdminPagesController@index');


	Route::get('/customer/messages/','CustomerAdminPagesController@messages');

	Route::get('/customer/messages/get/{user_id}','MessageController@getUserMessages');
	Route::post('/customer/message/add','MessageController@store');

	//--------------------------------------------------------------------------------------------------
	//DASHBOARD DEL CUSTOMER
	Route::get('/customer/my-contact-information/','CustomerAdminPagesController@contactInformation');
	Route::get('/customer/my-contact-information/get','CustomerAdminPagesController@contactInformationGet');

	Route::put('/customer/my-contact-information/update', 'CustomersController@updateCustomerInfo');
	Route::put('/customer/my-contact-information/update-password', 'CustomersController@updateCustomerPassword');
	//--------------------------------------------------------------------------------------------------

	Route::get('/customer/courses','CustomerAdminPagesController@courses');
	Route::get('/customer/courses/course/{course_id}','CustomerAdminPagesController@course')->name('customer.course');

	Route::get('/customer/purchases','CustomerAdminPagesController@purchases');
	Route::get('/customer/purchases/view/{purchase_id}','CustomerAdminPagesController@purchaseView')->name('customer.purchase.view');

	Route::get('/customer/purchases/reload-shopping-cart/{purchase_id}','CustomerAdminPagesController@purchasesReloadShoppingCart')->name('customer.reload.shoppincart');



	Route::get('dashboard/users/scripts', 'ScriptsController@usersIndex');
	Route::get('dashboard/users/scripts/show/{script_id}', 'ScriptsController@usersShowScript')->name('users.scripts.show');

	#Panel Administracion
	Route::get('/dashboard', 'HomeController@index')->name('home');

	#PANEL VENDEDORES
	Route::get('/vendedores/tabla-porcentajes', 'SellerController@showTablaProcentajes');
	Route::get('/vendedores/ventas', 'SellerController@ventas');


	#--------------------------------------------------------------------------------------------------------------
	#AFILIADOS
	Route::get('/dashboard/afiliados', 'AfiliadosController@index');

	Route::get('/dashboard/afiliados/porcentajes-comisiones/', 'AfiliadosController@indexPorcentajesComisiones');

	//sellers
	Route::get('/dashboard/afiliados/sellers/', 'SellerController@index');
	Route::get('/dashboard/afiliados/sellers/add', 'SellerController@add')->name('seller.add');
	Route::get('/dashboard/afiliados/sellers/view/{seller_id}', 'SellerController@view')->name('seller.view');
	Route::get('/dashboard/afiliados/sellers/edit/{seller_id}', 'SellerController@edit')->name('seller.edit');
	Route::get('/dashboard/afiliados/sellers/edit/status/{seller_id}', 'SellerController@editStatus')->name('seller.edit.status');
	Route::get('/dashboard/afiliados/sellers/user/{seller_id}', 'SellerController@sysUser')->name('seller.sysuser');

	Route::post('/seller/user/create', 'SellerController@createUser')->middleware('auth');
	Route::post('/seller/create', 'SellerController@create')->middleware('auth');
	Route::post('/seller/update', 'SellerController@update')->middleware('auth');
	Route::post('/seller/update/status', 'SellerController@updateStatus')->middleware('auth');

	//codigos de decuento
	Route::get('/dashboard/afiliados/discount-codes/', 'DiscountCodesController@index');
	Route::get('/dashboard/afiliados/discount-codes/add', 'DiscountCodesController@add');
	Route::get('/dashboard/afiliados/discount-codes/remove/{code_id}', 'DiscountCodesController@remove')->name('discoount_code.remove');
	Route::get('/dashboard/afiliados/discount-codes/edit/estatus/{code_id}', 'DiscountCodesController@editEstatus')->name('discoount_code.edit.status');

	Route::post('/discount-code/create', 'DiscountCodesController@create')->middleware('auth');
	Route::post('/discount-code/delete', 'DiscountCodesController@delete')->middleware('auth');
	Route::post('/discount-code/update/status', 'DiscountCodesController@updateStatus')->middleware('auth');

	#--------------------------------------------------------------------------------------------------------------
	#QUESTIONS
	Route::get('/dashboard/questions', 'ProductQuestionsController@indexQuestions')->name('ntf.questions');
	Route::get('/questions/get', 'ProductQuestionsController@getQuestions');

	Route::post('/questions/answer/add', 'ProductQuestionsController@storeAnswer');
	Route::put('/questions/answer/delete', 'ProductQuestionsController@deleteQuestionNew');

	#MSGS CUSTOMER
	Route::get('/dashboard/messages-customer', 'MessageController@indexAdminMessagesCustomer')->name('ntf.messages.customer');

	#CUSTOMERS NEW VUE AXIOS
	Route::get('/dashboard/customers', 'CustomersController@indexCustomers')->name('ntf.customers');
	Route::get('/customers/get', 'CustomersController@getCustomers');

	#--------------------------------------------------------------------------------------------------------------
	#SCRIPTS
	Route::get('/dashboard/scripts', 'ScriptsController@index');
	Route::get('/dashboard/scripts/add', 'ScriptsController@add')->name('scripts.add');
	Route::get('/dashboard/scripts/view/{script_id}', 'ScriptsController@view')->name('scripts.view');
	Route::get('/dashboard/scripts/edit/{script_id}', 'ScriptsController@edit')->name('scripts.edit');
	Route::get('/dashboard/scripts/remove/{script_id}', 'ScriptsController@remove')->name('scripts.remove');

	Route::post('/scripts/create', 'ScriptsController@create')->middleware('auth');
	Route::post('/scripts/update', 'ScriptsController@update')->middleware('auth');
	Route::post('/scripts/delete', 'ScriptsController@delete')->middleware('auth');

	#--------------------------------------------------------------------------------------------------------------

	Route::get('/admin/stores/add', 'ShopsController@add')->name('stores.add');
	Route::post('/admin/stores/create', 'ShopsController@create')->middleware('auth');


	#LINKS ADMIN
	Route::get('/dashboard/store/{id}', 'ShopsController@index')->name('store.index');

	#----------------------------------------------------------------------------------------------------------
	#lINKS PROVEEDORES
	Route::get('/dashboard/store/{shop_id}/proveedores', 'ProveedoresController@index' )->name('dashboard.store.proveedores.index');
	Route::get('/dashboard/store/{shop_id}/proveedores/view/{proveedor_id}', 'ProveedoresController@view')->name('proveedores.view');
	Route::get('/dashboard/store/{shop_id}/proveedores/edit/{proveedor_id}', 'ProveedoresController@edit')->name('proveedores.edit');
	Route::get('/dashboard/store/{shop_id}/proveedores/edit/estatus/{proveedor_id}', 'ProveedoresController@editStatus')->name('proveedores.edit.status');
	Route::get('/dashboard/store/{shop_id}/proveedores/add', 'ProveedoresController@add')->name('proveedores.add');
	Route::get('/dashboard/store/{shop_id}/proveedores/remove/{proveedor_id}', 'ProveedoresController@remove')->name('proveedores.remove');

	#POSTS PROVEEDORES
	Route::post('/proveedores/create', 'ProveedoresController@create')->middleware('auth');
	Route::post('/proveedores/update', 'ProveedoresController@update')->middleware('auth');
	Route::post('/proveedores/update/status', 'ProveedoresController@updateStatus')->middleware('auth');
	Route::post('/proveedores/delete', 'ProveedoresController@delete')->middleware('auth');

	#----------------------------------------------------------------------------------------------------------
	#LINKS CATEGORIAS
	Route::get('/dashboard/store/{shop_id}/categories', 'CategoriesController@index' )->name('dashboard.store.categories.index');
	Route::get('/dashboard/categories/add/{shop_id}', 'CategoriesController@add')->name('categories.add');
	Route::get('/dashboard/categories/slugs/{shop_id}', 'CategoriesController@adminSlugs')->name('categories.slugs');
	Route::get('/dashboard/categories/view/{category_id}', 'CategoriesController@view')->name('categories.view');
	Route::get('/dashboard/categories/edit/{category_id}', 'CategoriesController@edit')->name('categories.edit');
	Route::get('/dashboard/categories/image/{category_id}', 'CategoriesController@image')->name('categories.image');
	Route::get('/dashboard/categories/edit/estatus/{category_id}', 'CategoriesController@editStatus')->name('categories.edit.status');
	Route::get('/dashboard/categories/remove/{category_id}', 'CategoriesController@remove')->name('categories.remove');
	Route::get('/dashboard/categories/order-by/{shop_id}', 'CategoriesController@adminOrderBy')->name('categories.order_by');


	#POSTS CATEGORIAS
	Route::post('/categories/create/{shop_id}', 'CategoriesController@create')->name('categories.create')->middleware('auth');
	Route::post('/categories/update', 'CategoriesController@update')->name('categories.update')->middleware('auth');
	Route::post('/categories/update/status', 'CategoriesController@updateStatus')->name('categories.update.status')->middleware('auth');
	Route::post('/categories/delete', 'CategoriesController@delete')->name('categories.delete')->middleware('auth');
	Route::post('/categories/update/main_image', 'CategoriesController@updateMainImage')->middleware('auth');

	Route::post('/categories/slug/update', 'CategoriesController@updateSlug')->middleware('auth');
	Route::post('/categories/order-by/update', 'CategoriesController@updateOrderBy')->middleware('auth');

	#----------------------------------------------------------------------------------------------------------
	#LINKS CURSOS
	Route::get('/dashboard/store/{shop_id}/courses', 'CourseController@index' )->name('dashboard.store.courses.index');

	//BEGIN LINKS COMPONENT VUE
	Route::get('/admin/shop/courses-get/{shop_id}', 'CourseController@getShopCourses' );
	Route::post('/admin/course/store', 'CourseController@store');
	Route::put('/admin/course/update', 'CourseController@update');
	Route::put('/admin/course/active', 'CourseController@active');
	Route::put('/admin/course/deactive', 'CourseController@deactive');
	Route::put('/admin/course/delete', 'CourseController@delete');

	Route::get('/admin/shop/course/videos-get/{course_id}', 'CourseVideoController@getCourseVideos' );

	Route::get('/admin/course/video/get-url/{video_id}', 'CourseVideoController@getUrlVideo' );

	Route::post('/admin/course/video/store', 'CourseVideoController@store');
	Route::put('/admin/course/video/update-info', 'CourseVideoController@updateInfo');
	Route::put('/admin/course/video/active', 'CourseVideoController@active');
	Route::put('/admin/course/video/deactive', 'CourseVideoController@deactive');
	Route::put('/admin/course/video/delete', 'CourseVideoController@delete');
	Route::put('/admin/course/video/update-order', 'CourseVideoController@updateOrder');

	//.END LINKS COMPONENT VUE

	Route::get('/dashboard/store/{shop_id}/course/{course_id}', 'CourseController@adminCourse' )->name('dashboard.store.course.admin');
	Route::post('/dashboard/store/course/video', 'CourseController@storeVideo' )->name('dashboard.store.course.store_video');
	Route::delete('/dashboard/store/course/video/delete', 'CourseController@destroyVideo')->name('dashboard.store.course.destroy_video');

	Route::post('/dashboard/customer-course/store', 'CustomerCourseController@store' )->name('customer.course.store');

	#----------------------------------------------------------------------------------------------------------
	#LINKS PRODUCTS
	Route::get('/products/get-products/{category_id}/', 'ProductsController@getProducts');
	Route::get('/products/get-categories-shop/{shop_id}/', 'ProductsController@getCategoriesShop');
	Route::get('/products/get-courses-shop/{shop_id}/', 'ProductsController@getCoursesShop');
	Route::get('/products/get-datos-shop/{shop_id}/', 'ProductsController@getDatosShop');

	Route::get('/dashboard/store/{shop_id}/products', 'ProductsController@index' )->name('dashboard.store.products.index');
	Route::get('/dashboard/store/{shop_id}/products/view/{product_id}', 'ProductsController@view')->name('products.view');
	Route::get('/dashboard/store/{shop_id}/products/add', 'ProductsController@add')->name('products.add');
	Route::get('/dashboard/store/{shop_id}/products/slugs', 'ProductsController@adminSlugs')->name('products.slugs');
	Route::get('/dashboard/store/{shop_id}/products/order-by', 'ProductsController@adminOrderBy')->name('products.order_by');
	Route::get('/dashboard/store/{shop_id}/products/barcodes', 'ProductsController@adminBarcodes')->name('products.barcodes');
	Route::get('/dashboard/store/{shop_id}/products/images/{product_id}', 'ProductsController@images')->name('products.images');
	Route::get('/dashboard/store/{shop_id}/products/edit/{product_id}', 'ProductsController@edit')->name('products.edit');
	Route::get('/dashboard/store/{shop_id}/products/edit/estatus/{product_id}', 'ProductsController@editStatus')->name('products.edit.status');
	Route::get('/dashboard/store/{shop_id}/products/edit/limit-web/{product_id}', 'ProductsController@editLimitWeb')->name('products.edit.limit-web');
	Route::get('/dashboard/store/{shop_id}/products/remove/{product_id}', 'ProductsController@remove')->name('products.remove');
	Route::get('/dashboard/store/products/search', 'ProductsController@search')->name('products.search');
	Route::get('/dashboard/store/{shop_id}/products/search/clear', 'ProductsController@searchClear')->name('products.search.clear');

	#ROUTES VUE/AXIOS
	Route::get('/admin/products/get/{product_id}', 'ProductsController@getDataProduct');

	Route::post('/admin/products/get/slug-to-product', 'ProductsController@getGenerateSlugToProduct');

	Route::put('/admin/products/update-code-fact', 'ProductsController@updateCodeFactProduct');
	Route::put('/admin/products/update-qty-sold', 'ProductsController@updateQtySoldProduct');
	Route::put('/admin/products/update-category', 'ProductsController@updateCategoryProduct');
	Route::put('/admin/products/update-course', 'ProductsController@updateCourseProduct');
	Route::put('/admin/products/update-datos', 'ProductsController@updateDatosProduct');
	Route::put('/admin/products/update-costos', 'ProductsController@updateCostosProduct');
	Route::put('/admin/products/update-slug', 'ProductsController@updateSlugProduct');
	Route::put('/admin/products/update-barcode', 'ProductsController@updateBarcodeProduct');
	Route::put('/admin/products/update-stars', 'ProductsController@updateStarsProduct');
	Route::put('/admin/products/desactivar', 'ProductsController@updateDesactivarProducto');
	Route::put('/admin/products/activar', 'ProductsController@updateActivarProducto');
	Route::put('/admin/products/eliminar', 'ProductsController@updateEliminarProducto');

	Route::put('/admin/products/destacar', 'ProductsController@updateDestacarProducto');
	Route::put('/admin/products/nodestacar', 'ProductsController@updateNoDestacarProducto');

	Route::post('/admin/products/update-main-images', 'ProductsController@updateMainImageAxios');



	#POSTS PRODUCTS
	Route::post('/products/create', 'ProductsController@create')->middleware('auth');
	Route::post('/products/update/main_image', 'ProductsController@updateMainImage')->middleware('auth');
	Route::post('/products/add/image', 'ProductsController@addImageProduct')->middleware('auth');
	Route::post('/products/delete/image', 'ProductsController@deleteImageProduct')->middleware('auth');
	Route::post('/products/select_category','ProductsController@select_category');
	Route::post('/products/update','ProductsController@update');

	Route::post('/products/update/stars','ProductsController@updateStars');
	Route::post('/products/update/status', 'ProductsController@updateStatus')->name('products.update.status')->middleware('auth');
	Route::post('/products/update/sales-limit-web', 'ProductsController@updateSalesLimitWeb')->name('products.update.sales-limit-web')->middleware('auth');

	Route::post('/products/delete', 'ProductsController@delete')->name('products.delete')->middleware('auth');
	Route::post('/products/slug/update', 'ProductsController@updateSlug')->middleware('auth');
	Route::post('/products/barcode/update', 'ProductsController@updateBarcode')->middleware('auth');
	Route::post('/products/order-by/update', 'ProductsController@updateOrderBy')->middleware('auth');
	#----------------------------------------------------------------------------------------------------------
	#LINKS INVENTORIES PRODUCTS
	Route::get('/dashboard/store/{shop_id}/products/inventories/{product_id}', 'InventoriesProductController@index')->name('products.inventories.index');
	Route::get('/dashboard/store/{shop_id}/products/inventories/{product_id}/add', 'InventoriesProductController@add')->name('products.inventories.add');
	Route::get('/dashboard/store/{shop_id}/products/inventories/{product_id}/edit/{inventory_id}', 'InventoriesProductController@edit')->name('products.inventories.edit');

	#POSTS INVENTORIES PRODUCTS
	Route::post('/products/inventories/create', 'InventoriesProductController@store')->middleware('auth');
	Route::post('/products/inventories/update', 'InventoriesProductController@update')->middleware('auth');

	#LINKS AXIOS

	Route::get('/inventories/get/{product_id}', 'InventoriesProductController@getInventoryProduct');
	Route::post('/inventories/store-exhibition', 'InventoriesProductController@storeExhibition');
	Route::put('/inventories/update-exhibition', 'InventoriesProductController@updateExhibition');

	#----------------------------------------------------------------------------------------------------------
	#LINKS SALES
	Route::get('/dashboard/store/{shop_id}/sales', 'SalesController@index' )->name('dashboard.store.sales.index');
	Route::get('/dashboard/store/{shop_id}/sales/view/{sale_id}', 'SalesController@view_sale' )->name('dashboard.store.sales.view');
	Route::get('/dashboard/store/{shop_id}/sales/chat/{sale_id}', 'SalesController@chat' )->name('dashboard.store.sales.chat');
	Route::get('/dashboard/store/{shop_id}/sales/edit/tracking/{sale_id}', 'SalesController@editTracking' )->name('dashboard.store.sales.edit.tracking');
	Route::get('/dashboard/store/{shop_id}/sales/edit/status/{sale_id}', 'SalesController@editStatus' )->name('dashboard.store.sales.edit.status');
	Route::get('/dashboard/store/{shop_id}/sales/edit/{sale_id}', 'SalesController@editSale' )->name('dashboard.store.sales.edit');

	Route::post('/sales/update/status', 'SalesController@updateStatus')->middleware('auth');
	Route::post('/sales/update/tracking', 'SalesController@updateTracking')->middleware('auth');

	Route::post('/sales/remove/shipping', 'SalesController@removeShipping')->middleware('auth');
	Route::post('/sales/restore/shipping', 'SalesController@restoreShipping')->middleware('auth');

	Route::post('/sales/update/total', 'SalesController@updateTotalSale')->middleware('auth');


	Route::post('/sales/select-filter-status', 'SalesController@selectFilterStatus');
	Route::post('/sales/select-filter-search', 'SalesController@selectFilterSearch');


	#----------------------------------------------------------------------------------------------------------

	#----------------------------------------------------------------------------------------------------------
	#CONFIGS

	Route::get('/dashboard/store/{shop_id}/configurations/information', 'ConfigurationsStoreController@editInformation' )->name('dashboard.store.configurations.information');

	Route::get('/dashboard/store/{shop_id}/configurations/actualizar', 'ConfigurationsStoreController@editShipping' )->name('dashboard.store.configurations.shipping');

	Route::post('/configurations/update', 'ConfigurationsStoreController@updateShipping')->middleware('auth');
	Route::post('/configurations/shop-information/update', 'ConfigurationsStoreController@updateShopInformation')->middleware('auth');

	#----------------------------------------------------------------------------------------------------------
	#PREGUNTAS
	Route::get('/dashboard/store/{shop_id}/preguntas', 'ProductQuestionsController@index' )->name('dashboard.store.preguntas.index');

	Route::get('/preguntas/delete/{id}', 'ProductQuestionsController@deleteQuestion')->name('questions.delete');
	Route::post('/preguntas/answers/add', 'ProductQuestionsController@addAnswer');

	#----------------------------------------------------------------------------------------------------------
	#CONTENIDO WEB TIENDA

	//Descargas GET
	Route::get('/dashboard/store/{shop_id}/web/descargas/status/{file_id}', 'WebContentController@updateStatus' )->name('dashboard.store.web.descargas.status');
	Route::get('/dashboard/store/{shop_id}/web/descargas/remove/{file_id}', 'WebContentController@remove' )->name('dashboard.store.web.descargas.remove');
	Route::get('/download/web-descargas/{file}', 'WebContentController@download')->name('descargas.download_file');
	//Descragas POST
	Route::post('/web_content/upload', 'WebContentController@upload')->middleware('auth');
	Route::post('/web_content/delete-file', 'WebContentController@deleteFile')->middleware('auth');

	//Content WEB - wysiwyg GET
	Route::get('/dashboard/store/{shop_id}/web/descargas', 'WebContentController@descargas' )->name('dashboard.store.web.descargas');
	Route::get('/dashboard/store/{shop_id}/web/ubout-us', 'WebContentController@aboutUs' )->name('dashboard.store.web.about_us');
	Route::get('/dashboard/store/{shop_id}/web/services', 'WebContentController@services' )->name('dashboard.store.web.services');
	//Content WEB - wysiwyg POST
	Route::post('/web_content/update-about-us', 'WebContentController@updateAboutUs')->middleware('auth');
	Route::post('/web_content/update-services', 'WebContentController@updateServices')->middleware('auth');

	//Images Carousel GET
	Route::get('/dashboard/store/{shop_id}/web/images-carousel', 'WebContentController@imagesCarouselIndex' )->name('dashboard.store.web.images_carousel');
	Route::get('/dashboard/store/{shop_id}/web/images-carousel/add', 'WebContentController@imagesCarouselAdd' )->name('dashboard.store.web.images_carousel.add');
	Route::get('/dashboard/store/{shop_id}/web/images-carousel/edit/{item_id}', 'WebContentController@imagesCarouselEdit' )->name('dashboard.store.web.images_carousel.edit');
	Route::get('/dashboard/store/{shop_id}/web/images-carousel/remove/{item_id}', 'WebContentController@imagesCarouselRemove' )->name('dashboard.store.web.images_carousel.remove');


	//Images Carousel POST

	Route::post('/web_content/images-carousel-create', 'WebContentController@createImageCarousel')->middleware('auth');
	Route::post('/web_content/images-carousel-update', 'WebContentController@updateImageCarousel')->middleware('auth');
	Route::post('/web_content/images-carousel-delete', 'WebContentController@deleteImageCarousel')->middleware('auth');

	Route::get('/dashboard/store/{shop_id}/web/promotional-banner', 'WebContentController@imagePromotionalBanner' )->name('dashboard.store.web.promotional-banner');

	Route::post('/web_content/images-carousel/update-order', 'WebContentController@updateOrderImageCarousel')->name('images-carousel.update-order');


	Route::post('/web_content/upload-banner-promotional', 'WebContentController@uploadBannerPromotional')->name('shop.web_content.upload_banner_promotional')->middleware('auth');

	Route::post('/web_content/delete-banner-promotional', 'WebContentController@deleteBannerPromotional')->name('shop.web_content.delete_banner_promotional')->middleware('auth');

	Route::get('/dashboard/store/{shop_id}/web/seccion-descripcion', 'WebContentController@seccionDescripcion' )->name('dashboard.store.web.seccion-descripcion');
	Route::get('/dashboard/store/{shop_id}/web/productos-destacados', 'WebContentController@productosDestacados' )->name('dashboard.store.web.productos-destacados');
	Route::get('/dashboard/store/{shop_id}/web/productos-nuevos', 'WebContentController@productosNuevos' )->name('dashboard.store.web.productos-nuevos');

	Route::post('/web_content/update-seccion-descripcion', 'WebContentController@updateSeccionDescripcion')->name('shop.web_content.update-seccion-descripcion')->middleware('auth');
	Route::post('/web_content/update-productos-destacados', 'WebContentController@updateProductosDestacados')->name('shop.web_content.update-productos-destacados')->middleware('auth');
	Route::post('/web_content/update-productos-nuevos', 'WebContentController@updateProductosNuevos')->name('shop.web_content.update-productos-nuevos')->middleware('auth');

	#----------------------------------------------------------------------------------------------------------
	#lINKS CUSTOMERS

	Route::get('/dashboard/store/{shop_id}/customers', 'CustomersController@index' )->name('dashboard.store.customers.index');


	Route::get('/dashboard/store/{shop_id}/customers/{customer_id}/purchases', 'CustomersController@purchases' )->name('dashboard.store.customers.purchases');

	//Este update era el 1o y poddia venir de Admin o de Custumer
	Route::post('/customers/update', 'CustomersController@update')->name('customers.update');

	Route::put('/admin/customers/update', 'CustomersController@updateAdminCustomer');
	Route::put('/admin/customers/delete', 'CustomersController@delete');
	Route::put('/admin/customers/read-ntf', 'CustomersController@readNtf');

	#links routes axios vue
	Route::get('/get/shop-customers/{shop_id}', 'CustomersController@getShopCustomers');


	#----------------------------------------------------------------------------------------------------------
	#lINKS CONFIGURATIONS
	Route::get('/dashboard/global-configurations', 'GlobalConfigurationsController@index' )->name('global-configurations.index');

	#--------Statuses PO
	Route::get('/dashboard/global-configurations/statuses-purchase-order', 'GlobalConfigurationsController@statusesPurchaseOrder' )->name('global-configurations.statuses_po');
	Route::get('/dashboard/global-configurations/statuses-purchase-order/create', 'GlobalConfigurationsController@statusesPurchaseOrderCreate' )->name('global-configurations.statuses_po.create');

	Route::post('/statuses_po/store','GlobalConfigurationsController@statusesPurchaseOrderStore' );

	#---------Dollar Price
	Route::get('/dashboard/global-configurations/dollar-price', 'GlobalConfigurationsController@dollarPrice' )->name('global-configurations.dollar_price');

	Route::get('/dollar-price/get-data', 'GlobalConfigurationsController@getDataConfigDollar');

	Route::put('/dollar-price/update-dollar-price', 'GlobalConfigurationsController@updateDollarPrice');

	Route::put('/dollar-price/update-product-retail', 'GlobalConfigurationsController@updateProductRetail');

	Route::put('/products-cost-usd/update', 'GlobalConfigurationsController@updateProductsCostUSD');

	#---------ADMIN PROJECTS
	Route::get('/dashboard/projects', 'ProjectController@index' )->name('admin.projects');
	Route::get('/dashboard/projects/get','ProjectController@getProjects' );
	Route::post('/admin/projects/store','ProjectController@store' );
	Route::put('/admin/projects/update','ProjectController@update' );
	Route::put('/admin/projects/active','ProjectController@active');
	Route::put('/admin/projects/deactive','ProjectController@deactive');
	Route::put('/admin/projects/show-home','ProjectController@showHome');
	Route::put('/admin/projects/hide-home','ProjectController@hideHome');
	Route::put('/admin/projects/delete','ProjectController@delete');
	Route::post('/admin/projects/update-main-image','ProjectController@updateMainImage');
	Route::post('/admin/projects/upload-other-image','ProjectController@uploadOtherImage');
	Route::post('/admin/projects/store-video','ProjectController@storeVideo');
	Route::put('/admin/projects/delete-video','ProjectController@deleteVideo');
	Route::get('/admin/projects/video/get-url/{project_id}', 'ProjectController@getUrlVideo' );
	Route::put('/admin/projects/delete-other-image','ProjectController@deleteOtherImage');

	#---------Shops
	Route::get('/dashboard/global-configurations/shops', 'GlobalConfigurationsController@shopsIndex' )->name('global-configurations.shops');

	Route::get('/dashboard/global-configurations/shops/{shop_id}/edit-status', 'GlobalConfigurationsController@shopsEditStatus' )->name('global-configurations.shops.edit.status');

	Route::get('/dashboard/global-configurations/shops/{shop_id}/edit-datos', 'GlobalConfigurationsController@shopsEditDatos' )->name('global-configurations.shops.edit.datos');

	Route::get('/dashboard/global-configurations/shops/{shop_id}/edit-tipo', 'GlobalConfigurationsController@shopsEditTipo' )->name('global-configurations.shops.edit.tipo');

	Route::get('/dashboard/global-configurations/shops/{shop_id}/logo', 'GlobalConfigurationsController@shopsLogo' )->name('global-configurations.shops.logo');

	Route::post('/global/shop/upload-logo','GlobalConfigurationsController@shopUploadLogo')->name('global.shop.upload.logo');
	Route::post('/global/shop/delete-logo','GlobalConfigurationsController@shopDeleteLogo')->name('global.shop.delete.logo');

	Route::post('/global/shop/update-status','GlobalConfigurationsController@shopUpdateStatus')->name('global.shop.update.status');
	Route::post('/global/shop/update-datos','GlobalConfigurationsController@shopUpdateDatos')->name('global.shop.update.datos');

	Route::post('/global/shop/update-tipo','GlobalConfigurationsController@shopUpdateTipo')->name('global.shop.update.tipo');

	#---------Config Abbaster Information
	Route::get('/dashboard/global-configurations/abbaster-information', 'GlobalConfigurationsController@abbasterInfo' )->name('global-configurations.abbaster_info');
	Route::post('/dashboard/global-configurations/abbaster-information/update', 'GlobalConfigurationsController@updateAbbasterInfo' );

	#---------Web Content
	Route::get('/dashboard/global-configurations/web-content', 'GlobalConfigurationsController@webContentIndex' )->name('global-configurations.web_content');



	#---------Web Content-Metodos Pagos
	Route::get('/dashboard/global-configurations/web-content/metodos-pagos', 'GlobalConfigurationsController@webContentMetodosPagos' )->name('global-configurations.web_content.metodos_pagos');

	Route::post('/admin/metodos-pagos/update-datos', 'GlobalConfigurationsController@updateDatosMetodosPagos' );
	Route::post('/admin/metodos-pagos/update-image', 'GlobalConfigurationsController@updateImageMetodosPagos' );

	#---------Web Content- Acceso Tiendas NAV
	Route::get('/dashboard/global-configurations/web-content/nav-acceso-tiendas', 'GlobalConfigurationsController@webContentNavAccesoTiendas' )->name('global-configurations.web_content.nav_acceso_tiendas');

	Route::post('/admin/nav-acceso-tiendas/update', 'GlobalConfigurationsController@updateNavAccesoTiendas' );

	#---------Web Content- Banner Loop
	Route::get('/dashboard/global-configurations/web-content/banner-loop', 'GlobalConfigurationsController@webContentBannerLoop' )->name('global-configurations.web_content.banner_loop');

	Route::post('/admin/banner-loop/update-datos', 'GlobalConfigurationsController@updateBannerLoopDatos');
	Route::post('/admin/banner-loop/update-image', 'GlobalConfigurationsController@updateBannerLoopImage');

	#---------Web Content- Acceso Tiendas
	Route::get('/dashboard/global-configurations/web-content/acceso-tiendas', 'GlobalConfigurationsController@webContentAccesoTiendas' )->name('global-configurations.web_content.acceso_tiendas');
	Route::post('/admin/acceso-tiendas/update', 'GlobalConfigurationsController@updateAccesoTiendas' );

	#---------Web Content- Logos Tiendas
	Route::get('/dashboard/global-configurations/web-content/logos-tiendas', 'GlobalConfigurationsController@webContentLogosTiendas' )->name('global-configurations.web_content.logos_tiendas');
	Route::post('/admin/logos-tiendas/update', 'GlobalConfigurationsController@updateLogosTiendas' );

	#---------Web Content- Destacados
	Route::get('/dashboard/global-configurations/web-content/destacados', 'GlobalConfigurationsController@webContentDestacados' )->name('global-configurations.web_content.destacados');
	Route::post('/admin/destacados/update', 'GlobalConfigurationsController@updateDestacados' );

	#---------Web Content- Testimonios
	Route::get('/dashboard/global-configurations/web-content/testimonios', 'GlobalConfigurationsController@webContentTestimonios' )->name('global-configurations.web_content.testimonios');

	Route::get('/dashboard/global-configurations/web-content/testimonios/edit-image/{testimonio_id}', 'GlobalConfigurationsController@webContentTestimoniosEditImage');

	Route::post('/testimonios/delete-image', 'GlobalConfigurationsController@deleteImageTestimonio')->name('global.testimonio.delete.image');
	Route::post('/testimonios/upload-image', 'GlobalConfigurationsController@uploadImageTestimonio')->name('global.testimonio.upload.image');



	Route::get('/admin/testimonios/get', 'GlobalConfigurationsController@getTestimonios' );
	Route::post('/admin/testimonios/add', 'GlobalConfigurationsController@storeTestimonio' );
	Route::put('/admin/testimonios/edit', 'GlobalConfigurationsController@updateTestimonio' );
	Route::put('/admin/testimonios/activar', 'GlobalConfigurationsController@activarTestimonio' );
	Route::put('/admin/testimonios/desactivar', 'GlobalConfigurationsController@desactivarTestimonio');

	Route::put('/admin/testimonios/eliminar', 'GlobalConfigurationsController@eliminarTestimonio' );

	Route::post('/admin/testimonios/update-datos-seccion', 'GlobalConfigurationsController@updateDatosSeccion' );

	#---------Web Content- Seccion
	Route::get('/dashboard/global-configurations/web-content/crece', 'GlobalConfigurationsController@webContentCrece' )->name('global-configurations.web_content.section.crece');

	Route::get('/dashboard/global-configurations/web-content/como-comprar', 'GlobalConfigurationsController@webContentComoComprar' )->name('global-configurations.web_content.section.como-comprar');

	Route::post('/web-sections/update/crece','GlobalConfigurationsController@updateWebSectionCrece');
	Route::post('/web-sections/update/como-comprar','GlobalConfigurationsController@updateWebSectionComoComprar');

	#---------Web Content-Carousel
	Route::get('/dashboard/global-configurations/web-content/carousel', 'GlobalConfigurationsController@webContentCarousel' )->name('global-configurations.web_content.carousel');



	Route::get('/dashboard/global-configurations/web-content/carousel/add', 'GlobalConfigurationsController@webContentCarouselAdd' )->name('global-configurations.web_content.carousel.add');

	Route::get('/dashboard/global-configurations/web-content/carousel/edit/{img_id}', 'GlobalConfigurationsController@webContentCarouselEdit' )->name('global-configurations.web_content.carousel.edit');

	Route::get('/dashboard/global-configurations/web-content/carousel/remove/{img_id}', 'GlobalConfigurationsController@webContentCarouselRemove' )->name('global-configurations.web_content.carousel.remove');

	Route::post('/global/web/carousel/store','GlobalConfigurationsController@webContentCarouselStore')->name('global.web.carousel.store');
	Route::post('/global/web/carousel/update','GlobalConfigurationsController@webContentCarouselUpdate')->name('global.web.carousel.update');
	Route::post('/global/web/carousel/delete','GlobalConfigurationsController@webContentCarouselDelete')->name('global.web.carousel.delete');
	Route::post('/global/web/carousel/update-order','GlobalConfigurationsController@webContentCarouselUpdateOrder')->name('global.web.carousel.update-order');

	Route::post('/global/web/carousel/update-datos','GlobalConfigurationsController@webContentCarouselUpdateDatos');

	#----------------------------------------------------------------------------------------------------------
	#lINKS PURCHASE ORDERS
	Route::get('/dashboard/purchase-orders', 'PurchaseOrdersController@index' )->name('purchase-orders.index');
	Route::get('/dashboard/purchase-orders/create', 'PurchaseOrdersController@create' )->name('purchase-orders.create');
	Route::get('/dashboard/purchase-orders/{purchase_order_id}/show', 'PurchaseOrdersController@show' )->name('purchase-orders.show');
	Route::get('/dashboard/purchase-orders/{purchase_order_id}/edit-status', 'PurchaseOrdersController@editStatus' )->name('purchase-orders.edit.status');
	Route::get('/dashboard/purchase-orders/{purchase_order_id}/edit-fecha-entrega-real', 'PurchaseOrdersController@editFechaReal' )->name('purchase-orders.edit.fecha-entrega-real');

	Route::get('/dashboard/purchase-orders/{purchase_order_id}/edit', 'PurchaseOrdersController@edit' )->name('purchase-orders.edit');

	Route::post('/purchase-orders/store','PurchaseOrdersController@store')->name('purchase-orders.store');


	Route::post('/purchase-orders/update-fecha-entrega-real','PurchaseOrdersController@updateFechaEntregaReal')->name('purchase-orders.update-fecha-entrega-real');

	Route::get('/admin/purchase-orders/{purchase_order_id}', 'PurchaseOrdersController@show');

	Route::get('/dashboard/purchase-orders/{purchase_order_id}/surtir', 'PurchaseOrdersController@surtir' )->name('purchase-orders.surtir');

	#-->OJO Route::post('/purchase-orders/update-status','PurchaseOrdersController@updateStatus')->name('purchase-orders.update-status');
	Route::put('/purchase-orders/update-status', 'PurchaseOrdersController@updateStatus');


	Route::post('/admin/purchase-order-detail/store/inventory', 'PurchaseOrdersController@storeInventory');



	#----------------------------------------------------------------------------------------------------------
	#lINKS PURCHASE ORDERS DETAIL API
	Route::get('/admin/purchase-order-detail/get-shops', 'PurchaseOrderDetailController@getShops');
	Route::get('/admin/purchase-order-detail/get-categories/{shop_id}', 'PurchaseOrderDetailController@getCategories');
	Route::get('/admin/purchase-order-detail/get-products/{_id}', 'PurchaseOrderDetailController@getProducts');

	Route::get('/admin/purchase-order-detail/info/{po_id}', 'PurchaseOrderDetailController@infoPO');

	Route::get('/admin/purchase-order-detail/{po_id}', 'PurchaseOrderDetailController@index');
	Route::get('/admin/purchase-order-detail/inventories/{po_id}', 'PurchaseOrderDetailController@getProductsAndInventories');

	//Route::post('/admin/purchase-order-detail/agregar', 'PurchaseOrderDetailController@store');
	Route::post('/admin/purchase-order-detail/store', 'PurchaseOrderDetailController@store');

	Route::put('/admin/purchase-order-detail/update-info-po', 'PurchaseOrderDetailController@updateInfoPO');

	Route::put('/admin/purchase-order-detail/update-qty', 'PurchaseOrderDetailController@updateQty');
	Route::put('/admin/purchase-order-detail/update-cost', 'PurchaseOrderDetailController@updateCost');

	Route::post('/admin/purchase-order-detail/delete-product-po', 'PurchaseOrderDetailController@deleteProductPo');

	Route::put('/admin/purchase-order-detail/actualizar', 'PurchaseOrderDetailController@update');

	Route::get('/admin/purchase-order-detail/warehouses/get', 'WarehouseController@index');

	//-------------------------------------------------------------------------------------------
	// ROUTES CEDIS
	//-------------------------------------------------------------------------------------------

	Route::get('/admin/cedis/warehouse', 'WarehouseController@index')->name('cedis.warehouse');
	Route::get('/admin/cedis/warehouse/create', 'WarehouseController@create')->name('cedis.warehouse.create');

	Route::get('/admin/cedis/operation', 'CedisOperationController@index')->name('cedis.operation');

		//ROUTES AXIOS
	Route::get('/cedis/operation/get-oc/{oc_id}', 'CedisOperationController@getOC');

	Route::get('/admin/cedis/operation/recepcion', 'CedisOperationController@recepcionIndex')->name('cedis.operation.recepcion');
	//-------------------------------------------------------------------------------------------

	Route::post('warehouse/store', 'WarehouseController@store')->name('warehouse.store');

	Route::get('/warehouse/get/{warehouse_id}', 'WarehouseController@getWarehouse');

	Route::get('/admin/cedis/warehouse/image/{warehouse_id}', 'WarehouseController@imageWarehouse');

	Route::post('/warehouse/image/delete', 'WarehouseController@deleteImage')->name('warehouse.delete.image');
	Route::post('/warehouse/image/upload', 'WarehouseController@uploadImage')->name('warehouse.upload.image');

	Route::put('/warehouse/activar', 'WarehouseController@updateActivar');
	Route::put('/warehouse/desactivar', 'WarehouseController@updateDesactivar');



	//Route::put('/admin/purchase-order-detail/update/inventory', 'PurchaseOrderDetailController@update');

	//-------------------------------------------------------------------------------------------
	// ROUTES CEDIS
	//-------------------------------------------------------------------------------------------
	Route::get('/admin/metricas', 'MetricasController@index')->name('metricas');

	Route::get('/admin/metricas/visitas/web', 'MetricasController@visitasWeb')->name('metricas.visitas.web');
	Route::get('/admin/metricas/visitas/web/range', 'MetricasController@visitasWebRange')->name('metricas.visitas.web.range');
	Route::get('/admin/metricas/visitas/web/mes', 'MetricasController@visitasWebMes')->name('metricas.visitas.web.mes');

	Route::get('/admin/metricas/visitas/product', 'MetricasController@visitasProducts')->name('metricas.visitas.products');
	Route::get('/admin/metricas/visitas/category', 'MetricasController@visitasCategories')->name('metricas.visitas.categories');
	Route::get('/admin/metricas/visitas/charts', 'MetricasController@charts')->name('metricas.charts');

	Route::get('/get/visitas-web', 'MetricasController@getVisitasWeb');
	Route::get('/get/visitas-web-range', 'MetricasController@getVisitasWebRange');
	Route::get('/get/visitas-web-mes', 'MetricasController@getVisitasWebMes');
	Route::get('/get/visitas-productos', 'MetricasController@getVisitasProductos');
	Route::get('/get/visitas-categorias', 'MetricasController@getVisitasCategorias');


	Route::get('/products-destacados/get', 'GlobalConfigurationsController@getProductsDestacados');

	Route::put('/products-destacados/update-destacar', 'GlobalConfigurationsController@updateDestacarProductoGral');
	Route::put('/products-destacados/update-no-destacar', 'GlobalConfigurationsController@updateNoDestacarProductoGral');
	Route::put('/products-destacados/update-order', 'GlobalConfigurationsController@updateDestacadosOrder');

	#ADMIN USUARIOS
	Route::get('/admin/users', 'UsersController@index')->name('users.index');
	Route::get('/admin/users/get', 'UsersController@getUsers');

	Route::post('/admin/users/store', 'UsersController@storeUser');

	Route::put('/admin/users/update-info', 'UsersController@updateUserInfo');
	Route::put('/admin/users/update-password', 'UsersController@updateUserPassword');
	Route::put('/admin/users/activar', 'UsersController@updateUserActivar');
	Route::put('/admin/users/desactivar', 'UsersController@updateUserDesactivar');
	Route::put('/admin/users/eliminar', 'UsersController@deleteUser');

	Route::get('/admin/users/register', 'UsersController@register')->name('users.register');


	#------------------------------------------------------------------------------------
	# ADMIN MESSAGES CUSTOMER
	Route::get('/admin/messages/get-users', 'MessageController@getUsersMessages');

	Route::get('/admin/messages/get-messages/{user_id}', 'MessageController@getMessagesCustomer');





});#./Route::group(['middleware' => 'auth']...