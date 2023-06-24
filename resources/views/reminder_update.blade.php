@extends('layout.design')

@section('contents')
    <style>
        input:enabled:read-write:-webkit-any(:focus, :hover)::-webkit-calendar-picker-indicator {
            display: block !important;
        }
    </style>
    <div class="container">
        <h2 class="main-title">Update Reminder</h2>
        <div>
            @if (Session::has('info'))
                <div class="alert alert-primary" role="alert">
                    {{ session('info') }}
                </div>
            @endif

            @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (Session::has('danger'))
                <div class="alert alert-danger" role="alert">
                    {{ session('danger') }}
                </div>
            @endif
            @if (Session::has('warning'))
                <div class="alert alert-warning" role="alert">
                    {{ session('warning') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="row stat-cards">
            <form class="sign-up-form form" method="POST" action="{{ route('update_reminder', ['id' => $reminder->id]) }}">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Description</p>
                            <input id="" type="text"
                                class="form-control @error('description') is-invalid @enderror form-input" name="description"
                                value="{{ $reminder->description }}" required>
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Type</p>
                            <select name="type" id="type" type="text"
                                class="form-control @error('type') is-invalid @enderror form-input autofocus" required>
                                @php
                                    $types = App\Models\ReminderTypes::all();
                                @endphp
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}" {{ $type->id == $reminder->type ? 'selected' : '' }}>
                                        {{ $type->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="col-6">
                        <label class="form-label-wrapper">
                            <p class="form-label">Schedule</p>
                            <input id="schedule" type="datetime-local"
                                class="form-control @error('schedule') is-invalid @enderror  form-input" name="schedule"
                                value="{{ $reminder->schedule }}"
                                {{-- min="{{ Carbon\Carbon::now()->addDays(1)->format('Y-m-d 00:00:00')}}" --}}
                                required>
                        </label>
                    </div>


                    <div class="col-12">
                        <label class="form-label-wrapper">
                            <p class="form-label">Message</p>
                            <textarea id="message" type="text"
                                class="form-control @error('name') is-invalid @enderror form-input" name="message"
                                value="{{ $reminder->message }}" placeholder="Enter your name" required style="height: 10em;" maxlenth="255"></textarea>
                        </label>
                    </div>
                </div>
                <button type="submit" class="form-btn primary-default-btn transparent-btn">
                    Submit
                </button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('document').ready(function() {
            // front end input restriction
            $(".input-numbers").keypress(function(event) {
                return /\d/.test(String.fromCharCode(event.keyCode));
            });
            $(".input_name").keypress(function(event) {
                return /^[a-zA-Z.\s]*$/.test(String.fromCharCode(event.keyCode));
            });
        });
    </script>
@endsection
