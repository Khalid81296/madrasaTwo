<table style="width:100%; border-collapse:collapse; border: 1px solid #000; margin: 10px auto;" border="1">
    <thead>
    <tr>
        <th rowspan="2">S/N</th>
        <th rowspan="2">SUBJECTS</th>
        <th rowspan="2">1st Term<br>(100)</th>
        <th rowspan="2">2nd Term<br>(100)</th>
        <th rowspan="2">3rd Term<br>(100)</th>
        <th rowspan="2">Average<br>(100)</th>
        <th rowspan="2">GRADE</th>
        <th rowspan="2">REMARKS</th>
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

                @php
                    // $avgs/3
                    $g = '';
                    if($avgs >= 80){
                        $g = 'A+';
                        $remarks = 'Excellent';
                    }
                    elseif ( $avgs >=70){ // Note the space between else & if
                        $g = 'A';
                        $remarks = 'Very Good';
                    }
                    else if ( $avgs >=60){
                        $g = 'A-';
                        $remarks = 'Good';
                    }
                    else if ( $avgs >=50){
                        $g = 'B';
                        $remarks = 'Fair';
                    }
                    else if ( $avgs >=40){
                        $g = 'C';
                        $remarks = 'Pass';
                    }
                    else if ( $avgs >=33){
                        $g = 'D';
                        $remarks = 'Poor';
                    }
                    else if ( $avgs < 33){
                        $g = 'F';
                        $remarks = 'Fail';
                    }
                @endphp
                <td>{{$g}}</td>
                <td>{{$remarks}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
