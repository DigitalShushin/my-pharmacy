@extends('layouts.master')
@section('title')
    @lang('translation.colors')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Components
        @endslot
        @slot('title')
            Colors
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Colors Options</h4>
                    <p class="mb-0 text-muted">Use diffrent <code>color style</code> to color your
                        element with a given table.</p>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-nowrap align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        Colors
                                    </th>
                                    <th scope="col" colspan="2" class="text-center">
                                        Background <br> Gradient
                                    </th>
                                    <th scope="col" colspan="2" class="text-center">
                                        Background <br> Color
                                    </th>
                                    <th scope="col" colspan="2" class="text-center">
                                        Background <br> Soft
                                    </th>
                                    <th scope="col" colspan="2" class="text-center">
                                        Border <br> Colors
                                    </th>
                                    <th scope="col" colspan="2" class="text-center">
                                        Text <br> Colors
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <th class="" scope="row">
                                        Primary
                                    </th>
                                    <td style="width: 100px;">
                                        <code>.bg-gradient</code>
                                    </td>
                                    <td style="width: 180px;">
                                        <div class="bg-primary bg-gradient p-2"></div>
                                    </td>
                                    <td style="width: 100px;">
                                        <code>.bg-primary</code>
                                    </td>
                                    <td style="width: 180px;">
                                        <div class="bg-primary p-2"></div>
                                    </td>
                                    <td style="width: 100px;">
                                        <code>.bg-soft-primary</code>
                                    </td>
                                    <td style="width: 180px;">
                                        <div class="bg-soft-primary p-2"></div>
                                    </td>
                                    <td style="width: 100px;">
                                        <code>.border-primary</code>
                                    </td>
                                    <td style="width: 180px;">
                                        <div class="border border-primary p-2"></div>
                                    </td>
                                    <td style="width: 100px;">
                                        <code>.text-primary</code>
                                    </td>
                                    <td style="width: 100px;">
                                        <div class="text-primary">text-primary</div>
                                    </td>
                                </tr>


                                <tr>
                                    <th class="" scope="row">
                                        Secondary
                                    </th>
                                    <td>
                                        <code>.bg-gradient</code>
                                    </td>
                                    <td>
                                        <div class="bg-secondary bg-gradient p-2"></div>
                                    </td>
                                    <td>
                                        <code>.bg-secondary</code>
                                    </td>
                                    <td>
                                        <div class="bg-secondary p-2"></div>
                                    </td>
                                    <td>
                                        <code>.bg-soft-secondary</code>
                                    </td>
                                    <td>
                                        <div class="bg-soft-secondary p-2"></div>
                                    </td>
                                    <td>
                                        <code>.border-secondary</code>
                                    </td>
                                    <td>
                                        <div class="border border-secondary p-2"></div>
                                    </td>
                                    <td>
                                        <code>.text-secondary</code>
                                    </td>
                                    <td>
                                        <div class="text-secondary">text-secondary</div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="" scope="row">
                                        Success
                                    </th>
                                    <td>
                                        <code>.bg-gradient</code>
                                    </td>
                                    <td>
                                        <div class="bg-success bg-gradient p-2 align-self-center"></div>
                                    </td>
                                    <td>
                                        <code>.bg-success</code>
                                    </td>
                                    <td>
                                        <div class="bg-success p-2"></div>
                                    </td>
                                    <td>
                                        <code>.bg-soft-success</code>
                                    </td>
                                    <td>
                                        <div class="bg-soft-success p-2"></div>
                                    </td>
                                    <td>
                                        <code>.border-success</code>
                                    </td>
                                    <td>
                                        <div class="border border-success p-2"></div>
                                    </td>
                                    <td>
                                        <code>.text-success</code>
                                    </td>
                                    <td>
                                        <div class="text-success">text-success</div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="" scope="row">
                                        Info
                                    </th>
                                    <td>
                                        <code>.bg-gradient</code>
                                    </td>
                                    <td>
                                        <div class="bg-info bg-gradient p-2"></div>
                                    </td>
                                    <td>
                                        <code>.bg-info</code>
                                    </td>
                                    <td>
                                        <div class="bg-info p-2"></div>
                                    </td>
                                    <td>
                                        <code>.bg-soft-info</code>
                                    </td>
                                    <td>
                                        <div class="bg-soft-info p-2"></div>
                                    </td>
                                    <td>
                                        <code>.border-info</code>
                                    </td>
                                    <td>
                                        <div class="border border-info p-2"></div>
                                    </td>
                                    <td>
                                        <code>.text-info</code>
                                    </td>
                                    <td>
                                        <div class="text-info">text-info</div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="" scope="row">
                                        Warning
                                    </th>
                                    <td>
                                        <code>.bg-gradient</code>
                                    </td>
                                    <td>
                                        <div class="bg-warning bg-gradient p-2"></div>
                                    </td>
                                    <td>
                                        <code>.bg-warning</code>
                                    </td>
                                    <td>
                                        <div class="bg-warning p-2"></div>
                                    </td>
                                    <td>
                                        <code>.bg-soft-warning</code>
                                    </td>
                                    <td>
                                        <div class="bg-soft-warning p-2"></div>
                                    </td>
                                    <td>
                                        <code>.border-warning</code>
                                    </td>
                                    <td>
                                        <div class="border border-warning p-2"></div>
                                    </td>
                                    <td>
                                        <code>.text-warning</code>
                                    </td>
                                    <td>
                                        <div class="text-warning">text-warning</div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="" scope="row">
                                        Danger
                                    </th>
                                    <td>
                                        <code>.bg-gradient</code>
                                    </td>
                                    <td>
                                        <div class="bg-danger bg-gradient p-2"></div>
                                    </td>
                                    <td>
                                        <code>.bg-danger</code>
                                    </td>
                                    <td>
                                        <div class="bg-danger p-2"></div>
                                    </td>
                                    <td>
                                        <code>.bg-soft-danger</code>
                                    </td>
                                    <td>
                                        <div class="bg-soft-danger p-2"></div>
                                    </td>
                                    <td>
                                        <code>.border-danger</code>
                                    </td>
                                    <td>
                                        <div class="border border-danger p-2"></div>
                                    </td>
                                    <td>
                                        <code>.text-danger</code>
                                    </td>
                                    <td>
                                        <div class="text-danger">text-danger</div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="" scope="row">
                                        Dark
                                    </th>
                                    <td>
                                        <code>.bg-gradient</code>
                                    </td>
                                    <td>
                                        <div class="bg-dark bg-gradient p-2"></div>
                                    </td>
                                    <td>
                                        <code>.bg-dark</code>
                                    </td>
                                    <td>
                                        <div class="bg-dark p-2"></div>
                                    </td>
                                    <td>
                                        <code>.bg-soft-dark</code>
                                    </td>
                                    <td>
                                        <div class="bg-soft-dark p-2"></div>
                                    </td>
                                    <td>
                                        <code>.border-dark</code>
                                    </td>
                                    <td>
                                        <div class="border border-dark p-2"></div>
                                    </td>
                                    <td>
                                        <code>.text-dark</code>
                                    </td>
                                    <td>
                                        <div class="text-dark">text-dark</div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="" scope="row">
                                        Light
                                    </th>
                                    <td>
                                        <code>.bg-gradient</code>
                                    </td>
                                    <td>
                                        <div class="bg-light bg-gradient p-2"></div>
                                    </td>
                                    <td>
                                        <code>.bg-light</code>
                                    </td>
                                    <td>
                                        <div class="bg-light p-2"></div>
                                    </td>
                                    <td>
                                        <code>.bg-soft-light</code>
                                    </td>
                                    <td>
                                        <div class="bg-soft-light p-2"></div>
                                    </td>
                                    <td>
                                        <code>.border-light</code>
                                    </td>
                                    <td>
                                        <div class="border border-light p-2"></div>
                                    </td>
                                    <td>
                                        <code>.text-light</code>
                                    </td>
                                    <td>
                                        <div class="text-light bg-dark">text-light</div>
                                    </td>
                                </tr>


                                <tr>
                                    <th class="" scope="row">
                                        Body
                                    </th>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <code>.text-body</code>
                                    </td>
                                    <td>
                                        <div class="text-body">text-body</div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="" scope="row">
                                        Muted
                                    </th>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <code>.text-muted</code>
                                    </td>
                                    <td>
                                        <div class="text-muted">text-muted</div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="" scope="row">
                                        White
                                    </th>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <code>.text-white</code>
                                    </td>
                                    <td>
                                        <div class="text-white bg-dark">text-white</div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="" scope="row">
                                        White-50
                                    </th>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <code>.text-white-50</code>
                                    </td>
                                    <td>
                                        <div class="text-white-50 bg-dark">text-white-50</div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="" scope="row">
                                        Black-50
                                    </th>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <code>.text-black-50</code>
                                    </td>
                                    <td>
                                        <div class="text-black-50">text-black-50</div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="" scope="row">
                                        Opacity-25
                                    </th>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center"><code>.opacity-25</code></div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <div class="bg-primary opacity-25 p-2"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <code>.text-opacity-25</code>
                                    </td>
                                    <td>
                                        <div class="text-opacity-25 text-primary">text-opacity-25</div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="" scope="row">
                                        Opacity-50
                                    </th>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center"><code>.opacity-50</code></div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <div class="bg-primary opacity-50 p-2"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <code>.text-opacity-50</code>
                                    </td>
                                    <td>
                                        <div class="text-opacity-50 text-primary">text-opacity-50</div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="" scope="row">
                                        Opacity-75
                                    </th>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center"><code>.opacity-75</code></div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <div class="bg-primary opacity-75 p-2"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <code>.text-opacity-75</code>
                                    </td>
                                    <td>
                                        <div class="text-opacity-75 text-primary">text-opacity-75</div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="" scope="row">
                                        Opacity-100
                                    </th>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center"><code>.opacity-100</code></div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <div class="bg-primary opacity-100 p-2"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <div class="text-center">-</div>
                                    </td>
                                    <td>
                                        <code>.text-opacity-100</code>
                                    </td>
                                    <td>
                                        <div class="text-opacity-100 text-primary">text-opacity-100</div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@section('script')
<script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
