@extends('frontend.employee.master')

@section('title', 'My Subscriptions')

@section('body')

    <!-- Mobile Back Header -->
    <section class="bg-white forSmall smallTop sub-mobile-back">
        <a href="{{ route('employee.my-profile') }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#141c25" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            {{ trans('employee.subscription') }}
        </a>
    </section>

    <!-- Main Content -->
    <div class="container container-main mt-md-5 mt-2">
        <!-- Left Side Menu -->
        @include('frontend.employee.jobs.left-menu')

        <!-- Right Content -->
        <section class="w-100 profileOptionRight sub-content">

            <!-- Page Header -->
            <div class="sub-page-header forLarge">
                <div class="sub-header-text">
                    <h1>{{ trans('employee.subscription') }}</h1>
                    <p>Manage your plan and billing</p>
                </div>
            </div>

            <!-- Current Plan Banner -->
            @php
                $hasSubscription = isset($loggedUser?->subscriptionPlan?->title);
                $isExpired = $hasSubscription && $loggedUser->subscription_end_date && \Illuminate\Support\Carbon::parse($loggedUser->subscription_end_date)->isPast();
            @endphp

            <div class="sub-current-plan {{ $isExpired ? 'sub-plan-expired' : '' }}">
                <div class="sub-current-plan-glow"></div>
                <div class="sub-current-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                </div>
                <div class="sub-current-info">
                    @if($hasSubscription)
                        <span class="sub-current-label">{{ $isExpired ? 'Expired Plan' : 'Active Plan' }}</span>
                        <span class="sub-current-title">{{ $loggedUser?->subscriptionPlan?->title ?? 'Plan Title' }}</span>
                    @else
                        <span class="sub-current-label">Plan Status</span>
                        <span class="sub-current-title">No Active Plan</span>
                    @endif
                </div>
                <div class="sub-current-expiry">
                    @if($hasSubscription && $loggedUser->subscription_end_date)
                        @if($isExpired)
                            <span class="sub-expiry-label sub-expiry-expired">Expired on</span>
                            <span class="sub-expiry-date sub-date-expired">{{ \Illuminate\Support\Carbon::parse($loggedUser->subscription_end_date)->format('d M, Y') }}</span>
                        @else
                            <span class="sub-expiry-label">Expires on</span>
                            <span class="sub-expiry-date">{{ \Illuminate\Support\Carbon::parse($loggedUser->subscription_end_date)->format('d M, Y') }}</span>
                        @endif
                    @else
                        <span class="sub-expiry-no-plan">NO ACTIVE PLAN</span>
                    @endif
                </div>
            </div>

            <!-- Available Plans Section -->
            <div class="sub-plans-section">
                <div class="sub-plans-title">
                    <h2>Available Plans</h2>
                    <p>Choose the plan that fits your career goals</p>
                </div>

                <div class="sub-plans-grid">
                    @forelse($subscriptionPlans as $key => $subscriptionPlan)
                        @php
                            $isCurrentPlan = $subscriptionPlan->id == $loggedUser->subscription_plan_id;
                        @endphp
                        <div class="sub-plan-card {{ $isCurrentPlan ? 'sub-plan-active' : '' }}">
                            @if($isCurrentPlan)
                                <div class="sub-plan-badge">Current Plan</div>
                            @endif

                            <div class="sub-plan-header">
                                <span class="sub-plan-name">{{ $subscriptionPlan->title ?? '' }}</span>
                                <div class="sub-plan-price">
                                    <span class="sub-price-currency">Tk.</span>
                                    <span class="sub-price-amount">{{ $subscriptionPlan->price ?? 0 }}</span>
                                </div>
                                <span class="sub-plan-duration">
                                    {{ $subscriptionPlan->duration_in_days ?? 0 }} days access
                                </span>
                            </div>

                            <div class="sub-plan-divider"></div>

                            <div class="sub-plan-features">
                                <span class="sub-features-label">This plan includes</span>
                                <div class="sub-features-content">
                                    {!! $subscriptionPlan->plan_features ?? '' !!}
                                </div>
                            </div>

                            <div class="sub-plan-footer">
                                @if(!$isCurrentPlan)
                                    <form id="subsForm{{ $key }}" action="{{ route('buy-subscription', $subscriptionPlan->id) }}" method="post" onsubmit="return confirm('Are you sure you want to purchase this plan? Your previous plan will be replaced if one exists.')">
                                        @csrf
                                        <button type="submit" class="sub-purchase-btn">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                                            Subscribe Now
                                        </button>
                                    </form>
                                @else
                                    <button type="button" disabled class="sub-purchased-btn">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        Already Purchased
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="sub-empty-state">
                            <div class="sub-empty-icon">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cfd2d9" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                            </div>
                            <h3>No Subscription Plans Available</h3>
                            <p>Check back later for new plans</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </section>
    </div>

@endsection

@push('style')
    <style>
        /* ================================================
           MY SUBSCRIPTIONS REDESIGN — Scoped with .sub- prefix
           ================================================ */

        .sub-mobile-back a {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            color: #141c25;
            padding: 16px 20px;
        }

        /* --- Sidebar Navigation (shared) --- */
        .sj-sidebar {
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            border: 1px solid #f0f1f3;
            box-shadow: 0 1px 3px rgba(20,28,37,.04), 0 6px 16px rgba(20,28,37,.03);
            padding: 8px !important;
        }

        .sj-nav-link {
            border-radius: 10px !important;
            padding: 14px 16px !important;
            margin-bottom: 2px;
            transition: all .2s ease !important;
            text-decoration: none !important;
            border-bottom: none !important;
        }

        .sj-nav-link:hover {
            background: #f8f9fa !important;
        }

        .sj-nav-link .d-flex {
            gap: 14px;
        }

        .sj-nav-icon {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            border-radius: 10px;
            color: #667080;
            flex-shrink: 0;
            margin-right: 0 !important;
            transition: all .2s ease;
        }

        .sj-nav-link:hover .sj-nav-icon {
            background: #FFF8E1;
            color: #d4a017;
        }

        .sj-nav-link .text {
            font-weight: 500 !important;
            font-size: 15px !important;
            color: #484f5b !important;
        }

        .sj-nav-active {
            background: #FFFBEB !important;
            border-left: none !important;
        }

        .sj-nav-active .sj-nav-icon {
            background: #FFCB11 !important;
            color: #141c25 !important;
        }

        .sj-nav-active .text {
            font-weight: 700 !important;
            color: #141c25 !important;
        }

        /* --- Page Header --- */
        .sub-page-header {
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f1f3;
        }

        .sub-header-text h1 {
            font-size: 26px;
            font-weight: 800;
            color: #141c25;
            margin: 0 0 4px;
            letter-spacing: -0.3px;
        }

        .sub-header-text p {
            font-size: 14px;
            color: #7c8391;
            margin: 0;
        }

        /* --- Current Plan Banner --- */
        .sub-current-plan {
            position: relative;
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 22px 28px;
            background: linear-gradient(135deg, #141c25 0%, #1e2a36 100%);
            border-radius: 16px;
            margin-bottom: 32px;
            overflow: hidden;
        }

        .sub-current-plan-glow {
            position: absolute;
            top: -30px;
            right: -30px;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, rgba(255,203,17,.25) 0%, transparent 70%);
            pointer-events: none;
        }

        .sub-current-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,203,17,.15);
            border-radius: 12px;
            color: #FFCB11;
            flex-shrink: 0;
        }

        .sub-current-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
            flex: 1;
            min-width: 0;
        }

        .sub-current-label {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255,255,255,.5);
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .sub-current-title {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sub-current-expiry {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 2px;
            flex-shrink: 0;
        }

        .sub-expiry-label {
            font-size: 11px;
            font-weight: 600;
            color: rgba(255,255,255,.4);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sub-expiry-date {
            font-size: 15px;
            font-weight: 600;
            color: #FFCB11;
        }

        .sub-expiry-expired {
            color: rgba(255,120,120,.6) !important;
        }

        .sub-date-expired {
            color: #ff7878 !important;
        }

        .sub-expiry-no-plan {
            font-size: 12px;
            font-weight: 700;
            color: rgba(255,255,255,.35);
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 6px 14px;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 8px;
        }

        .sub-plan-expired {
            background: linear-gradient(135deg, #1e1215 0%, #241a1e 100%) !important;
        }

        .sub-plan-expired .sub-current-plan-glow {
            background: radial-gradient(circle, rgba(255,120,120,.15) 0%, transparent 70%);
        }

        .sub-plan-expired .sub-current-icon {
            background: rgba(255,120,120,.12);
            color: #ff7878;
        }

        /* --- Plans Section --- */
        .sub-plans-section {
            margin-bottom: 24px;
        }

        .sub-plans-title {
            margin-bottom: 20px;
        }

        .sub-plans-title h2 {
            font-size: 19px;
            font-weight: 750;
            color: #141c25;
            margin: 0 0 4px;
        }

        .sub-plans-title p {
            font-size: 14px;
            color: #7c8391;
            margin: 0;
        }

        /* --- Plans Grid --- */
        .sub-plans-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        @keyframes subFadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .sub-plan-card {
            position: relative;
            background: #fff;
            border: 1px solid #f0f1f3;
            border-radius: 16px;
            padding: 32px 28px;
            box-shadow: 0 1px 3px rgba(20,28,37,.04), 0 6px 16px rgba(20,28,37,.03);
            display: flex;
            flex-direction: column;
            transition: all .25s ease;
            animation: subFadeUp .45s ease both;
        }

        .sub-plan-card:nth-child(1) { animation-delay: 0s; }
        .sub-plan-card:nth-child(2) { animation-delay: .06s; }
        .sub-plan-card:nth-child(3) { animation-delay: .12s; }
        .sub-plan-card:nth-child(4) { animation-delay: .18s; }

        .sub-plan-card:hover {
            border-color: #e4e5e9;
            box-shadow: 0 2px 6px rgba(20,28,37,.06), 0 12px 28px rgba(20,28,37,.06);
            transform: translateY(-2px);
        }

        .sub-plan-active {
            border-color: #FFCB11 !important;
            background: linear-gradient(180deg, #FFFDF5 0%, #fff 40%);
        }

        /* --- Plan Badge --- */
        .sub-plan-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            padding: 4px 12px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: #FFCB11;
            color: #141c25;
            border-radius: 20px;
        }

        /* --- Plan Header --- */
        .sub-plan-header {
            margin-bottom: 20px;
        }

        .sub-plan-name {
            display: block;
            font-size: 15px;
            font-weight: 600;
            color: #667080;
            margin-bottom: 10px;
        }

        .sub-plan-price {
            display: flex;
            align-items: baseline;
            gap: 4px;
            margin-bottom: 6px;
        }

        .sub-price-currency {
            font-size: 16px;
            font-weight: 600;
            color: #8c919d;
        }

        .sub-price-amount {
            font-size: 38px;
            font-weight: 800;
            color: #141c25;
            line-height: 1;
            letter-spacing: -1px;
        }

        .sub-plan-duration {
            font-size: 13px;
            color: #8c919d;
            font-weight: 500;
        }

        /* --- Plan Divider --- */
        .sub-plan-divider {
            height: 1px;
            background: #f0f1f3;
            margin-bottom: 20px;
        }

        /* --- Plan Features --- */
        .sub-plan-features {
            flex: 1;
            margin-bottom: 24px;
        }

        .sub-features-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #141c25;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .sub-features-content {
            font-size: 14px;
            color: #556070;
            line-height: 1.7;
        }

        .sub-features-content ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sub-features-content ul li {
            position: relative;
            padding-left: 22px;
            margin-bottom: 10px;
            color: #556070;
            font-size: 14px;
        }

        .sub-features-content ul li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 6px;
            width: 12px;
            height: 12px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2322c55e' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='20 6 9 17 4 12'/%3E%3C/svg%3E") no-repeat center center;
            background-size: contain;
        }

        .sub-features-content p {
            margin: 0 0 6px;
            color: #556070;
        }

        /* --- Plan Footer / Buttons --- */
        .sub-plan-footer {
            margin-top: auto;
        }

        .sub-plan-footer form {
            margin: 0;
        }

        .sub-purchase-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 14px 24px;
            font-size: 15px;
            font-weight: 700;
            color: #141c25;
            background: #FFCB11;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .sub-purchase-btn:hover {
            background: #f0be00;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(255,203,17,.35);
        }

        .sub-purchase-btn:active {
            transform: translateY(0);
        }

        .sub-purchased-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 14px 24px;
            font-size: 15px;
            font-weight: 600;
            color: #8c919d;
            background: #f3f4f6;
            border: 1px solid #e8e9ec;
            border-radius: 12px;
            cursor: default;
        }

        /* --- Empty State --- */
        .sub-empty-state {
            grid-column: 1 / -1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 72px 24px;
            text-align: center;
        }

        .sub-empty-icon {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            background: #f8f9fb;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .sub-empty-state h3 {
            font-size: 18px;
            font-weight: 700;
            color: #141c25;
            margin: 0 0 6px;
        }

        .sub-empty-state p {
            font-size: 14px;
            color: #8c919d;
            margin: 0;
        }

        /* ================================================
           RESPONSIVE
           ================================================ */

        @media (max-width: 991px) {
            .sub-plans-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }

        @media (max-width: 768px) {
            .sub-current-plan {
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
                padding: 20px;
                border-radius: 14px;
                margin-bottom: 24px;
            }

            .sub-current-expiry {
                align-items: flex-start;
                flex-direction: row;
                gap: 6px;
            }

            .sub-expiry-label {
                display: none;
            }

            .sub-current-info {
                gap: 1px;
            }

            .sub-current-title {
                font-size: 16px;
            }

            .sub-current-icon {
                width: 42px;
                height: 42px;
            }

            .sub-plan-card {
                padding: 24px 20px;
                border-radius: 14px;
            }

            .sub-price-amount {
                font-size: 32px;
            }

            .sub-plans-title h2 {
                font-size: 17px;
            }

            .sub-purchase-btn,
            .sub-purchased-btn {
                padding: 12px 20px;
                font-size: 14px;
                border-radius: 10px;
            }
        }

        @media (max-width: 480px) {
            .sub-plan-card {
                padding: 20px 16px;
            }

            .sub-price-amount {
                font-size: 28px;
            }
        }
    </style>
@endpush
