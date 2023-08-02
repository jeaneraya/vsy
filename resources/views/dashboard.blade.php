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
                        <p class="stat-cards-info__num">&#8369; {{number_format($results['total_collection'],2)}}</p>
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
                        <p class="stat-cards-info__num">{{count($results['products'])}}</p>
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


        
    </div>
@endsection
