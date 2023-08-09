@extends('layout.design')

@section('contents')
    <style>
        .with-lapse {
            color: red;
        }
    </style>
    <div class="container">
        <h2 class="main-title">Dashboard</h2>
        <div class="row stat-cards">
            <div class="col-md-6 col-xl-3">
                <article class="stat-cards-item">
                    <div class="stat-cards-icon primary">
                        <iconify-icon icon="fluent:money-16-filled"></iconify-icon>
                    </div>
                    <div class="stat-cards-info">
                        <p class="stat-cards-info__num">&#8369;xxx</p>
                        <p class="stat-cards-info__title">Total Collections</p>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-xl-3">
                <article class="stat-cards-item">
                    <div class="stat-cards-icon warning">
                        <iconify-icon icon="fluent-mdl2:product-list"></iconify-icon>
                    </div>
                    <div class="stat-cards-info">
                        <p class="stat-cards-info__num">xxx</p>
                        <p class="stat-cards-info__title">Total Products</p>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-xl-3">
                <article class="stat-cards-item">
                    <div class="stat-cards-icon purple">
                        <iconify-icon icon="fa:group"></iconify-icon>
                    </div>
                    <div class="stat-cards-info">
                        <p class="stat-cards-info__num">{{ count($results['collectors']) }}</p>
                        <p class="stat-cards-info__title">Total Collectors</p>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-xl-3">
                <article class="stat-cards-item">
                    <div class="stat-cards-icon success">
                        <iconify-icon icon="mingcute:group-fill"></iconify-icon>
                    </div>
                    <div class="stat-cards-info">
                        <p class="stat-cards-info__num">{{ count($results['employees']) }}</p>
                        <p class="stat-cards-info__title">Total Employees</p>
                    </div>
                </article>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="users-table table-wrapper">
                    <table class="posts-table">
                        <thead style="padding-left:1em">
                            <tr class="users-table-info">
                                <th>ID</th>
                                <th>Collector's Name</th>
                                <th>Last Payment Date</th>
                                <th>Due Date</th>
                                <th>Lapse Days</th>
                                <th>Balance</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 0;
                                $today = Carbon\Carbon::now();
                            @endphp
                            @foreach ($results['payments'] as $key => $value)
                                @php
                                    $counter++;
                                        $lapseDays = Carbon\Carbon::hasFormat('Y-m-d', $value->payment_date)
                                            ? Carbon\Carbon::createFromFormat('Y-m-d', $value->payment_date)->diffInDays($today)
                                            : 0;
                                @endphp
                                <tr>
                                    <td>{{ $counter }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->payment_date ?? 'N/A' }}</td>
                                    <td>{{ $results['nextDueDate'] }}</td>
                                    <td class="with-lapse">{{ $lapseDays }} days</td>
                                    <td>₱ {{ number_format((float) $value->balance, 2, '.', '') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
