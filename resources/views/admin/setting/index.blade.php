@extends('layouts.admin-layout')
@section('title', 'Setting')
@section('setting', 'active')
@section('content')
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
        <span class="breadcrumb-item active">Setting</span>
    </nav>

    <div class="sl-pagebody">
        <div class="row row-sm">
            <div class="col-md-12">
                <div class="card pd-10 pd-sm-20">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#web"
                                role="tab" aria-controls="nav-home" aria-selected="true">Web</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#seo"
                                role="tab" aria-controls="nav-profile" aria-selected="false">SEO</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#social"
                                role="tab" aria-controls="nav-contact" aria-selected="false">Social</a>
                            <a class="nav-item nav-link" id="nav-config-tab" data-toggle="tab" href="#config" role="tab"
                                aria-controls="nav-contact" aria-selected="false">Config</a>
                        </div>
                    </nav>
                    <div class="tab-content mt-4" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="web" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="{{ route('admin.setting.title') }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="title" class="form-label">Website Title</label>
                                            <input type="text" id="title" class="form-control" name="title"
                                                value="{{ $settings->title }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form action="{{ route('admin.setting.address') }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="address" class="form-label">Office Address</label>
                                            <input type="text" id="address" class="form-control" name="address"
                                                value="{{ $settings->address }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <img src="{{ asset($settings->logo) }}" alt="" class="img-fluid">
                                        </div>
                                        <div class="col-6">
                                            <img src="" alt="" id="preview" class="img-fluid">
                                        </div>

                                    </div>
                                    <form action="{{ route('admin.setting.logo') }}"enctype="multipart/form-data"
                                        method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="logo" class="form-label">Website Logo</label>
                                            <input type="file" id="logo" class="form-control" name="logo">
                                            <input type="hidden" name="old_logo" value="{{ $settings->logo }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>

                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <img src="{{ asset($settings->favicon) }}" alt="" class="img-fluid">
                                        </div>
                                        <div class="col-6">
                                            <img src="" alt="" id="favicon-preview" class="img-fluid">
                                        </div>

                                    </div>
                                    <form action="{{ route('admin.setting.favicon') }}"enctype="multipart/form-data"
                                        method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="favicon" class="form-label">Website Favicon</label>
                                            <input type="file" id="favicon" class="form-control" name="favicon">
                                            <input type="hidden" id="favicon" class="form-control" name="old_favicon"
                                                value="{{ $settings->favicon }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="row">
                                <div class="col-12">
                                    <form action="{{ route('admin.setting.seo.tilte') }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="seo-title" class="form-label">Seo Title</label>
                                            <input type="text" id="seo-title" class="form-control"
                                                value="{{ $settings->seo_title }}" name="seo_title">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12">
                                    <form action="{{ route('admin.setting.seo.meta') }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="seo-keywors" class="form-label">Seo Keywords</label>
                                            <input type="text" id="seo-keywors" class="form-control"
                                                value="{{ $settings->seo_meta }}" name="seo_meta">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12">
                                    <form action="{{ route('admin.setting.seo.desc') }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="seo-description" class="form-label">Seo Description</label>
                                            <input type="text" id="seo-description" class="form-control"
                                                value="{{ $settings->seo_description }}" name="seo_description">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <form action="{{ route('admin.setting.phone1') }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="phone-1" class="form-label">Phone Number 1</label>
                                            <input type="text" id="phone-1" class="form-control" name="phone_1"
                                                value="{{ $settings->phone_1 }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12 col-md-6">
                                    <form action="{{ route('admin.setting.phone2') }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="phone-2" class="form-label">Phone Number 2</label>
                                            <input type="text" id="phone-2" class="form-control" name="phone_2"
                                                value="{{ $settings->phone_2 }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12 col-md-6">
                                    <form action="{{ route('admin.setting.email') }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" id="email" class="form-control" name="email"
                                                value="{{ $settings->email }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12 col-md-6">
                                    <form action="{{ route('admin.setting.facebook') }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="facebook" class="form-label">Facebbok Page Link</label>
                                            <input type="text" id="facebook" class="form-control" name="facebook"
                                                value="{{ $settings->facebook }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12 col-md-6">
                                    <form action="{{ route('admin.setting.whatsapp') }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="whatsapp" class="form-label">Whats App Account</label>
                                            <input type="text" id="whatsapp" class="form-control" name="whatsapp"
                                                value="{{ $settings->whatsapp }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12 col-md-6">
                                    <form action="{{ route('admin.setting.twitter') }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="twitter" class="form-label">Twitter Account Link</label>
                                            <input type="text" id="twitter" class="form-control" name="twitter"
                                                value="{{ $settings->twitter }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12 col-md-6">
                                    <form action="{{ route('admin.setting.instagram') }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="instagram" class="form-label">Instagram Account</label>
                                            <input type="text" id="instagram" class="form-control" name="instagram"
                                                value="{{ $settings->instagram }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12 col-md-6">
                                    <form action="{{ route('admin.setting.youtube') }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="youtube" class="form-label">Youtube Channel Link</label>
                                            <input type="text" id="youtube" class="form-control" name="youtube"
                                                value="{{ $settings->youtube }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="config" role="tabpanel" aria-labelledby="nav-config-tab">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <h4>Mail Sending Option</h4>
                                    <form action="{{ route('admin.setting.mail.config') }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="phone-1" class="form-label">Mail Sender</label>
                                            <input type="text" id="ssl-store-id" class="form-control"
                                                name="mail_mailer" value="{{ $mailConfig?->mail_mailer }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone-1" class="form-label">Mail Host</label>
                                            <input type="text" id="mail-host" class="form-control" name="mail_host"
                                                value="{{ $mailConfig?->mail_host }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone-1" class="form-label">Mail Port</label>
                                            <input type="text" id="mail-port" class="form-control" name="mail_port"
                                                value="{{ $mailConfig?->mail_port }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone-1" class="form-label">Mail Username</label>
                                            <input type="text" id="mail-username" class="form-control"
                                                name="mail_username" value="{{ $mailConfig?->mail_username }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone-1" class="form-label">Mail Password</label>
                                            <input type="text" id="mail-password" class="form-control"
                                                name="mail_password" value="{{ $mailConfig?->mail_password }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone-1" class="form-label">Mail Address</label>
                                            <input type="text" id="mail-address" class="form-control"
                                                name="mail_address" value="{{ $mailConfig?->mail_address }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone-1" class="form-label">Mail Send From</label>
                                            <input type="text" id="mail-from" class="form-control" name="mail_from"
                                                value="{{ $mailConfig?->mail_from }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-12 col-md-6">
                                    <h4>SSL Commerz Option</h4>
                                    <form action="{{ route('admin.setting.ssl.config') }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="phone-1" class="form-label">SSLCommerz Store ID</label>
                                            <input type="text" id="ssl-store-id" class="form-control"
                                                name="ssl_store_id" value="{{ $sslStoreId?->value }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone-1" class="form-label">Store Password</label>
                                            <input type="text" id="mail-host" class="form-control"
                                                name="ssl_store_password" value="{{ $sslStorePassword?->value }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>
                                    <h4>Amaarpay Option</h4>
                                    <form action="{{ route('admin.setting.amaarpay.config') }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="phone-1" class="form-label">Amaarpay Store ID</label>
                                            <input type="text" id="amaarpay-store-id" class="form-control"
                                                name="amaarpay_store_id" value="{{ $amaarypayStoreId?->value }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone-1" class="form-label">Amaarpay Signature key</label>
                                            <input type="text" id="amaarpay-signature-key" class="form-control"
                                                name="amaarpay_signature_key"
                                                value="{{ $amaarpaySingnatureKey?->value }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('components.alerts.success')
    @include('components.alerts.error')
    <script type="text/javascript">
        $('#logo').change(function() {
            var reader = new FileReader();
            reader.readAsDataURL(this.files[0]);
            reader.onload = function(event) {
                var ImgSource = event.target.result;
                $('#preview').attr('src', ImgSource)
            }
        })
        $('#favicon').change(function() {
            var reader = new FileReader();
            reader.readAsDataURL(this.files[0]);
            reader.onload = function(event) {
                var ImgSource = event.target.result;
                $('#favicon-preview').attr('src', ImgSource)
            }
        })
    </script>
@endsection
