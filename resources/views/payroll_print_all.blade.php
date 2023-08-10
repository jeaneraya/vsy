{{-- @extends('layout.design') --}}

{{-- @section('contents') --}}
<script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
<style>
    body {
        font-family: 'Courier New', monospace;
        font-size: 1em;
        /* color: red; */
        /* margin: 0;
        padding: 0; */
    }

    /* @media print and (width: 21cm) and (height: 29.7cm) {
        @page {
            margin: 3cm;
        }
    } */

    /* style sheet for "letter" printing */
    @media print and (orientation: landscape) {
        @page {
            /* margin: 1in; */

        }

        html,
        body,td,th {
            height: 100%;
            font-size: 0.65em;
        }

        .pagebreak {
            clear: both;
            page-break-after: always;
            min-height: 1px;
        }
        .table-responsive-sm {
            height: 45%;
        }
        table {
            width: 100%;
        }
    }

    @media print and (orientation: portrait) {
    /* @media print and (orientation: portrait) { */

        /* @page {size: A4 portrait; } */
        .table-responsive-sm {
            height: 50vh;
        }

        html,
        body,td,th {
            height: 100%;
            /* font-size: 1em; */
            font-size: 0.65em;
        }

        .pagebreak {
            clear: both;
            page-break-after: always;
            min-height: 1px;
        }

        table {
            width: 100%;
        }

    }
</style>

<body>
    @php
        $counter = 0;
    @endphp
    @foreach ($result as $key => $results)
    @php
        $counter++;
    @endphp
        <div class="table-responsive-sm">
            VSY Enterprise
            <table style="width:100%">
                <tr>
                    <td colspan="2" align="left">
                        <b><u>Employee Information</u></b>
                    </td>
                </tr>
                <tr>
                    <td align="left">Name</td>
                    <td align="left">: {{ $results->employee_full_name}} </td>
                    <td align="left">Employee Code</td>
                    <td align="left">: {{ $results->employee_code }}</td>
                </tr>
                <tr>
                    <td align="left">Position</td>
                    <td align="left">: {{ $results->employee_position }}</td>
                    <td align="left">Hired</td>
                    <td align="left">: {{ $results->employee_date_hired }}</td>
                </tr>
                <tr>
                    <td colspan="2" align="left">
                        <b><u>Payroll</u></b>
                    </td>
                </tr>
                <tr>
                    <td align="left">Period</td>
                    <td align="left">: {{ $results->schedule_name }}</td>
                    <td align="left">Begin Date</td>
                    <td align="left">: {{ $results->schedule_from }}</td>
                </tr>
                <tr>
                    <td align="left">Pay Rate</td>
                    <td align="left">: ₱ {{  number_format((float) $results->computations_rate_per_day, 2, '.', '')  }}</td>
                    <td align="left">End Date</td>
                    <td align="left">: {{ $results->schedule_to }}</td>
                </tr>
            </table>
            <table style="width:70%">
                <tr>
                    <td align="left"><b><u>Earnings</u></b></td>
                </tr>
                <tr>
                    <td align="left">No. Of days Worked</td>
                    <td align="left">{{$results->computations_days_present}} day/s</td>
                    <td align="left">₱ {{  number_format((float) $results->computations_days_present * $results->computations_rate_per_day, 2, '.', '')  }}</td>
                </tr>
                <tr>
                    <td align="left">Bonuses</td>
                    <td align="left"></td>
                    <td align="left"><u>₱ {{  number_format((float) $results->computations_bonus, 2, '.', '')  }}</u></td>
                </tr>
                <tr>
                    <td align="left"></td>
                    <th align="left">Gross Pay</th>
                    <td align="left">₱ {{  number_format((float) $results->computations_gross, 2, '.', '')  }}</td>
                </tr>
                <tr>
                    <td align="left"><b><u>Deductions</u></b></td>
                </tr>
                <tr>
                    <td align="left">No. Of days Absent</td>
                    <td align="left">{{  $results->computations_days_absent }} day/s</td>
                    <td align="left">₱ {{  number_format((float) $results->computations_days_absent * $results->computations_rate_per_day, 2, '.', '')  }}</td>
                </tr>
                <tr>
                    <td align="left">SSS</td>
                    <td align="left"></td>
                    <td align="left">₱ {{  number_format((float) $results->computations_sss, 2, '.', '')  }}</td>
                </tr>
                <tr>
                    <td align="left">Pag-ibig</td>
                    <td align="left"></td>
                    <td align="left">₱ {{  number_format((float) $results->computations_pagibig, 2, '.', '')  }}</td>
                </tr>
                <tr>
                    <td align="left">Philhealth</td>
                    <td align="left"></td>
                    <td align="left">₱ {{  number_format((float) $results->computations_philhealth, 2, '.', '')  }}</td>
                </tr>
                <tr>
                    <td align="left">Others</td>
                    <td align="left"></td>
                    <td align="left"><u>₱ {{  number_format((float) $results->computations_others, 2, '.', '')  }}</u></td>
                </tr>
                <tr>
                    <td align="left"></td>
                    <th align="left">Total Deductions</th>
                    <td align="left">₱ {{  number_format((float) $results->computations_total_deductions, 2, '.', '')  }}</td>
                </tr>
                <tr>
                    <td align="left"></td>
                    <th align="left">Net Pay</th>
                    <td align="left">₱ {{  number_format((float) $results->computations_net_pay, 2, '.', '')  }}</td>
                </tr>
            </table>
        </div>
        @if ($counter % 2 != 0)
            <hr>
        @else
            @if (count($result) > $counter)
                <div class="pagebreak"> </div>
            @endif
        @endif
    @endforeach
</body>
<script>
    $(document).ready(function() {
        window.print();
    });
</script>
