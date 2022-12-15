<table class="table table-bordered table-responsive text-center">
    <thead>
    <tr>
        <th rowspan="2">S/N</th>
        <th rowspan="2">SUBJECTS</th>
        {{-- <th rowspan="2">CA1<br>(20)</th> --}}
        <th rowspan="2">1st Term<br>(100)</th>
        <th rowspan="2">2nd Term<br>(100)</th>
        <th rowspan="2">3rd Term<br>(100)</th>

        <th rowspan="2">Average<br>(100)</th>
        <th rowspan="2">GRADE</th>
        {{-- <th rowspan="2">SUBJECT <br> POSITION</th>
        <th rowspan="2">REMARKS</th> --}}
    </tr>
    </thead>
    <tbody>
        @foreach($subjects as $sub)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sub->name }}</td>
                @php
                    $total = 0;
                @endphp
                @foreach ($exams as $key=>$ex)
                    @foreach($marks->where('subject_id', $sub->id)->where('exam_id', $ex->id) as $mk)
                        @if ($key == 0)
                            <td>{{ ($mk->tex1) ?: '-' }}</td>
                            @php
                                $total +=$mk->tex1;
                            @endphp
                        @elseif ($key == 1)
                            <td>{{ ($mk->tex2) ?: '-' }}</td>
                            @php
                                $total +=$mk->tex2;
                            @endphp
                        @else
                            <td>{{ ($mk->tex3) ?: '-' }}</td>
                            @php
                                $total +=$mk->tex3;
                            @endphp
                        @endif
                    @endforeach
                @endforeach
                <td>
                    {{$avgs = number_format($total/3, 2)}}
                </td>
                {{-- <td>{{ ($mk->grade) ? $mk->grade->name : '-' }}</td>
                <td>{!! ($mk->grade) ? Mk::getSuffix($mk->sub_pos) : '-' !!}</td>
                <td>{{ ($mk->grade) ? $mk->grade->remark : '-' }}</td> --}}

                @php
                    // $avgs/3
                    $g = '';
                    if($avgs >= 80){
                        $g = 'A+';
                    }
                    elseif ( $avgs >=70){ // Note the space between else & if
                        $g = 'A';
                    }
                    else if ( $avgs >=60){
                        $g = 'A-';
                    }
                    else if ( $avgs >=50){
                        $g = 'B';
                    }
                    else if ( $avgs >=40){
                        $g = 'C';
                    }
                    else if ( $avgs >=33){
                        $g = 'D';
                    }
                    else if ( $avgs < 33){
                        $g = 'F';
                    }
                @endphp
                <td>{{$g}}</td>


                {{-- <td>123</td>
                <td>remarks</td> --}}
            </tr>
        @endforeach
        {{-- <tr>
            <td colspan="4"><strong>TOTAL SCORES OBTAINED: </strong> {{ $exr->total }}</td>
            <td colspan="3"><strong>FINAL AVERAGE: </strong> {{ $exr->ave }}</td>
            <td colspan="2"><strong>CLASS AVERAGE: </strong> {{ $exr->class_ave }}</td>
        </tr> --}}
    </tbody>
</table>
