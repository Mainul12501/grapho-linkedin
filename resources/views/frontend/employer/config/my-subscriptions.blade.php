@extends('frontend.employer.master')

@section('title', 'My Subscriptions')

@section('body')


    <!-- Main Content -->
    <div class="container container-main mt-md-5 mt-2 ">
        <!-- Left Side Menu -->
{{--        @include('frontend.employee.jobs.left-menu')--}}

        <!-- Right Scrollable Jobs -->
        <section class="w-100 profileOptionRight card card-body">
            <h1 class="forLarge">{{ trans('employee.subscription') }}</h1>
            @if(isset($loggedUser?->subscriptionPlan?->title))
                <div class="right-panel w-100 subscription">
                    <div class="subscription-card">
                        <div class="subscription-info">
                            <p class="fw-bold float-start">{{ trans('employee.subscription') }} : </p>
                            <p class="float-start">{{ $loggedUser?->subscriptionPlan?->title ?? 'Plan Title' }}, expires on {{ \Illuminate\Support\Carbon::parse($loggedUser->subscription_end_date)->format('d M, Y') }}</p>
                        </div>
{{--                        <button class="view-invoice">View invoice</button>--}}
                    </div>
                </div>
            @endif




            <p class="mb-4 fw-bold f-s-26">Available Plans</p>
            <div class="right-panel w-100 subscriptionPlanDetails pb-5">

                <div class="planWrapper row <!--justify-content-between-->">

                    @forelse($subscriptionPlans as $key => $subscriptionPlan)
                        <div class="col-12 col-md-4 planOne py-2">
                            <div class="card card-body p-4">
                                <p class="olanDuration">{{ $subscriptionPlan->title ?? '' }}</p>
                                <h2 class="planPrive">Tk. {{ $subscriptionPlan->price ?? 0 }}</h2>

                                @if($subscriptionPlan->id != $loggedUser->subscription_plan_id)
                                    <form id="subsForm{{$key}}" action="{{ route('buy-subscription', $subscriptionPlan->id) }}" method="post">
                                        @csrf
                                        <button type="submit" onsubmit="return confirm('Are you sure to Purchase this plan. Your previous plan will be replaced if exists.')" class="btn w-100 text-white my-3 py-3" style="background-color: #FFCB11; color: black!important; border-radius: 20px;">{{ trans('employee.subscription') }}</button>
                                    </form>
                                @else
                                    <button type="button" disabled class="btn w-100 bg-dark text-white my-3 py-3" style="border-radius: 20px">Already Purchased</button>
                                @endif


                                <div class="subscription-card-body">
                                    <p class="includes-title">This plan includes</p>
                                    <p class="" style="text-align: justify">{!! $subscriptionPlan->plan_features ?? '' !!}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 planOne">
                            <p class="f-s-26 text-center">No Subscription Plan Found</p>
                        </div>
                    @endforelse


{{--                    <div class="col-12 col-md-6 planOne">--}}
{{--                        <p class="olanDuration">Yearly Plan</p>--}}
{{--                        <h2 class="planPrive">Tk. 200</h2>--}}

{{--                        <button class="btn w-100 bg-dark text-white my-3">Subscribe</button>--}}

{{--                        <div class="subscription-card-body">--}}
{{--                            <p class="includes-title">This plan includes</p>--}}
{{--                            <ul class="plan-features">--}}
{{--                                <li><span class="checkmark"><img src="{{ asset('/') }}frontend/employee/images/profile/plan-featuresIcon.png" alt=""></span> Starter templates</li>--}}
{{--                                <li><span class="checkmark"><img src="{{ asset('/') }}frontend/employee/images/profile/plan-featuresIcon.png" alt=""></span> Foundational product analytics</li>--}}
{{--                                <li><span class="checkmark"><img src="{{ asset('/') }}frontend/employee/images/profile/plan-featuresIcon.png" alt=""></span> Campaign reporting</li>--}}
{{--                                <li><span class="checkmark"><img src="{{ asset('/') }}frontend/employee/images/profile/plan-featuresIcon.png" alt=""></span> Unlimited feature flags</li>--}}
{{--                                <li><span class="checkmark"><img src="{{ asset('/') }}frontend/employee/images/profile/plan-featuresIcon.png" alt=""></span> Unlimited sources & destinations</li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            var maxHeight = 0;

            // First, find the max height
            $('.planOne').each(function () {
                var height = $(this).outerHeight();
                console.log(height);
                if (height > maxHeight) {
                    maxHeight = height;
                }
            });

            // Then, set that height to all planOne elements
            $('.planOne .card-body').css('height', maxHeight + 'px');
        });

    </script>
@endpush

@push('style')

@endpush
