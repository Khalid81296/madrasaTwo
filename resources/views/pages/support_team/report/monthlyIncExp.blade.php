@extends('layouts.master')
@section('page_title', 'Payment Report')
@section('content')

    <div class="row">

       <div class="col-md-12">
          <!--begin::Card-->
          <div class="card card-custom gutter-b example example-compact">
             <div class="card-header">
                <!-- <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3> -->
                <div class="card-toolbar">
                   <!-- <div class="example-tools justify-content-center">
                      <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                      <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                   </div> -->
                </div>
             </div>

             <!-- <div class="loadersmall"></div> -->

             <!--begin::Form-->
             <!-- <form class="form" method="GET"> -->
             <form action="{{ url('report/pdf/finance') }}" class="form" method="POST" target="_blank">
                @csrf
                <div class="card-body">
                   
                   <fieldset class="mb-6">
                      <legend>ফিল্টারিং ফিল্ড সমূহ</legend>
                        <div class="form-group row">
                           <div class="col-lg-6 mb-5">
                              <label>তারিখ হতে</label>
                              <input type="date" name="date_start"  class="w-100 form-control common_datepicker" placeholder="তারিখ হতে" autocomplete="off">
                           </div>
                           <div class="col-lg-6 mb-5">
                              <label>তারিখ পর্যন্ত</label>
                              <input type="date" name="date_end" class="w-100 form-control common_datepicker" placeholder="তারিখ পর্যন্ত" autocomplete="off">
                           </div>
                            <div class="col-lg-6 mb-5">
                                <select data-placeholder="Choose..." required name="current_session" id="current_session" class="select-search form-control">
                                    <option value=""></option>
                                    @for($y=date('Y', strtotime('- 5 years')); $y<=date('Y', strtotime('+ 1 years')); $y++)
                                        <option {{ ($s['current_session'] == ($y)) ? 'selected' : '' }}>{{ ($y) }}</option>
                                    @endfor
                                </select>
                            </div>
                            
                            <div class="col-lg-6 mb-5">
                                <select  class="form-control" id="month" name="month">
                                   <option value=""> মাস নির্বাচন করুন </option>
                                   @foreach(range(1,12) as $month)
                                   <option value="{{$month}}">
                                      {{ date("M", strtotime('2016-'.$month)) }}
                                   </option>
                                   @endforeach
                                </select>
                            </div>
                        </div>
                   </fieldset>
                      <div class="row">
                           <div class="col-lg-12 mb-6 ml-1 text-center"><h3><b>মাদরাসার আর্থিক প্রতিবেদনের তালিকা</b></h3></div>
                         <fieldset class="col-lg-12 mb-6 ml-1 text-center">
                            <legend style="font-size: 15px; font-weight: bolder;">মাদরাসার মাসিক হিসাব</legend>
                            <button type="submit" name="btnsubmit" value="pdf_num_expence" class="btn btn-info btn-cons margin-top mb-2 mt-2">মাসিক ব্যয়ের তালিকা </button>
                            <button type="submit" name="btnsubmit" value="pdf_num_income" class="btn btn-info btn-cons margin-top mb-2 mt-2">মাসিক আয়ের তালিকা </button>
                            <button type="submit" name="btnsubmit" value="pdf_num_profit" class="btn btn-info btn-cons margin-top mb-2 mt-2">মাসিক সর্বমোট মুনাফা </button>
                         </fieldset>
                         <fieldset class="col-lg-12 mb-6 ml-1 text-center">
                            <legend style="font-size: 15px; font-weight: bolder;">মাদরাসার হিসাব</legend>
                            <button type="submit" name="btnsubmit" value="pdf_num_dateBetween_expence" class="btn btn-info btn-cons margin-top mb-2 mt-2"> ব্যয়ের তালিকা </button>
                            <button type="submit" name="btnsubmit" value="pdf_num_dateBetween_income" class="btn btn-info btn-cons margin-top mb-2 mt-2"> আয়ের তালিকা </button>
                            
                         </fieldset>
                         <fieldset class="col-lg-12 mb-6 ml-1 text-center">
                            <legend style="font-size: 15px; font-weight: bolder;">মাদরাসার বাৎসরিক হিসাব</legend>
                            <button type="submit" name="btnsubmit" value="pdf_num_yearly_expence" class="btn btn-info btn-cons margin-top mb-2 mt-2"> ব্যয়ের তালিকা </button>
                            <button type="submit" name="btnsubmit" value="pdf_num_yearly_income" class="btn btn-info btn-cons margin-top mb-2 mt-2"> আয়ের তালিকা </button>
                            <button type="submit" name="btnsubmit" value="pdf_num_profit" class="btn btn-info btn-cons margin-top mb-2 mt-2"> এক নজরে(আয়-ব্যয়) </button>
                            
                         </fieldset>

                      </div>

                </div> <!--end::Card-body-->

                <!-- <div class="card-footer">
                   <div class="row">
                      <div class="col-lg-4"></div>
                      <div class="col-lg-7">
                         <button type="submit" class="btn btn-success mr-2">সংরক্ষণ করুন</button>
                      </div>
                   </div>
                </div> -->

             </form>
             <!--end::Form-->
          </div>
          <!--end::Card-->
       </div>

    </div>

    {{--Payments List Ends--}}
@endsection
   