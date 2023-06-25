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
                                <td>{{ $results['employee']->fullname }}</td>
                                <th>Employee Code</th>
                                <td>{{ $results['employee']->employee_code }}</td>
                            </tr>

                            <tr>
                                <th scope="row">Position</th>
                                <td>{{ $results['employee']->position }}</td>
                                <th>Status</th>
                                <td>{{ $results['employee']->status }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Hired</th>
                                <td>{{ $results['employee']->date_hired }}</td>
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
                                <td>{{ $results['payroll_schedule']->name }}</td>
                                <th scope="row">Begin Date</th>
                                <td>{{ $results['payroll_schedule']->from }}</td>
                            </tr>

                            <tr>

                                <th>Pay Rate</th>
                                <td><span id="pay_rate">{{ $results['employee']->rate_per_day }}</span></td>
                                <th>End Date</th>
                                <td>{{ $results['payroll_schedule']->to }}</td>
                            </tr>
                        </tbody>
                    </table>


                    <form action="" method="">
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
                                            name="no_of_days_worked" value="{{ old('no_of_days_worked') }}" required
                                            autocomplete="no_of_days_worked" maxlength="50" autofocus>
                                    </td>

                                    <td><span id="span_days_worked" class="amounts for_gross">0.00</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Bonuses</th>
                                    <td><input id="bonuses" type="text"
                                            class="form-control input-numbers @error('bonuses') is-invalid @enderror form-input"
                                            name="bonuses" value="{{ old('bonuses') }}" required autocomplete="name"
                                            maxlength="50" autofocus></td>
                                    <td><span id="span_bonuses" class="for_gross amounts ">0.00</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">No. of hours Overtime</th>
                                    <td><input id="no_of_hours_overtime" type="text"
                                            class="form-control input-numbers @error('no_of_hours_overtime') is-invalid @enderror form-input"
                                            name="no_of_hours_overtime" value="{{ old('no_of_hours_overtime') }}" required
                                            autocomplete="no_of_hours_overtime" maxlength="50" autofocus></td>

                                    <td><span id="hours_overtime" class="for_gross amounts">0.00</span></td>
                                </tr>
                                <tr>
                                    <th scope="row"></th>
                                    <td class="table-light"><span class="fw-bold">Gross Pay:</span></td>
                                    <td class="table-light"><span id="gross_pay" class="amounts">0.00</span></td>
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
                                            name="no_of_days_absent" value="{{ old('no_of_days_absent') }}"
                                            required autocomplete="no_of_days_absent" maxlength="50" autofocus></td>

                                    <td><span id="days_absent" class="amounts for_deductions">0.00</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">No. of hours late</th>
                                    <td><input id="no_hours_late" type="text"
                                            class="form-control input-numbers @error('no_hours_late') is-invalid @enderror form-input"
                                            name="no_hours_late" value="{{ old('no_hours_late') }}"
                                            required autocomplete="name" maxlength="50" autofocus></td>
                                    <td><span id="hours_late" class="for_deductions amounts">0.00</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Deductions</th>
                                    <td><input id="name" type="text"
                                            class="form-control input-numbers @error('name') is-invalid @enderror form-input"
                                            name="name" value="{{ old('name') }}"
                                            required autocomplete="name" maxlength="50" autofocus></td>

                                    <td><span class="for_deductions amounts">0.00</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Deductions</th>
                                    <td><input id="name" type="text"
                                            class="form-control input-numbers @error('name') is-invalid @enderror form-input"
                                            name="name" value="{{ old('name') }}"
                                            required autocomplete="name" maxlength="50" autofocus></td>

                                    <td><span class="for_deductions amounts">0.00</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Deductions</th>
                                    <td><input id="name" type="text"
                                            class="form-control input-numbers @error('name') is-invalid @enderror form-input"
                                            name="name" value="{{ old('name') }}"
                                            required autocomplete="name" maxlength="50" autofocus></td>

                                    <td><span class="for_deductions amounts">0.00</span></td>
                                </tr>
                                <tr>
                                    <th scope="row"></th>
                                    <td class="table-light"><span class="fw-bold">Total Deductions:</p>
                                    </td>
                                    <td class="table-light"><span id="total_deductions" class="amounts">0.00</span></td>
                                </tr>
                                <tr>
                                    <th scope="row"></th>
                                    <td class="table-light"><span class="fw-bold">Net Pay:</p>
                                    </td>
                                    <td class="table-light"><span id="net_pay" class="amounts">0.00</span></td>
                                </tr>
                            </tbody>
                        </table>

                        <input type="text" name="employee_id" value="{{ $results['employee']->id }}">
                        <input type="text" name="schedule_id" value="{{ $results['payroll_schedule']->id }}">

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

            // GROSS
            $('#no_of_days_worked').keyup(function() {
                let value = parseFloat($(this).val()) * parseFloat($('#pay_rate').text());
                if (Number.isNaN(value) == true) {
                    value = 0;
                }
                $('#span_days_worked').text(value)
                computeGross();
            });

            $('#bonuses').keyup(function() {
                let value = parseFloat($(this).val());
                if (Number.isNaN(value) == true) {
                    value = 0.00;
                }
                $('#span_bonuses').text(value)
                computeGross();
            });

            $('#no_of_hours_overtime').keyup(function() {
                let value = parseFloat($(this).val());
                if (Number.isNaN(value) == true) {
                    value = 0.00;
                }
                $('#hours_overtime').text(value)
                computeGross();

            });

            $('#no_of_hours_overtime').keyup(function() {
                let value = parseFloat($(this).val());
                if (Number.isNaN(value) == true) {
                    value = 0.00;
                }
                $('#hours_overtime').text(value)
                computeGross();
            });

            function computeGross() {
                let sum = 0;
                $('.for_gross').each(function() {
                    sum += parseFloat($(this).text()); // Or this.innerHTML, this.innerText
                });
                $('#gross_pay').text(sum)
                computeNetPay()
            }
            // END GROSS

            // DEDUCTIONS
            $('#no_of_days_absent').keyup(function() {
                let value = parseFloat($(this).val());
                if (Number.isNaN(value) == true) {
                    value = 0.00;
                }
                $('#days_absent').text(value)
                computeDeductions();
            });

            $('#no_hours_late').keyup(function() {
                let value = parseFloat($(this).val());
                if (Number.isNaN(value) == true) {
                    value = 0.00;
                }
                $('#hours_late').text(value)
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
                $('#total_deductions').text(sum)
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
                $('#net_pay').text(net)
            }
            // END NET PAY
        });
    </script>
@endsection
