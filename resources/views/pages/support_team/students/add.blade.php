@extends('layouts.master')
@section('page_title', 'Admit Student')
@section('content')
        <div class="card">
            <div class="card-header bg-white header-elements-inline">
                <h6 class="card-title">Please fill The form Below To Admit A New Student</h6>

                {!! Qs::getPanelOptions() !!}
            </div>

            <form id="ajax-reg" method="post" enctype="multipart/form-data" class="wizard-form steps-validation" action="{{ route('students.store') }}" data-fouc>
               @csrf
                <h6>Personal data</h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Full Name: <span class="text-danger">*</span></label>
                                <input value="{{ old('name') }}" required type="text" name="name" placeholder="Full Name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Father Name:</label>
                                <input value="{{ old('father') }}" type="text" name="father" class="form-control" placeholder="" >
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Father Occupation :</label>
                                <input value="{{ old('occupation') }}" type="text" name="occupation" class="form-control" placeholder="" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Present Address: <span class="text-danger">*</span></label>
                                <input value="{{ old('present_address') }}" class="form-control" placeholder="Present Address" name="present_address" type="text" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Parmanent Address: <span class="text-danger">*</span></label>
                                <input value="{{ old('address') }}" class="form-control" placeholder="Address" name="address" type="text" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Email address: </label>
                                <input type="email" value="{{ old('email') }}" name="email" class="form-control" placeholder="Email Address">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="gender">Gender: <span class="text-danger">*</span></label>
                                <select class="select form-control" id="gender" name="gender" required data-fouc data-placeholder="Choose..">
                                    <option value=""></option>
                                    <option {{ (old('gender') == 'Male') ? 'selected' : '' }} value="Male">Male</option>
                                    <option {{ (old('gender') == 'Female') ? 'selected' : '' }} value="Female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Phone:</label>
                                <input value="{{ old('phone') }}" type="text" name="phone" class="form-control" placeholder="" >
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Telephone:</label>
                                <input value="{{ old('phone2') }}" type="text" name="phone2" class="form-control" placeholder="" >
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date of Birth:</label>
                                <input name="dob" value="{{ old('dob') }}" type="text" class="form-control date-pick" placeholder="Select Date...">

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nal_id">Nationality: <span class="text-danger">*</span></label>
                                <select data-placeholder="Choose..." required name="nal_id" id="nal_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($nationals as $nal)
                                        <option {{ (old('nal_id') == $nal->id ? 'selected' : '') }} {{ (15 == $nal->id ? 'selected' : '') }} value="{{ $nal->id }}">{{ $nal->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="state_id">Division: <span class="text-danger">*</span></label>
                            <select onchange="getLGA(this.value)" required data-placeholder="Choose.." class="select-search form-control" name="state_id" id="state_id">
                                <option value=""></option>
                                @foreach($divisions as $st)
                                    <option {{ (old('state_id') == $st->id ? 'selected' : '') }} value="{{ $st->id }}">{{ $st->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="lga_id">District: <span class="text-danger">*</span></label>
                            <select required data-placeholder="Select State First" class="select-search form-control" name="lga_id" id="lga_id">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bg_id">Blood Group: </label>
                                <select class="select form-control" id="bg_id" name="bg_id" data-fouc data-placeholder="Choose..">
                                    <option value=""></option>
                                    @foreach(App\Models\BloodGroup::all() as $bg)
                                        <option {{ (old('bg_id') == $bg->id ? 'selected' : '') }} value="{{ $bg->id }}">{{ $bg->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">Upload Passport Photo:</label>
                                <input value="{{ old('photo') }}" accept="image/*" type="file" name="photo" class="form-input-styled" data-fouc>
                                <span class="form-text text-muted">Accepted Images: jpeg, png. Max file size 2Mb</span>
                            </div>
                        </div>
                    </div>

                </fieldset>

                <h6>Student Data</h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="my_class_id">Class: <span class="text-danger">*</span></label>
                                <select onchange="getClassSections(this.value)" data-placeholder="Choose..." required name="my_class_id" id="my_class_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($my_classes as $c)
                                        <option {{ (old('my_class_id') == $c->id ? 'selected' : '') }} value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                </select>
                        </div>
                            </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="section_id">Section: <span class="text-danger">*</span></label>
                                <select data-placeholder="Select Class First" required name="section_id" id="section_id" class="select-search form-control">
                                    <option {{ (old('section_id')) ? 'selected' : '' }} value="{{ old('section_id') }}">{{ (old('section_id')) ? 'Selected' : '' }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="my_parent_id">Parent/Guardian : </label>
                                <select data-placeholder="Choose..."  name="my_parent_id" id="my_parent_id" class="select-search form-control">
                                    <option  value=""></option>
                                    @foreach($parents as $p)
                                        <option {{ (old('my_parent_id') == Qs::hash($p->id)) ? 'selected' : '' }} value="{{ Qs::hash($p->id) }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="year_admitted">Year Admitted: <span class="text-danger">*</span></label>
                                <select data-placeholder="Choose..." required name="year_admitted" id="year_admitted" class="select-search form-control">
                                    <option value=""></option>
                                    @for($y=date('Y', strtotime('- 10 years')); $y<=date('Y'); $y++)
                                        <option {{ (old('year_admitted') == $y) ? 'selected' : '' }} value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="dorm_id">Hostel: </label>
                            <select data-placeholder="Choose..."  name="dorm_id" id="dorm_id" class="select-search form-control">
                                <option value=""></option>
                                @foreach($dorms as $d)
                                    <option {{ (old('dorm_id') == $d->id) ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach
                            </select>

                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Hostel Room No:</label>
                                <input type="text" name="dorm_room_no" placeholder="Dormitory Room No" class="form-control" value="{{ old('dorm_room_no') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Supervising Teacher Name:</label>
                                <input type="text" name="sup_teacher" placeholder="Supervising Teacher Name:" class="form-control" value="{{ old('sup_teacher') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Admission Number:</label>
                                <input type="text" name="adm_no" placeholder="Admission Number" class="form-control" value="{{ old('adm_no') }}">
                            </div>
                        </div>
                    </div>
                </fieldset>
                <h6>Payment (Optional)</h6>
                <fieldset>
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <input type="button" class="btn btn-success" onclick="addPaymentOption()" value="Payment Add" />
                        </div>
                    </div>
                    <div class="row" id="payment_add">
                        <div class="col-md-4  p-3 border">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label font-weight-semibold">Title <span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input name="title[]" value="{{ old('title') ?? 'Admission Fee' }} " required type="text" class="form-control" placeholder="Eg. Admission Fee">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="method" class="col-lg-4 col-form-label font-weight-semibold">Payment Method</label>
                                    <div class="col-lg-8">
                                        <select class="form-control select" name="method[]" id="method">
                                            <option selected value="Cash">Cash</option>
                                            <option disabled value="Online">Online</option>
                                        </select>
                                    </div>
                                </div>
        
                                <div class="form-group row">
                                    <label for="amount" class="col-lg-4 col-form-label font-weight-semibold">Amount (BDT.) <span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input class="form-control" value="{{ old('amount') }}" required name="amount[]" id="amount" type="number">
                                    </div>
                                </div>
        
                                <div class="form-group row">
                                    <label for="description" class="col-lg-4 col-form-label font-weight-semibold">Description</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" value="{{ old('description') }}" name="description[]" id="description" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="method" class="col-lg-4 col-form-label font-weight-semibold">Payment Paid</label>
                                    <div class="col-lg-8">
                                        <select class="form-control select" name="paid[]" id="paid">
                                            <option selected value="yes">Yes</option>
                                            <option value="no">NO</option>
                                        </select>
                                    </div>
                                </div>
        
                                {{-- <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
                                </div> --}}
                            {{-- </form> --}}
                        </div>
                    </div>
                </fieldset>
                {{-- <div>
                    <input onclick="deletePaymentOption(this)" type="button" class="btn btn-danger" value="remove">
                </div> --}}

            </form>
        </div>
        <script>
            function deletePaymentOption(id) {
                $(id).closest("div.paymentDiv").remove();
            }
            function addPaymentOption(){
                var addPayment = '';
                    addPayment +='<div class="col-md-4 paymentDiv p-3 border">';

                    addPayment +='     <div class="form-group row">';
                    addPayment +='         <label class="col-lg-4 col-form-label font-weight-semibold">Title <span class="text-danger">*</span></label>';
                    addPayment +='         <div class="col-lg-8">';
                    addPayment +='             <input name="title[]" value="Admission Fee" required type="text" class="form-control" placeholder="Eg. Admission Fee">';
                    addPayment +='         </div>';
                    addPayment +='     </div>';
                    addPayment +='     <div class="form-group row">';
                    addPayment +='         <label for="method" class="col-lg-4 col-form-label font-weight-semibold">Payment Method</label>';
                    addPayment +='         <div class="col-lg-8">';
                    addPayment +='             <select class="form-control select" name="method[]" id="method">';
                    addPayment +='                 <option selected value="Cash">Cash</option>';
                    addPayment +='                 <option disabled value="Online">Online</option>';
                    addPayment +='             </select>';
                    addPayment +='         </div>';
                    addPayment +='     </div>';
                    addPayment +='     <div class="form-group row">';
                    addPayment +='         <label for="amount" class="col-lg-4 col-form-label font-weight-semibold">Amount (BDT.) <span class="text-danger">*</span></label>';
                    addPayment +='         <div class="col-lg-8">';
                    addPayment +='             <input class="form-control" value="" required name="amount[]" id="amount" type="number">';
                    addPayment +='         </div>';
                    addPayment +='     </div>';
                    addPayment +='     <div class="form-group row">';
                    addPayment +='         <label for="description" class="col-lg-4 col-form-label font-weight-semibold">Description</label>';
                    addPayment +='         <div class="col-lg-8">';
                    addPayment +='             <input class="form-control" value="" name="description[]" id="description" type="text">';
                    addPayment +='         </div>';
                    addPayment +='     </div>';
                    addPayment +='     <div class="form-group row">';
                    addPayment +='         <label for="method" class="col-lg-4 col-form-label font-weight-semibold">Payment Paid</label>';
                    addPayment +='         <div class="col-lg-8">';
                    addPayment +='             <select class="form-control select" name="paid[]" id="paid">';
                    addPayment +='                 <option selected value="yes">Yes</option>';
                    addPayment +='                 <option value="no">NO</option>';
                    addPayment +='             </select>';
                    addPayment +='         </div>';
                    addPayment +='     </div>';
                    addPayment +='     <div class="form-group row">';
                    addPayment +='         <label class="col-lg-12 col-form-label font-weight-semibold"><input onclick="deletePaymentOption(this)" type="button" class="btn btn-danger" value="remove"></label>';
                    addPayment +='      </div>';
                    addPayment +='</div>';
                    $('#payment_add').append(addPayment);

            }
        </script>
    @endsection
