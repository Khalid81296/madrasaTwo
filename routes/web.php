<?php

use App\Http\Controllers\TeacherSalaryController;
use App\Http\Controllers\SupportTeam\ExpenseCategoryController;
use App\Http\Controllers\SupportTeam\ExpenseController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\SmsManagementController;
use App\Http\Controllers\SupportTeam\ReportController;
use App\Http\Controllers\SupportTeam\IncomeController;
use App\Http\Controllers\SupportTeam\BadrinPaymentRecordController;

Auth::routes();

//Route::get('/test', 'TestController@index')->name('test');
Route::get('/privacy-policy', 'HomeController@privacy_policy')->name('privacy_policy');
Route::get('/terms-of-use', 'HomeController@terms_of_use')->name('terms_of_use');


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@dashboard')->name('home');
    // Route::get('/home', 'HomeController@dashboard')->name('home');
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

    Route::group(['prefix' => 'my_account'], function() {
        Route::get('/', 'MyAccountController@edit_profile')->name('my_account');
        Route::put('/', 'MyAccountController@update_profile')->name('my_account.update');
        Route::put('/change_password', 'MyAccountController@change_pass')->name('my_account.change_pass');
    });


    /*************** Support Team *****************/
    Route::group(['namespace' => 'SupportTeam',], function(){

        // Expensecategories
        Route::delete('expense-categories/destroy', 'ExpenseCategoryController@massDestroy')->name('expense-categories.massDestroy');
        Route::resource('expense-categories', 'ExpenseCategoryController');
        // Expenses
        Route::delete('expenses/destroy', 'ExpenseController@massDestroy')->name('expenses.massDestroy');
        Route::resource('expenses', 'ExpenseController');
        // Incomecategories
        Route::delete('income-categories/destroy', 'IncomeCategoryController@massDestroy')->name('income-categories.massDestroy');
        Route::resource('income-categories', 'IncomeCategoryController');

        // Incomes
        Route::delete('incomes/destroy', 'IncomeController@massDestroy')->name('incomes.massDestroy');
        Route::get('/income/receipt/{id}', 'IncomeController@printList')->name('incomes.receipt');
        Route::resource('incomes', 'IncomeController');
        Route::resource('badrinPayment', 'BadrinPaymentRecordController');
        Route::get('/case/dropdownlist/getdependentbadrin', [BadrinPaymentRecordController::class , 'getDependentBadrin']);
        /*************** Students *****************/
        Route::group(['prefix' => 'students'], function(){
            Route::get('reset_pass/{st_id}', 'StudentRecordController@reset_pass')->name('st.reset_pass');
            Route::get('graduated', 'StudentRecordController@graduated')->name('students.graduated');
            Route::put('not_graduated/{id}', 'StudentRecordController@not_graduated')->name('st.not_graduated');
            Route::get('list/{class_id}', 'StudentRecordController@listByClass')->name('students.list');
            Route::delete('delete/{id}', 'StudentRecordController@delete')->name('students.delete');

            /* Promotions */
            Route::post('promote_selector', 'PromotionController@selector')->name('students.promote_selector');
            Route::get('promotion/manage', 'PromotionController@manage')->name('students.promotion_manage');
            Route::delete('promotion/reset/{pid}', 'PromotionController@reset')->name('students.promotion_reset');
            Route::delete('promotion/reset_all', 'PromotionController@reset_all')->name('students.promotion_reset_all');
            Route::get('promotion/{fc?}/{fs?}/{tc?}/{ts?}', 'PromotionController@promotion')->name('students.promotion');
            Route::post('promote/{fc}/{fs}/{tc}/{ts}', 'PromotionController@promote')->name('students.promote');

        });

        /*************** Badrins *****************/
        Route::group(['prefix' => 'badrins'], function(){
            Route::get('reset_pass/{bd_id}', 'BadrinRecordController@reset_pass')->name('bd.reset_pass');
            
            Route::get('list/{class_id}', 'BadrinRecordController@listByClass')->name('badrins.list');

            

        });

        /*************** Users *****************/
        Route::group(['prefix' => 'users'], function(){
            Route::get('reset_pass/{id}', 'UserController@reset_pass')->name('users.reset_pass');
        });

        /*************** TimeTables *****************/
        Route::group(['prefix' => 'timetables'], function(){
            Route::get('/', 'TimeTableController@index')->name('tt.index');

            Route::group(['middleware' => 'teamSA'], function() {
                Route::post('/', 'TimeTableController@store')->name('tt.store');
                Route::put('/{tt}', 'TimeTableController@update')->name('tt.update');
                Route::delete('/{tt}', 'TimeTableController@delete')->name('tt.delete');
            });

            /*************** TimeTable Records *****************/
            Route::group(['prefix' => 'records'], function(){

                Route::group(['middleware' => 'teamSA'], function(){
                    Route::get('manage/{ttr}', 'TimeTableController@manage')->name('ttr.manage');
                    Route::post('/', 'TimeTableController@store_record')->name('ttr.store');
                    Route::get('edit/{ttr}', 'TimeTableController@edit_record')->name('ttr.edit');
                    Route::put('/{ttr}', 'TimeTableController@update_record')->name('ttr.update');
                });

                Route::get('show/{ttr}', 'TimeTableController@show_record')->name('ttr.show');
                Route::get('print/{ttr}', 'TimeTableController@print_record')->name('ttr.print');
                Route::delete('/{ttr}', 'TimeTableController@delete_record')->name('ttr.destroy');

            });

            /*************** Time Slots *****************/
            Route::group(['prefix' => 'time_slots', 'middleware' => 'teamSA'], function(){
                Route::post('/', 'TimeTableController@store_time_slot')->name('ts.store');
                Route::post('/use/{ttr}', 'TimeTableController@use_time_slot')->name('ts.use');
                Route::get('edit/{ts}', 'TimeTableController@edit_time_slot')->name('ts.edit');
                Route::delete('/{ts}', 'TimeTableController@delete_time_slot')->name('ts.destroy');
                Route::put('/{ts}', 'TimeTableController@update_time_slot')->name('ts.update');
            });

        });

        /*************** Payments *****************/
        Route::group(['prefix' => 'payments'], function(){

            Route::get('manage/{class_id?}', 'PaymentController@manage')->name('payments.manage');
            Route::get('invoice/{id}/{year?}', 'PaymentController@invoice')->name('payments.invoice');
            Route::get('receipts/{id}', 'PaymentController@receipts')->name('payments.receipts');
            Route::get('singleReceipts/{id}', 'PaymentController@singleReceipts')->name('payments.singleReceipts');
            Route::get('pdf_receipts/{id}', 'PaymentController@pdf_receipts')->name('payments.pdf_receipts');
            Route::post('select_year', 'PaymentController@select_year')->name('payments.select_year');
            Route::post('select_class', 'PaymentController@select_class')->name('payments.select_class');
            Route::delete('reset_record/{id}', 'PaymentController@reset_record')->name('payments.reset_record');
            Route::post('pay_now/{id}', 'PaymentController@pay_now')->name('payments.pay_now');
            Route::post('single_pay_now/{id}', 'PaymentController@single_pay_now')->name('payments.single_pay_now');
        });

        /*************** Reports *****************/
        Route::group(['prefix' => 'report'], function(){
            Route::get('/payment', [ReportController::class, 'payment'])->name('report.payment');
            Route::get('/badrin/payment', [ReportController::class, 'badrinPayment'])->name('report.badrin.payment');
            Route::get('/monthly', [ReportController::class, 'monthlyIncExp'])->name('report.monthly');
            Route::post('/pdf', [ReportController::class, 'pdf_generate']);
            Route::post('/badrin/pdf', [ReportController::class, 'badrin_pdf_generate']);
            Route::post('/pdf/finance', [ReportController::class, 'expenceIncomeReport']);
        });

        

        /*************** Pins *****************/
        Route::group(['prefix' => 'pins'], function(){
            Route::get('create', 'PinController@create')->name('pins.create');
            Route::get('/', 'PinController@index')->name('pins.index');
            Route::post('/', 'PinController@store')->name('pins.store');
            Route::get('enter/{id}', 'PinController@enter_pin')->name('pins.enter');
            Route::post('verify/{id}', 'PinController@verify')->name('pins.verify');
            Route::delete('/', 'PinController@destroy')->name('pins.destroy');
        });

        /*************** Marks *****************/
        Route::group(['prefix' => 'marks'], function(){

           // FOR teamSA
            Route::group(['middleware' => 'teamSA'], function(){
                Route::get('batch_fix', 'MarkController@batch_fix')->name('marks.batch_fix');
                Route::put('batch_update', 'MarkController@batch_update')->name('marks.batch_update');
                Route::get('tabulation/{exam?}/{class?}/{sec_id?}', 'MarkController@tabulation')->name('marks.tabulation');
                Route::post('tabulation', 'MarkController@tabulation_select')->name('marks.tabulation_select');
                Route::get('tabulation/print/{exam}/{class}/{sec_id}', 'MarkController@print_tabulation')->name('marks.print_tabulation');
            });

            // FOR teamSAT
            Route::group(['middleware' => 'teamSAT'], function(){
                Route::get('/', 'MarkController@index')->name('marks.index');
                Route::get('manage/{exam}/{class}/{section}/{subject}', 'MarkController@manage')->name('marks.manage');
                Route::put('update/{exam}/{class}/{section}/{subject}', 'MarkController@update')->name('marks.update');
                Route::put('comment_update/{exr_id}', 'MarkController@comment_update')->name('marks.comment_update');
                Route::put('skills_update/{skill}/{exr_id}', 'MarkController@skills_update')->name('marks.skills_update');
                Route::post('selector', 'MarkController@selector')->name('marks.selector');
                Route::get('bulk/{class?}/{section?}', 'MarkController@bulk')->name('marks.bulk');
                Route::post('bulk', 'MarkController@bulk_select')->name('marks.bulk_select');
            });

            Route::get('select_year/{id}', 'MarkController@year_selector')->name('marks.year_selector');
            Route::post('select_year/{id}', 'MarkController@year_selected')->name('marks.year_select');
            Route::get('show/{id}/{year}', 'MarkController@show')->name('marks.show');
            Route::get('print/{id}/{exam_id}/{year}', 'MarkController@print_view')->name('marks.print');
            Route::get('final/print/{id}/{exam_id}/{year}', 'MarkController@final_marks_print_view')->name('finalMarks.print');

        });

        Route::resource('students', 'StudentRecordController');
        Route::resource('badrins', 'BadrinRecordController');
        Route::resource('users', 'UserController');
        Route::resource('classes', 'MyClassController');
        Route::resource('sections', 'SectionController');
        Route::resource('subjects', 'SubjectController');
        Route::resource('grades', 'GradeController');
        Route::resource('exams', 'ExamController');
        Route::resource('dorms', 'DormController');
        Route::resource('payments', 'PaymentController');

    });

    /************************ AJAX ****************************/
    Route::group(['prefix' => 'ajax'], function() {
        Route::get('get_lga/{state_id}', 'AjaxController@get_lga')->name('get_lga');
        Route::get('get_class_sections/{class_id}', 'AjaxController@get_class_sections')->name('get_class_sections');
        Route::get('get_class_subjects/{class_id}', 'AjaxController@get_class_subjects')->name('get_class_subjects');
    });

});

/************************ SUPER ADMIN ****************************/
Route::group(['namespace' => 'SuperAdmin','middleware' => 'super_admin', 'prefix' => 'super_admin'], function(){

    Route::get('/settings', 'SettingController@index')->name('settings');
    Route::put('/settings', 'SettingController@update')->name('settings.update');

});

/************************ PARENT ****************************/
Route::group(['namespace' => 'MyParent','middleware' => 'my_parent',], function(){

    Route::get('/my_children', 'MyController@children')->name('my_children');

});

//=================== Message Start ================
Route::get('/messages', [MessageController::class, 'messages'])->name('messages');
Route::get('/messages_recent', [MessageController::class, 'messages_recent'])->name('messages_recent');
Route::get('/messages_request', [MessageController::class, 'messages_request'])->name('messages_request');
Route::get('/messages/{id}', [MessageController::class, 'messages_single'])->name('messages_single');
Route::get('/messages_remove/{id}', [MessageController::class, 'messages_remove'])->name('messages_remove');
Route::post('/messages/send', [MessageController::class, 'messages_send'])->name('messages_send');
Route::get('/messages_group', [MessageController::class, 'messages_group'])->name('messages_group');
//=================== Message End ==================
Route::resource('notice', 'NoticeController');
Route::resource('sms', 'SmsManagementController');
Route::resource('payment_records', 'PaymentRecordController');
Route::resource('other_payment', 'OtherPaymentController');
Route::resource('salary', 'TeacherSalaryController');
Route::post('updateSalary/{id}', [TeacherSalaryController::class, 'updateSalary']);
Route::resource('student_assynment', 'StudentAssynmentController');
Route::resource('assynment', 'AssynmentController');
//=================== Notice Start ================
// Route::get('/notices', [NoticeController::class, 'index'])->name('notice');
// Route::get('/notice_recent', [MessageController::class, 'notice_recent'])->name('notice_recent');
// Route::get('/notice_request', [MessageController::class, 'notice_request'])->name('notice_request');
// Route::get('/notice/{id}', [MessageController::class, 'notice_single'])->name('notice_single');
// Route::get('/notice_remove/{id}', [MessageController::class, 'notice_remove'])->name('notice_remove');
// Route::post('/notice/send', [MessageController::class, 'notice_send'])->name('notice_send');
// Route::get('/notice_group', [MessageController::class, 'notice_group'])->name('notice_group');
// //=================== Notice End ==================
