@extends('frontend.employee.master')

@section('title', 'My Subscriptions')

@section('body')

    <section class="bg-white forSmall smallTop">
        <a href=""><img src="{{ asset('/') }}frontend/employee/images/profile/leftArrowDark.png" alt="" class="me-2"> Subscription</a>
    </section>

    <!-- Main Content -->
    <div class="container container-main mt-md-5 mt-2 ">
        <!-- Left Side Menu -->
        @include('frontend.employee.jobs.left-menu')

        <!-- Right Scrollable Jobs -->
        <section class="w-100 profileOptionRight">
            <h1 class="forLarge">Subscription</h1>
            <div class="right-panel w-100 subscription">
                <div class="subscription-card">
                    <div class="subscription-info">
                        <h3>Current plan</h3>
                        <p>Monthly plan, expires on 20 April, 2025</p>
                    </div>
                    <button class="view-invoice">View invoice</button>
                </div>
            </div>



            <p class="mt-4 mb-0 fw-bold">Available Plans</p>
            <div class="right-panel w-100 subscriptionPlanDetails">

                <div class="planWrapper row justify-content-between">

                    <div class="col-12 col-md-6 planOne ">
                        <p class="olanDuration">6 Months Plan</p>
                        <h2 class="planPrive">Tk. 100</h2>

                        <button class="btn w-100 bg-dark text-white my-3">Subscribe</button>

                        <div class="subscription-card-body">
                            <p class="includes-title">This plan includes</p>
                            <ul class="plan-features">
                                <li><span class="checkmark"><img src="{{ asset('/') }}frontend/employee/images/profile/plan-featuresIcon.png" alt=""></span> Starter templates</li>
                                <li><span class="checkmark"><img src="{{ asset('/') }}frontend/employee/images/profile/plan-featuresIcon.png" alt=""></span> Foundational product analytics</li>
                                <li><span class="checkmark"><img src="{{ asset('/') }}frontend/employee/images/profile/plan-featuresIcon.png" alt=""></span> Campaign reporting</li>
                                <li><span class="checkmark"><img src="{{ asset('/') }}frontend/employee/images/profile/plan-featuresIcon.png" alt=""></span> Unlimited feature flags</li>
                                <li><span class="checkmark"><img src="{{ asset('/') }}frontend/employee/images/profile/plan-featuresIcon.png" alt=""></span> Unlimited sources & destinations</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 planOne">
                        <p class="olanDuration">Yearly Plan</p>
                        <h2 class="planPrive">Tk. 200</h2>

                        <button class="btn w-100 bg-dark text-white my-3">Subscribe</button>

                        <div class="subscription-card-body">
                            <p class="includes-title">This plan includes</p>
                            <ul class="plan-features">
                                <li><span class="checkmark"><img src="{{ asset('/') }}frontend/employee/images/profile/plan-featuresIcon.png" alt=""></span> Starter templates</li>
                                <li><span class="checkmark"><img src="{{ asset('/') }}frontend/employee/images/profile/plan-featuresIcon.png" alt=""></span> Foundational product analytics</li>
                                <li><span class="checkmark"><img src="{{ asset('/') }}frontend/employee/images/profile/plan-featuresIcon.png" alt=""></span> Campaign reporting</li>
                                <li><span class="checkmark"><img src="{{ asset('/') }}frontend/employee/images/profile/plan-featuresIcon.png" alt=""></span> Unlimited feature flags</li>
                                <li><span class="checkmark"><img src="{{ asset('/') }}frontend/employee/images/profile/plan-featuresIcon.png" alt=""></span> Unlimited sources & destinations</li>
                            </ul>
                        </div>
                    </div>

                </div>

            </div>


        </section>






    </div>



@endsection

