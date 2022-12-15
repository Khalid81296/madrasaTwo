<div class="sidebar sidebar-dark bg-dark sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                        <a href="{{ route('my_account') }}"><img src="{{ asset(Auth::user()->photo) }}" width="38"
                                height="38" class="rounded-circle" alt="photo"></a>
                    </div>

                    <div class="media-body">
                        <div class="media-title font-weight-semibold">{{ Auth::user()->name }}</div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-user font-size-sm"></i>
                            &nbsp;{{ ucwords(str_replace('_', ' ', Auth::user()->user_type)) }}
                        </div>
                    </div>

                    <div class="ml-3 align-self-center">
                        <a href="{{ route('my_account') }}" class="text-white"><i class="icon-cog3"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->

        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                        <i class="icon-home4"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Academics --}}
                @if (Qs::userIsAcademic())
                    <li
                        class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['tt.index', 'ttr.edit', 'ttr.show', 'ttr.manage']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-graduation2"></i> <span> Academics</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Manage Academics">

                            {{-- Timetables --}}
                            <li class="nav-item"><a href="{{ route('tt.index') }}"
                                    class="nav-link {{ in_array(Route::currentRouteName(), ['tt.index']) ? 'active' : '' }}">Timetables</a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- Administrative --}}
                @if (Qs::userIsAdministrative())
                    <li
                        class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['payments.index', 'payments.create', 'payments.invoice', 'payments.receipts', 'payments.edit', 'payments.manage', 'payments.show', 'payment_records.index']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-office"></i> <span>
                                Administrative</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Administrative">

                            {{-- Payments --}}
                            @if (Qs::userIsTeamAccount())
                                <li
                                    class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['payments.index', 'payments.create', 'payments.edit', 'payments.manage', 'payments.show', 'payments.invoice', 'payment_records.index']) ? 'nav-item-expanded' : '' }}">

                                    <a href="#"
                                        class="nav-link {{ in_array(Route::currentRouteName(), ['payments.index', 'payments.edit', 'payments.create', 'payments.manage', 'payments.show', 'payments.invoice']) ? 'active' : '' }}">Payments</a>

                                    <ul class="nav nav-group-sub">
                                        <li class="nav-item"><a href="{{ route('payments.create') }}"
                                                class="nav-link {{ Route::is('payments.create') ? 'active' : '' }}">Create
                                                Payment</a></li>
                                        <li class="nav-item"><a href="{{ route('payments.index') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), ['payments.index', 'payments.edit', 'payments.show']) ? 'active' : '' }}">Manage
                                                Payments</a></li>
                                        <li class="nav-item">
                                            <a href="{{ route('payments.manage') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['payments.manage', 'payments.invoice', 'payments.receipts']) ? 'active' : '' }}">Student Payments</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a href="{{ route('payment_records.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['payment_records.index', 'payment_records.show']) ? 'active' : '' }}">Payment Records</a>
                                        </li> -->
                                        <!-- <li class="nav-item">
                                            <a href="{{ route('other_payment.create') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['other_payment.create']) ? 'active' : '' }}">Other Payment Create</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('other_payment.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['other_payment.index']) ? 'active' : '' }}">Other Payment List</a>
                                        </li> -->
                                    </ul>
                                </li>
                                <li
                                    class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['expenses.index', 'expenses.create', 'expenses.edit', 'expenses.manage', 'expenses.show', 'expenses.invoice', 'payment_records.index']) ? 'nav-item-expanded' : '' }}">

                                    <a href="#"
                                        class="nav-link {{ in_array(Route::currentRouteName(), ['expenses.index', 'expenses.edit', 'expenses.create', 'expenses.manage', 'expenses.show', 'expenses.invoice']) ? 'active' : '' }}">Expenses</a>

                                    <ul class="nav nav-group-sub">
                                        <li class="nav-item"><a href="{{ route('salary.index') }}"
                                                class="nav-link {{ Route::is('salary.index') ? 'active' : '' }}">
                                                Staff Salary List</a></li>
                                        <li class="nav-item"><a href="{{ route('expense-categories.index') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), ['expense-categories.index', 'expense-categories.edit', 'expense-categories.show']) ? 'active' : '' }}">Expenses Category</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('expenses.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['expenses.index', 'expenses.edit', 'expenses.show']) ? 'active' : '' }}">Expenses List </a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a href="{{ route('payment_records.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['payment_records.index', 'payment_records.show']) ? 'active' : '' }}">Expenses Records</a>
                                        </li> --}}
                                    </ul>
                                </li>
                                <li
                                    class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['income.index', 'income.create', 'income.edit', 'income.manage', 'income.show', 'income.invoice', 'income_category.index']) ? 'nav-item-expanded' : '' }}">

                                    <a href="#"
                                        class="nav-link {{ in_array(Route::currentRouteName(), ['income.index', 'income.edit', 'income.create']) ? 'active' : '' }}">Others Income</a>

                                    <ul class="nav nav-group-sub">
                                        
                                        <li class="nav-item"><a href="{{ route("income-categories.index") }}" class="nav-link {{ request()->is('income-categories') || request()->is('income-categories/*') ? 'active' : '' }}"> Income Category</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route("incomes.index") }}" class="nav-link {{ request()->is('incomes') || request()->is('incomes/*') ? 'active' : '' }}">Income List </a>
                                        </li>
                                        
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </li>
                    <li
                    class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['report', 'report.payment', 'report.monthly']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                    <a href="#" class="nav-link">
                        <i class="icon-exclamation"></i>
                        <span> Report</span>
                    </a>

                    <ul class="nav nav-group-sub" data-submenu-title="Manage Exams">

                        {{-- Exam list --}}
                        <li class="nav-item">
                            <a href="{{ route('report.payment') }}"
                                class="nav-link {{ Route::is('report.payment') ? 'active' : '' }}">
                                Payment Report 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.badrin.payment') }}"
                                class="nav-link {{ Route::is('report.badrin.payment') ? 'active' : '' }}">
                                Badrin Payment Report 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.monthly') }}"
                                class="nav-link {{ Route::is('report.monthly') ? 'active' : '' }}">
                                Income Expence Report 
                            </a>
                        </li>
                        
                    </ul>
                </li>
                @endif

                {{-- Manage Students --}}
                @if (Qs::userIsTeamSAT())
                    <li
                        class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['students.create', 'students.list', 'students.edit', 'students.show', 'students.promotion', 'students.promotion_manage', 'students.graduated']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-users"></i> <span> Students</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Manage Students">
                            {{-- Admit Student --}}
                            @if (Qs::userIsTeamSA())
                                <li class="nav-item">
                                    <a href="{{ route('students.create') }}"
                                        class="nav-link {{ Route::is('students.create') ? 'active' : '' }}">Admit
                                        Student</a>
                                </li>
                            @endif

                            {{-- Student Information --}}
                            <li
                                class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['students.list', 'students.edit', 'students.show']) ? 'nav-item-expanded' : '' }}">
                                <a href="#"
                                    class="nav-link {{ in_array(Route::currentRouteName(), ['students.list', 'students.edit', 'students.show']) ? 'active' : '' }}">Student
                                    Information</a>
                                <ul class="nav nav-group-sub">
                                    @foreach (App\Models\MyClass::orderBy('name')->get() as $c)
                                        <li class="nav-item"><a href="{{ route('students.list', $c->id) }}"
                                                class="nav-link ">{{ $c->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>

                            @if (Qs::userIsTeamSA())

                                {{-- Student Promotion --}}
                                <li
                                    class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['students.promotion', 'students.promotion_manage']) ? 'nav-item-expanded' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ in_array(Route::currentRouteName(), ['students.promotion', 'students.promotion_manage']) ? 'active' : '' }}">Student
                                        Promotion</a>
                                    <ul class="nav nav-group-sub">
                                        <li class="nav-item"><a href="{{ route('students.promotion') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), ['students.promotion']) ? 'active' : '' }}">Promote
                                                Students</a></li>
                                        <li class="nav-item"><a href="{{ route('students.promotion_manage') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), ['students.promotion_manage']) ? 'active' : '' }}">Manage
                                                Promotions</a></li>
                                    </ul>

                                </li>

                                {{-- Student Graduated --}}
                                <li class="nav-item"><a href="{{ route('students.graduated') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), ['students.graduated']) ? 'active' : '' }}">Students
                                        Graduated</a></li>
                            @endif

                        </ul>
                    </li>
                @endif

                {{-- Manage Badrins --}}
                @if (Qs::userIsTeamSAT())
                    <li
                        class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['badrins.create', 'badrins.list', 'badrins.edit', 'badrins.show']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-users"></i> <span> Badrins</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Manage Students">
                            {{-- Admit Badrin --}}
                            @if (Qs::userIsTeamSA())
                                <li class="nav-item">
                                    <a href="{{ route('badrins.create') }}"
                                        class="nav-link {{ Route::is('badrins.create') ? 'active' : '' }}">Admit
                                        Badrin</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('badrinPayment.index') }}"
                                        class="nav-link {{ Route::is('badrinPayment.index') ? 'active' : '' }}">Badrin Payment Entry 
                                    </a>
                                </li>
                            @endif

                            {{-- Badrin Information --}}
                            <li
                                class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['badrins.list', 'badrins.edit', 'badrins.show']) ? 'nav-item-expanded' : '' }}">
                                <a href="#"
                                    class="nav-link {{ in_array(Route::currentRouteName(), ['badrins.list', 'badrins.edit', 'badrins.show']) ? 'active' : '' }}">Badrin
                                    Information</a>
                                <ul class="nav nav-group-sub">
                                    @foreach (App\Models\MyClass::where('class_type_id','7')->orderBy('name')->get() as $c)
                                        <li class="nav-item"><a href="{{ route('badrins.list', $c->id) }}"
                                                class="nav-link ">{{ $c->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>

                        </ul>
                    </li>
                @endif

                @if (Qs::userIsTeamSA())
                    {{-- Manage Users --}}
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}"
                            class="nav-link {{ in_array(Route::currentRouteName(), ['users.index', 'users.show', 'users.edit']) ? 'active' : '' }}"><i
                                class="icon-users4"></i> <span> Users</span></a>
                    </li>

                    {{-- Manage Classes --}}
                    <li class="nav-item">
                        <a href="{{ route('classes.index') }}"
                            class="nav-link {{ in_array(Route::currentRouteName(), ['classes.index', 'classes.edit']) ? 'active' : '' }}"><i
                                class="icon-windows2"></i> <span> Classes</span></a>
                    </li>

                    {{-- Manage Dorms --}}
                    <li class="nav-item">
                        <a href="{{ route('dorms.index') }}"
                            class="nav-link {{ in_array(Route::currentRouteName(), ['dorms.index', 'dorms.edit']) ? 'active' : '' }}"><i
                                class="icon-home9"></i> <span> Dormitories</span></a>
                    </li>

                    {{-- Manage Sections --}}
                    <li class="nav-item">
                        <a href="{{ route('sections.index') }}"
                            class="nav-link {{ in_array(Route::currentRouteName(), ['sections.index', 'sections.edit']) ? 'active' : '' }}"><i
                                class="icon-fence"></i> <span>Sections</span></a>
                    </li>

                    {{-- Manage Subjects --}}
                    <li class="nav-item">
                        <a href="{{ route('subjects.index') }}"
                            class="nav-link {{ in_array(Route::currentRouteName(), ['subjects.index', 'subjects.edit']) ? 'active' : '' }}"><i
                                class="icon-pin"></i> <span>Subjects</span></a>
                    </li>
                @endif

                {{-- Exam --}}
                @if (Qs::userIsTeamSAT())
                    <li
                        class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['exams.index', 'exams.edit', 'grades.index', 'grades.edit', 'marks.index', 'marks.manage', 'marks.bulk', 'marks.tabulation', 'marks.show', 'marks.batch_fix']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-books"></i> <span> Exams</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Manage Exams">
                            @if (Qs::userIsTeamSA())

                                {{-- Exam list --}}
                                <li class="nav-item">
                                    <a href="{{ route('exams.index') }}"
                                        class="nav-link {{ Route::is('exams.index') ? 'active' : '' }}">Exam
                                        List</a>
                                </li>

                                {{-- Grades list --}}
                                <li class="nav-item">
                                    <a href="{{ route('grades.index') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), ['grades.index', 'grades.edit']) ? 'active' : '' }}">Grades</a>
                                </li>

                                {{-- Tabulation Sheet --}}
                                <li class="nav-item">
                                    <a href="{{ route('marks.tabulation') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), ['marks.tabulation']) ? 'active' : '' }}">Tabulation
                                        Sheet</a>
                                </li>

                                {{-- Marks Batch Fix --}}
                                <li class="nav-item">
                                    <a href="{{ route('marks.batch_fix') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), ['marks.batch_fix']) ? 'active' : '' }}">Batch
                                        Fix</a>
                                </li>
                            @endif

                            @if (Qs::userIsTeamSAT())
                                {{-- Marks Manage --}}
                                <li class="nav-item">
                                    <a href="{{ route('marks.index') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), ['marks.index']) ? 'active' : '' }}">Marks</a>
                                </li>

                                {{-- Marksheet --}}
                                <li class="nav-item">
                                    <a href="{{ route('marks.bulk') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), ['marks.bulk', 'marks.show']) ? 'active' : '' }}">Marksheet</a>
                                </li>

                            @endif

                        </ul>
                    </li>
                @endif


                {{-- End Exam --}}

                <li
                    class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['messages_recent', 'messages_request', 'messages/*']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                    <a href="#" class="nav-link"><i class="icon-envelope"></i>
                        <span> Messages</span>
                        @if ($Ncount != 0)
                            <span class="ml-2">
                                <span class="badge badge-pill badge-danger">{{ $Ncount }}</span>
                            </span>
                        @endif
                    </a>

                    <ul class="nav nav-group-sub" data-submenu-title="Manage Exams">

                        {{-- Exam list --}}
                        <li class="nav-item">
                            <a href="{{ route('messages_recent') }}"
                                class="nav-link {{ Route::is('messages_recent') ? 'active' : '' }}">
                                Recent Messages @if ($NewMessagesCount != 0)
                                    <span class="ml-2">
                                        <span class="badge badge-pill badge-danger">{{ $NewMessagesCount }}</span>
                                    </span>
                                @endif
                            </a>
                        </li>
                        @if ($msg_request_count != 0)
                            <li class="nav-item">
                                <a href="{{ route('messages_request') }}"
                                    class="nav-link {{ Route::is('messages_request') ? 'active' : '' }}">
                                    Messages Request
                                    @if ($NewMessagesCount != 0)
                                        <span class="ml-2">
                                            <span
                                                class="badge badge-pill badge-danger">{{ $msg_request_count }}</span>
                                        </span>
                                    @endif
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('messages') }}"
                                class="nav-link {{ Route::is('messages') ? 'active' : '' }}">
                                User List
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['notice', 'notice.index', 'notice.create', 'notice.show']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                    <a href="#" class="nav-link">
                        <i class="icon-exclamation"></i>
                        <span> Notice</span>
                    </a>

                    <ul class="nav nav-group-sub" data-submenu-title="Manage Exams">

                        {{-- Exam list --}}
                        @if (Auth::user()->user_type != 'student')
                        <li class="nav-item">
                            <a href="{{ route('notice.create') }}"
                                class="nav-link {{ Route::is('notice.create') ? 'active' : '' }}">
                                Notice Create @if ($NewMessagesCount != 0)
                                    <span class="ml-2">
                                        <span class="badge badge-pill badge-danger">{{ $NewMessagesCount }}</span>
                                    </span>
                                @endif
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('notice.index') }}"
                                class="nav-link {{ Route::is('notice.index') ? 'active' : '' }}">
                                Notice List
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['sms', 'sms.index', 'sms.create', 'sms.show']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                    <a href="#" class="nav-link">
                        <i class="icon-envelope"></i>
                        <span> SMS MANAGEMENT</span>
                    </a>

                    <ul class="nav nav-group-sub" data-submenu-title="Manage Exams">

                        {{-- Exam list --}}
                        @if (Auth::user()->user_type != 'student')
                        <li class="nav-item">
                            <a href="{{ route('sms.create') }}"
                                class="nav-link {{ Route::is('sms.create') ? 'active' : '' }}">
                                SMS Create
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('sms.index') }}"
                                class="nav-link {{ Route::is('sms.index') ? 'active' : '' }}">
                                SMS List
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['assynment', 'assynment.index', 'assynment.create', 'assynment.show']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                    <a href="#" class="nav-link"><i class="icon-pen"></i>
                        <span> Assynment</span>
                    </a>

                    <ul class="nav nav-group-sub" data-submenu-title="Manage Exams">

                        {{-- Exam list --}}
                        @if (Auth::user()->user_type != 'student')
                            <li class="nav-item">
                                <a href="{{ route('assynment.create') }}"
                                    class="nav-link {{ Route::is('assynment.create') ? 'active' : '' }}">
                                    Assynment Create
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('assynment.index') }}"
                                class="nav-link {{ Route::is('assynment.index') ? 'active' : '' }}">
                                Assynment List
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['student_assynment', 'student_assynment.index', 'student_assynment.create', 'student_assynment.show']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                    <a href="#" class="nav-link"><i class="icon-envelope"></i>
                        <span> student_assynment</span>
                    </a>

                    <ul class="nav nav-group-sub" data-submenu-title="Manage Exams">

                            <li class="nav-item">
                                <a href="{{ route('student_assynment.create') }}" class="nav-link {{ (Route::is('student_assynment.create')) ? 'active' : '' }}">
                                    student_assynment  Create @if ($NewMessagesCount != 0)
                                    <span class="ml-2">
                                        <span class="badge badge-pill badge-danger">{{ $NewMessagesCount }}</span>
                                    </span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('student_assynment.index') }}" class="nav-link {{ (Route::is('student_assynment.index')) ? 'active' : '' }}">
                                    student_assynment List
                                </a>
                            </li>
                    </ul>
                </li> --}}

                {{-- <li class="nav-item nav-item-submenu {{ request()->is('messages', 'messages/*', 'messages_recent','messages_request') ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                       <span class="menu-text font-weight-bolder"><i class="fas fa-file-contract"></i> বার্তা</span>
                        @if ($Ncount != 0)
                        <span class="menu-label">
                            <span class="label label-rounded label-danger">{{ $Ncount }}</span>
                        </span>
                        @endif
                       <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                       <i class="menu-arrow"></i>
                       <ul class="menu-subnav">
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('messages_recent') }}" class="menu-link">
                               <i class="menu-bullet menu-bullet-dot"><span></span></i>
                               <span class="menu-text font-weight-bolder">সাম্প্রতিক বার্তা</span>
                               @if ($NewMessagesCount != 0)
                                <span class="menu-label">
                                    <span class="label label-rounded label-danger">{{ $NewMessagesCount }}</span>
                                </span>
                                @endif
                            </a>
                         </li>
                        @if ($msg_request_count != 0)
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('messages_request') }}" class="menu-link">
                               <i class="menu-bullet menu-bullet-dot"><span></span></i>
                               <span class="menu-text font-weight-bolder">নতুন বার্তা অনুরোধ</span>
                                <span class="menu-label">
                                    <span class="label label-rounded label-danger">{{ $msg_request_count }}</span>
                                </span>
                            </a>
                         </li>
                         @endif
                          <li class="menu-item" aria-haspopup="true">
                             <a href="{{ route('messages') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                <span class="menu-text font-weight-bolder">ব্যবহারকারীর তালিকা</span>
                             </a>
                          </li>
                       </ul>
                    </div>
                </li> --}}

                @include('pages.'.Qs::getUserType().'.menu')

                {{-- Manage Account --}}
                <li class="nav-item">
                    <a href="{{ route('my_account') }}"
                        class="nav-link {{ in_array(Route::currentRouteName(), ['my_account']) ? 'active' : '' }}"><i
                            class="icon-user"></i> <span>My Account</span></a>
                </li>

            </ul>
        </div>
    </div>
</div>
