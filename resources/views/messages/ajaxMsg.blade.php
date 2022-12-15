@foreach ($messages as $key => $row)
    @if ($row->user_sender == Auth::user()->id)
        <tr align="right">
            <td>
                <div class="row">
                    <div class="col-md-10">
                        @if($row->msg_remove != 1)
                            @if (strlen($row->messages) < 50)
                            <p><span class="bg-primary text-light rounded-left px-2 p-1">
                                {{ $row->messages }}
                            </span></p>
                            @else
                            <p class="bg-primary text-light rounded-left px-2 p-1">
                                {{ $row->messages }}
                            </p>
                            @endif
                        @else
                            <p><span class="text-muted text-light rounded border px-2 p-1">
                                <em><small>Message Removed </small></em>
                            </span></p>
                        @endif
                        <p class="h6 text-muted">
                            @if($row->msg_remove != 1)
                            <em><small>
                                <a class="text-muted" onclick="return confirm('Are you want to remove this message?')" href="{{ route('messages_remove', Qs::hash($row->id))}}">Remove</a>
                            </small>
                            </em>
                                |
                            @endif
                            <em><small>
                                {{ $row->created_at }}
                            </small>
                            </em>
                        </p>

                    </div>
                    <div class="col-md-2">
                        @if (Auth::user()->profile_pic != null)
                            <img style="width: 50px; border-radius: 50%;"
                                src="{{ url('/') }}/uploads/profile/{{ Auth::user()->profile_pic }}"
                                alt="">
                        @else
                        @php
                            $str = $user->username;
                        @endphp
                        <span class="badge badge-danger rounded-circle text-capitalize h1 mr-3">{{ substr($str, 0, 1) }}</span>

                            {{-- <img style="width: 50px; border-radius: 50%;"
                                src="{{ url('/') }}/uploads/profile/default.jpg" alt=""> --}}
                        @endif
                    </div>
                </div>
            </td>
        </tr>
    @else
        <tr>
            <td>
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                        @if ($user->profile_pic != null)
                            <img style="width: 50px; border-radius: 50%;"
                                src="{{ url('/') }}/uploads/profile/{{ $user->profile_pic }}"
                                alt="">

                        @else
                        @php
                            $str = $user->name;
                        @endphp
                        <span class="badge badge-danger rounded-circle text-capitalize h1 mr-3">{{ substr($str, 0, 1) }}</span>

                            {{-- <img style="width: 50px; border-radius: 50%;"
                                src="{{ url('/') }}/uploads/profile/default.jpg" alt=""> --}}
                        @endif
                    </div>
                    <div class="col-md-10 col-sm-10">
                        @if($row->msg_remove != 1)
                            {{ $row->messages }}
                        @else
                            <p><span class="text-muted text-light rounded border px-2 p-1">
                                <em><small>Message Removed </small></em>
                            </span></p>
                        @endif
                        <p class="h6 text-muted"><em><small>
                            {{ $row->created_at }}</small></em>
                        </p>
                    </div>
                </div>
            </td>
        </tr>
    @endif
@endforeach
