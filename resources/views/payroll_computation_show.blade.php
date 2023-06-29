@extends('layout.design')

@section('contents')
    <div class="container">

        <h2 class="main-title">Add Payroll Computations</h2>

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

        <div class="container users-page">
            <div class="col-lg-12">
                <div class='form mt-2'>

                    <table class="table mt-2">
                        <tbody>
                            <tr class="table-secondary">
                                <th scope="row">Employee Details</th>
                                <td></td>
                                <th></th>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">Name</th>
                                <td>{{ $results->employee_full_name }}</td>
                                <th>Employee Code</th>
                                <td>{{ $results->employee_code }}</td>
                            </tr>

                            <tr>
                                <th scope="row">Position</th>
                                <td>{{ $results->employee_position }}</td>
                                <th>Status</th>
                                <td>{{ $results->status }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Hired</th>
                                <td>{{ $results->employee_date_hired }}</td>
                                <td></td>
                                <td></td>
                            </tr>

                        </tbody>
                    </table>


                    <table class="table">
                        <thead class="thead-light">
                            <tr class="table-secondary">
                                <th scope="row">Payroll Details</th>
                                <td></td>
                                <th></th>
                                <td></td>
                            </tr>
                        </thead>

                        <tbody>


                            <tr>
                                <th scope="row">Period</th>
                                <td>{{ $results->schedule_name }}</td>
                                <th scope="row">Begin Date</th>
                                <td>{{ $results->schedule_from }}</td>
                            </tr>

                            <tr>

                                <th>Pay Rate</th>
                                <td><span id="pay_rate">{{ $results->computations_rate_per_day }}</span></td>
                                <th>End Date</th>
                                <td>{{ $results->schedule_to }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <form action="{{route('payroll_computations_employee_put', ['id' => $results->computations_id, 'employee_id' => $results->employee_id])}}" method="POST">
                        @csrf @method('PUT')
                        <table class="table">
                            <thead class="thead-light">
                            </thead>
                            <tbody>
                                <tr class="table-secondary">
                                    <th scope="row">Earnings</th>
                                    <td></td>
                                    <th></th>

                                </tr>

                                <tr>
                                    <th scope="row">No. Of Days Worked</th>
                                    <td>
                                        <input id="no_of_days_worked" type="text"
                                            class="form-control input-numbers @error('no_of_days_worked') is-invalid @enderror form-input"
                                            name="no_of_days_worked" value="{{ $results->computations_days_present }}" required
                                            autocomplete="no_of_days_worked" maxlength="50" autofocus>
                                    </td>

                                    <td>₱ <span id="span_days_worked" class="amounts for_gross">0.00</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Bonuses</th>
                                    <td><input id="bonuses" type="text"
                                            class="form-control input-numbers @error('bonuses') is-invalid @enderror form-input"
                                            name="bonuses" value="{{ $results->computations_bonus }}" required autocomplete="name"
                                            maxlength="50" autofocus></td>
                                    <td>₱ <span id="span_bonuses" class="for_gross amounts ">0.00</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">No. of hours Overtime</th>
                                    <td><input id="no_of_hours_overtime" type="text"
                                            class="form-control input-numbers @error('no_of_hours_overtime') is-invalid @enderror form-input"
                                            name="no_of_hours_overtime" value="{{  $results->computations_hours_overtime }}" required
                                            autocomplete="no_of_hours_overtime" maxlength="50" autofocus></td>

                                    <td>₱ <span id="hours_overtime" class="for_gross amounts">0.00</span></td>
                                </tr>
                                <tr>
                                    <th scope="row"></th>
                                    <td class="table-light"><span class="fw-bold">Gross Pay:</span></td>
                                    <td class="table-light">₱ <span id="gross_pay" class="amounts">0.00</span></td>
                                </tr>
                                <tr class="table-secondary">
                                    <th scope="row">Deductions</th>
                                    <td></td>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th scope="row">No. of Days Absent</th>
                                    <td><input id="no_of_days_absent" type="text"
                                            class="form-control input-numbers @error('no_of_days_absent') is-invalid @enderror form-input"
                                            name="no_of_days_absent" value="{{ $results->computations_days_absent }}" required
                                            autocomplete="no_of_days_absent" maxlength="50" autofocus></td>

                                    <td>₱ <span id="days_absent" class="amounts for_deductions">0.00</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">No. of hours late</th>
                                    <td><input id="no_hours_late" type="text"
                                            class="form-control input-numbers @error('no_hours_late') is-invalid @enderror form-input"
                                            name="no_hours_late" value="{{ $results->computations_hours_late }}" required
                                            autocomplete="name" maxlength="50" autofocus></td>
                                    <td>₱ <span id="hours_late" class="for_deductions amounts">0.00</span></td>
                                </tr>

                                @php
                                    $deductionList = [
                                        'sss' => [
                                            'name' => 'SSS',
                                            'amount' => 100,
                                            'is_fix' => '1'
                                        ],
                                        'pagibig' => [
                                            'name' => 'Pag-ibig',
                                            'amount' => 200,
                                            'is_fix' => '1'
                                        ],
                                        'philhealth' => [
                                            'name' => 'Philhealth',
                                            'amount' => 100,
                                            'is_fix' => '1'
                                        ],
                                        'others' => [
                                            'name' => 'Others',
                                            'amount' => 0,
                                            'is_fix' => '0'
                                        ],
                                    ];
                                @endphp

                                @foreach ($deductionList as $key => $deduction)
                                    <tr>
                                        <th scope="row">Deductions: {{ $deduction['name'] }}</th>
                                        <td><input id="deductions-{{$deduction['name']}}" type="text"
                                                class="form-control input-numbers @error("") is-invalid @enderror form-input input_deductions"
                                                data-name="deductions-{{$deduction['name']}}"
                                                name="deductions-{{$deduction['name']}}" value="{{ $deduction['amount'] }}" required autocomplete="deductions-{{$deduction['name']}}"
                                                {{ $deduction['is_fix'] == 1 ? 'readonly' : '' }}
                                                maxlength="6" autofocus></td>

                                        <td>₱ <span id="span_deductions-{{$deduction['name']}}" name="span_deductions-{{$deduction['name']}}" class="for_deductions amounts">{{ number_format((float)$deduction['amount'], 2, '.', '') }}</span></td>
                                    </tr>
                                @endforeach

                                    <tr>
                                        <th scope="row"></th>
                                        <td class="table-light"><span class="fw-bold">Total Deductions:</p>
                                        </td>
                                        <td class="table-light">₱ <span id="total_deductions" class="amounts">0.00</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"></th>
                                        <td class="table-light"><span class="fw-bold">Net Pay:</p>
                                        </td>
                                        <td class="table-light">₱ <span id="net_pay" class="amounts">0.00</span></td>
                                    </tr>
                            </tbody>
                        </table>
                        {{-- hidden --}}
                        <input type="hidden" name="employee_id" value="{{ $results->employee_id }}">
                        <input type="hidden" name="schedule_id" value="{{ $results->schedule_id }}">

                        <input type="hidden" name="input_amount_no_of_days_worked" id="input_amount_no_of_days_worked">
                        <input type="hidden" name="input_amount_bonuses" id="input_amount_bonuses">
                        <input type="hidden" name="input_amount_no_of_hours_overtime"
                            id="input_amount_no_of_hours_overtime">
                        <input type="hidden" name="input_gross" id="input_gross">

                        <input type="hidden" name="input_amount_no_of_days_absent" id="input_amount_no_of_days_absent">
                        <input type="hidden" name="input_amount_no_of_hours_late" id="input_amount_no_of_hours_late">
                        <input type="hidden" name="input_deduction_list_csv" id="input_deduction_list_csv">

                        <input type="hidden" name="input_amount_total_deductions" id="input_amount_total_deductions">
                        <input type="hidden" name="input_amount_net_pay" id="input_amount_net_pay">

                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script src="{{ asset('assets/tools/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/tools/DataTables/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            // DataTable
            var table = $('#example').DataTable({
                initComplete: function() {},
                dom: 'lBfrtip',
                responsive: true,
                scrollX: true,
                lengthChange: false,
            });

            $(".input-numbers").keypress(function(event) {
                return /\d/.test(String.fromCharCode(event.keyCode));
            });
            // Initial Computations
            computeInitialValues();
            computeNoOfDaysWorked($('#no_of_days_worked'));
            computeBonuses($('#bonuses'));
            computeNoOfHoursOvertime($('#no_of_hours_overtime'));
            computeDaysOfAbsent($('#no_of_days_absent'));
            computeNoHoursLate($('#no_hours_late'));
            computeDeductions();

            // GROSS
            $('#no_of_days_worked').keyup(function() {
                computeNoOfDaysWorked($(this));
            });

            function computeNoOfDaysWorked(el) {
                let value = parseFloat($(el).val()) * parseFloat($('#pay_rate').text());
                if (Number.isNaN(value) == true) {
                    value = 0;
                }
                $('#span_days_worked').text(value.toFixed(2))
                $('#input_amount_no_of_days_worked').val(value)
                computeGross();
            }

            $('#bonuses').keyup(function() {
                computeBonuses($(this));
            });

            function computeBonuses(el) {
                let value = parseFloat($(el).val());
                if (Number.isNaN(value) == true) {
                    value = 0.00;
                }
                $('#span_bonuses').text(value.toFixed(2))
                $('#input_amount_bonuses').val(value)
                computeGross();
            }

            $('#no_of_hours_overtime').keyup(function() {
                computeNoOfHoursOvertime($(this));

            });

            function computeNoOfHoursOvertime(el) {
                let value = parseFloat($(el).val());
                if (Number.isNaN(value) == true) {
                    value = 0.00;
                }
                $('#hours_overtime').text(value.toFixed(2))
                $('#input_amount_no_of_hours_overtime').val(value)
                computeGross();
            }

            function computeGross() {
                let sum = 0;
                $('.for_gross').each(function() {
                    sum += parseFloat($(this).text()); // Or this.innerHTML, this.innerText
                });
                $('#gross_pay').text(sum.toFixed(2))
                $('#input_gross').val(sum)
                computeNetPay()
            }
            // END GROSS

            // DEDUCTIONS
            $('#no_of_days_absent').keyup(function() {
                computeDaysOfAbsent($(this));
            });

            function computeDaysOfAbsent(el) {
                let value = parseFloat($(el).val());
                if (Number.isNaN(value) == true) {
                    value = 0.00;
                }
                $('#days_absent').text(value.toFixed(2))
                $('#input_amount_no_of_hours_late').val(value)
                computeDeductions();
            }

            $('#no_hours_late').keyup(function() {
                computeNoHoursLate($(this));
            });

            function computeNoHoursLate(el) {
                let value = parseFloat($(el).val());
                if (Number.isNaN(value) == true) {
                    value = 0.00;
                }
                $('#hours_late').text(value.toFixed(2))
                $('#input_amount_no_of_days_absent').val(value)
                computeDeductions();
            }

            $('.input_deductions').keyup(function() {
                console.log($(this).val())
                let value = parseFloat($(this).val());
                if (Number.isNaN(value) == true) {
                    value = 0.00;
                }
                let name = $(this).attr('data-name');
                $(`#span_${name}`).text(value.toFixed(2))
                $(`#span_${name}`).val(value)
                computeDeductions();
            });

            function computeDeductions() {
                let sum = 0;
                $('.for_deductions').each(function() {
                    sum += parseFloat($(this).text()); // Or this.innerHTML, this.innerText
                });
                if (Number.isNaN(sum) == true) {
                    sum = 0.00;
                }
                $('#total_deductions').text(sum.toFixed(2))
                $('#input_amount_total_deductions').val(sum)
                computeNetPay()
            }

            // END DEDUCTIONS

            // NET PAY
            function computeNetPay() {
                let net = 0;
                net = parseFloat($('#gross_pay').text()) - parseFloat($('#total_deductions').text())
                if (Number.isNaN(net) == true) {
                    net = 0.00;
                }
                $('#net_pay').text(net.toFixed(2))
                $('#input_amount_net_pay').val(net)
            }
            // END NET PAY

            function computeInitialValues() {
                computeDeductions();
                computeGross();
                computeNetPay();
            }
        });
    </script>
@endsection
