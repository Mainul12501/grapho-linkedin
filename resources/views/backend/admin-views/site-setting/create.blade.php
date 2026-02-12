@extends('backend.master')

@section('title', 'Basic Setting')
@section('breadcrumb', 'Basic Setting')

@section('body')

    <div class="row py-5">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-white float-start">Basic Setting</h4>
{{--                    <a href="{{ route('gas-stations.index') }}" class="text-white float-end f-s-20">--}}
{{--                        <i class="mdi mdi-page-previous-outline"></i>--}}
{{--                    </a>--}}
                </div>
                <div class="card-body">
                    <form action="{{ isset($basicSetting) ? route('site-settings.update', $basicSetting->id) : route('site-settings.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if(isset($basicSetting))
                            @method('put')
                        @endif
                        <div class="row ">
                            <div class="col-md-6">
                                <label for="">Title Text <span class="text-danger">(required)</span></label>
                                <input type="text" name="site_title" {{ isset($isShown) ? 'readonly' : '' }} class="form-control" value="{{ isset($basicSetting) ? $basicSetting->site_title : '' }}" />
                            </div>
                            <div class="col-md-6">
                                <label for="">Site Name <span class="text-danger">(required)</span></label>
                                <input type="text" name="site_name" {{ isset($isShown) ? 'readonly' : '' }} class="form-control" value="{{ isset($basicSetting) ? $basicSetting->site_name : 'Grapho' }}" />
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">Meta Title </label>
                                <input type="text" name="meta_title" {{ isset($isShown) ? 'readonly' : '' }} class="form-control" value="{{ isset($basicSetting) ? $basicSetting->meta_title : '' }}" />
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">Mobile Number </label>
                                <input type="text" name="mobile" {{ isset($isShown) ? 'readonly' : '' }} class="form-control" value="{{ isset($basicSetting) ? $basicSetting->mobile : '' }}" />
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">Email </label>
                                <input type="text" name="email" {{ isset($isShown) ? 'readonly' : '' }} class="form-control" value="{{ isset($basicSetting) ? $basicSetting->email : '' }}" />
                            </div>
                        </div>
                        <div class="row mt-2">
{{--                            <div class="col-md-6 mt-2">--}}
{{--                                <label for="">Site Moto</label>--}}
{{--                                <textarea name="site_moto" {{ isset($isShown) ? 'disabled' : '' }} class="form-control summernote" id="elm1" cols="30" rows="2">{!! isset($basicSetting) ? $basicSetting->site_moto : '' !!}</textarea>--}}
{{--                            </div>--}}
                            <div class="col-md-6 mt-2">
                                <label for="">Site Footer Info</label>
                                <textarea name="site_description" {{ isset($isShown) ? 'disabled' : '' }} class="form-control summernote" id="elm1" cols="30" rows="2">{!! isset($basicSetting) ? $basicSetting->site_description : '' !!}</textarea>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Meta Description</label>
                                <textarea name="meta_description" {{ isset($isShown) ? 'disabled' : '' }} class="form-control summernote" id="elm1" cols="30" rows="2">{!! isset($basicSetting) ? $basicSetting->meta_description : '' !!}</textarea>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Office Address</label>
                                <textarea name="office_address" {{ isset($isShown) ? 'disabled' : '' }} class="form-control summernote" id="elm1" cols="30" rows="2">{!! isset($basicSetting) ? $basicSetting->office_address : '' !!}</textarea>
                            </div>
                        </div>
{{--                        <div class="mt-2">--}}
{{--                            <label for="">Office Address</label>--}}
{{--                            <textarea name="address" {{ isset($isShown) ? 'disabled' : '' }} class="form-control summernote" id="elm1" cols="30" rows="2">{!! isset($basicSetting) ? $basicSetting->address : '' !!}</textarea>--}}
{{--                        </div>--}}

                        <div class="mt-2">
                            <label for="">SEO Meta Header</label>
                            <textarea name="meta_header" {{ isset($isShown) ? 'disabled' : '' }} class="form-control" id="elm1" cols="30" rows="2">{!! isset($basicSetting) ? $basicSetting->meta_header : '' !!}</textarea>
                        </div>
                        <div class="mt-2">
                            <label for="">SEO Meta Footer</label>
                            <textarea name="meta_footer" {{ isset($isShown) ? 'disabled' : '' }} class="form-control" id="elm1" cols="30" rows="2">{!! isset($basicSetting) ? $basicSetting->meta_footer : '' !!}</textarea>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6 mt-2">
                                <label for="">FB Profile Link</label>
                                <input type="text" name="fb" {{ isset($isShown) ? 'readonly' : '' }} class="form-control" value="{{ isset($basicSetting) ? $basicSetting->fb : '' }}" />
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">X Profile Link</label>
                                <input type="text" name="x_link" {{ isset($isShown) ? 'readonly' : '' }} class="form-control" value="{{ isset($basicSetting) ? $basicSetting->x_link : '' }}" />
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Instagram Profile Link</label>
                                <input type="text" name="insta" {{ isset($isShown) ? 'readonly' : '' }} class="form-control" value="{{ isset($basicSetting) ? $basicSetting->insta : '' }}" />
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Youtube Link</label>
                                <input type="text" name="youtube" {{ isset($isShown) ? 'readonly' : '' }} class="form-control" value="{{ isset($basicSetting) ? $basicSetting->youtube : '' }}" />
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Tik Talk Profile Link</label>
                                <input type="text" name="tiktalk" {{ isset($isShown) ? 'readonly' : '' }} class="form-control" value="{{ isset($basicSetting) ? $basicSetting->tiktalk : '' }}" />
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6 mt-2">
                                <label for="">APK Link</label>
                                <input type="text" name="apk_link" {{ isset($isShown) ? 'readonly' : '' }} class="form-control" value="{{ isset($basicSetting) ? $basicSetting->apk_link : '' }}" />
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">APK Latest Version</label>
                                <input type="text" name="apk_latest_version" {{ isset($isShown) ? 'readonly' : '' }} class="form-control" value="{{ isset($basicSetting) ? $basicSetting->apk_latest_version : '' }}" />
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">IOS Link</label>
                                <input type="text" name="ios_link" {{ isset($isShown) ? 'readonly' : '' }} class="form-control" value="{{ isset($basicSetting) ? $basicSetting->ios_link : '' }}" />
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">IOS Latest Version</label>
                                <input type="text" name="ios_latest_version" {{ isset($isShown) ? 'readonly' : '' }} class="form-control" value="{{ isset($basicSetting) ? $basicSetting->ios_latest_version : '' }}" />
                            </div>
                        </div>
                        <div class="row mt-2">
{{--                            <div class="col-md-6 mt-2">--}}
{{--                                <label for="">Logo</label>--}}
{{--                                @if(!isset($isShown))--}}
{{--                                    <input type="file" name="logo" class="form-control" accept="image/*" />--}}
{{--                                @endif--}}
{{--                                @if(isset($basicSetting->logo))--}}
{{--                                    <img src="{{ asset($basicSetting->logo) }}" alt="" style="height: 60px" />--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6 mt-2">--}}
{{--                                <label for="">Banner</label>--}}
{{--                                @if(!isset($isShown))--}}
{{--                                    <input type="file" name="banner" class="form-control" accept="image/*" />--}}
{{--                                @endif--}}
{{--                                @if(isset($basicSetting->banner))--}}
{{--                                    <img src="{{ asset($basicSetting->banner) }}" alt="" style="height: 60px" />--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6 mt-2">--}}
{{--                                <label for="">Site Icon</label>--}}
{{--                                @if(!isset($isShown))--}}
{{--                                    <input type="file" name="site_icon" class="form-control" accept="image/*" />--}}
{{--                                @endif--}}
{{--                                @if(isset($basicSetting->site_icon))--}}
{{--                                    <img src="{{ asset($basicSetting->site_icon) }}" alt="" style="height: 60px" />--}}
{{--                                @endif--}}
{{--                            </div>--}}
                            <div class="col-md-6 mt-2">
                                <label for="">Favicon</label>
                                @if(!isset($isShown))
                                    <input type="file" name="favicon" class="form-control" accept="image/vnd.microsoft.icon" />
                                @endif
                                @if(isset($basicSetting->favicon))
                                    <img src="{{ asset($basicSetting->favicon) }}" alt="" style="height: 16px" />
                                @endif
                            </div>
{{--                            <div class="col-md-6 mt-2">--}}
{{--                                <label for="">Common Institute Icon</label>--}}
{{--                                @if(!isset($isShown))--}}
{{--                                    <input type="file" name="common_institute_logo" class="form-control" accept="image/*" />--}}
{{--                                @endif--}}
{{--                                @if(isset($basicSetting->common_institute_logo))--}}
{{--                                    <img src="{{ asset($basicSetting->common_institute_logo) }}" alt="" style="height: 60px" />--}}
{{--                                @endif--}}
{{--                            </div>--}}

                        </div>
                        <div class="mt-2">
                            <label for="">Active Subscription Feature</label>
                            <div>
                                <div class="material-switch">
                                    <input id="someSwitchOptionInfo" name="subscription_system_status" {{ isset($isShown) ? 'disabled' : '' }}  class="form-check-input success check-outline outline-success" type="checkbox" {{ isset($basicSetting) && $basicSetting->subscription_system_status == 0 ? '' : 'checked' }} />
                                    <label for="someSwitchOptionInfo" class="label-info"></label>
                                </div>
                            </div>
                        </div>
                        @if(!isset($isShown))
                        <div class="mt-2">
                            <input type="submit" class="btn btn-success btn-sm float-end" value="{{ isset($basicSetting) ? 'Update' : 'Create' }} Basic Setting" />
                        </div>
                        @endif
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-white float-start">Vendor Credentials</h4>
                </div>
                <div class="card-body">
                    <div>
                        <form class="" id="vendorCredentialsForm" method="post" action="{{ route('update-vendor-credentials') }}">
                            @csrf
                            <div class="mt-2">
                                <p class="fw-bold pb-2 border-bottom">Alpha SMS Gateway</p>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="alphaFloatingInput" name="SMS_ALPHA_SMS_API_KEY" value="{{ env('SMS_ALPHA_SMS_API_KEY') ?? '' }}" placeholder="ukshdkhudfus.........">
                                    <label for="alphaFloatingInput">API Key</label>
                                </div>
                            </div>
                            <div class="mt-2">
                                <p class="fw-bold pb-2 border-bottom">SMTP Mail Gateway</p>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="mailerHost" name="MAIL_HOST" value="{{ env('MAIL_HOST') ?? '' }}" placeholder="admin@admin.com">
                                    <label for="mailerHost">Mailer Host</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="mailerPort" name="MAIL_PORT" value="{{ env('MAIL_PORT') ?? '' }}" placeholder="682">
                                    <label for="mailerPort">Mailer Port</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="mailerusername" name="MAIL_USERNAME" value="{{ env('MAIL_USERNAME') ?? '' }}" placeholder="username">
                                    <label for="mailerusername">Mailer Username</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="mailerpassword" name="MAIL_PASSWORD" value="{{ env('MAIL_PASSWORD') ?? '' }}" placeholder="Password">
                                    <label for="mailerpassword">Mailer Password</label>
                                </div>
                                {{--                        <div class="form-floating mb-3">--}}
                                {{--                            <input type="text" class="form-control" id="mailermailfrom_address" name="mailer_mailfrom_address" value="{{ env('MAIL_FROM_ADDRESS') ?? '' }}" placeholder="support@domain.com">--}}
                                {{--                            <label for="mailermailfrom_address">Mailer Port</label>--}}
                                {{--                        </div>--}}
                            </div>
                            <div class="mt-2">
                                <p class="fw-bold pb-2 border-bottom">Google Auth Credentials</p>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="googleClientId" name="GOOGLE_CLIENT_ID" value="{{ env('GOOGLE_CLIENT_ID') ?? '' }}" placeholder="admin@admin.com">
                                    <label for="googleClientId">Client ID</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="googleClientSecret" name="GOOGLE_CLIENT_SECRET" value="{{ env('GOOGLE_CLIENT_SECRET') ?? '' }}" placeholder="682">
                                    <label for="googleClientSecret">Client Secret</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="googleRedirectUrl" name="GOOGLE_REDIRECT" value="{{ env('GOOGLE_REDIRECT') ?? '' }}" placeholder="username">
                                    <label for="googleRedirectUrl">Redirect Url</label>
                                </div>
                            </div>
                            <div class="mt-2">
                                <p class="fw-bold pb-2 border-bottom">Pusher Credentials</p>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="pusherAppKey" name="PUSHER_APP_KEY" value="{{ env('PUSHER_APP_KEY') ?? '' }}" placeholder="admin@admin.com">
                                    <label for="pusherAppKey">APP Key</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="pusherAppSecret" name="PUSHER_APP_SECRET" value="{{ env('PUSHER_APP_SECRET') ?? '' }}" placeholder="682">
                                    <label for="pusherAppSecret">App Secret</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="pusherAppId" name="PUSHER_APP_ID" value="{{ env('PUSHER_APP_ID') ?? '' }}" placeholder="username">
                                    <label for="pusherAppId">App ID</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="pusherAppCluster" name="PUSHER_APP_CLUSTER" value="{{ env('PUSHER_APP_CLUSTER') ?? '' }}" placeholder="username">
                                    <label for="pusherAppCluster">App Cluster</label>
                                </div>
                            </div>
                            <div class="mt-2">
                                <p class="fw-bold pb-2 border-bottom">Twilio Credentials</p>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="twilioApiSid" name="TWILIO_ACCOUNT_SID" value="{{ env('TWILIO_ACCOUNT_SID') ?? '' }}" placeholder="admin@admin.com">
                                    <label for="twilioApiSid">Account SID</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="twilioApiKey" name="TWILIO_API_KEY" value="{{ env('TWILIO_API_KEY') ?? '' }}" placeholder="682">
                                    <label for="twilioApiKey">API Key</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="twilioApiSecret" name="TWILIO_API_SECRET" value="{{ env('TWILIO_API_SECRET') ?? '' }}" placeholder="username">
                                    <label for="twilioApiSecret">API Secret</label>
                                </div>
                            </div>
                            <div class="mt-2">
                                <p class="fw-bold pb-2 border-bottom">SSLCommerze Credentials</p>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="mailerHost" name="SSLC_STORE_ID" value="{{ env('SSLC_STORE_ID') ?? '' }}" placeholder="sheyure5we78">
                                    <label for="mailerHost">Store ID</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="mailerPort" name="SSLC_STORE_PASSWORD" value="{{ env('SSLC_STORE_PASSWORD') ?? '' }}" placeholder="jewhriwue7234hf">
                                    <label for="mailerPort">Store Password</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" name="SSLC_TESTMODE" aria-label="Floating label select example">
                                        <option selected disabled>Select Mode</option>
                                        <option value="TRUE" {{ env('SSLC_TESTMODE') == 'TRUE' ? 'selected' : '' }}>TRUE</option>
                                        <option value="FALSE" {{ env('SSLC_TESTMODE') == 'FALSE' ? 'selected' : '' }}>FALSE</option>
                                    </select>
                                    <label for="floatingSelect">Test Mode Status</label>
                                </div>
                            </div>


                            <div class="mt-2">
                                <button type="button" id="vendorCredentialsFormSubmitBtn" class="btn btn-warning">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@push('script')
    @include('common-resource-files.selectize')
    @include('common-resource-files.summernote')

    <script>
        $(document).on('click', '#vendorCredentialsFormSubmitBtn', function () {
            event.preventDefault();
            $.ajax({
                url: "{{ route('update-vendor-credentials') }}",
                method: "POST",
                data: $('#vendorCredentialsForm').serialize(),
                success: function (response) {
                    if (response.status == 'success')
                        toastr.success(response.msg);
                    else
                        toastr.error('Something went wrong. Please try again');
                }
            })
        })
    </script>
    <!--tinymce js-->
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.3.2/tinymce.min.js" integrity="sha512-9w/jRiVYhkTCGR//GeGsRss1BJdvxVj544etEHGG1ZPB9qxwF7m6VAeEQb1DzlVvjEZ8Qv4v8YGU8xVPPgovqg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}

{{--    <script>--}}

{{--        tinymce.init({--}}
{{--            selector: 'textarea',--}}
{{--            height: 200,--}}
{{--            menubar: false,--}}
{{--            plugins: [--}}
{{--                'advlist autolink lists link image charmap print preview anchor',--}}
{{--                'searchreplace visualblocks code fullscreen',--}}
{{--                'insertdatetime media table paste code help wordcount'--}}
{{--            ],--}}
{{--            toolbar: 'undo redo | formatselect | ' +--}}
{{--                'bold italic backcolor | alignleft aligncenter ' +--}}
{{--                'alignright alignjustify | bullist numlist outdent indent | ' +--}}
{{--                'removeformat | help',--}}
{{--            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'--}}
{{--        });--}}


{{--    </script>--}}
@endpush
