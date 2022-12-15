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
             <form action="{{ url('report/pdf') }}" class="form" method="POST" target="_blank">
                @csrf
                <div class="card-body">
                   
                   <fieldset class="mb-6">
                      <legend>ফিল্টারিং ফিল্ড সমূহ</legend>
                        <div class="form-group row">
                            <div class="col-lg-4 mb-5">
                                <select name="badrin_id" class="form-control form-control-sm">
                                   <option value=""> বদরী সদস্য নির্বাচন করুন</option>
                                      @foreach($badrins as $c)
                                          <option {{ ($selected && $id == $c->id) ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                                      @endforeach
                                   
                                </select>
                            </div>
                            <div class="col-lg-4 mb-5">
                                <select data-placeholder="Choose..." required name="year" id="year" class="select-search form-control">
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2020">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2021">2026</option>
                                    <option value="2020">2027</option>
                                </select>
                            </div>
                            
                            <div class="col-lg-4 mb-5">
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
                         <fieldset class="col-lg-12 mb-6 ml-1 text-center">
                            <legend>মাসিক বেতন ভিত্তিক তালিকা </legend>
                            <button type="submit" name="btnsubmit" value="pdf_num_payment_paid" class="btn btn-info btn-cons margin-top">বেতন পরিশোধিতদের তালিকা</button>
                            <button type="submit" name="btnsubmit" value="pdf_num_payment_unpaid" onclick="return validFunc1()" class="btn btn-info btn-cons margin-top"> বেতন অপরিশোধিতদের তালিকা</button>
                            
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
