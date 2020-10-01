<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <title>Admin - @yield('title')</title>

    {{Html::style('admin/assets/vendor/simple-line-icons/css/simple-line-icons.css')}}
    {{Html::style('admin/assets/vendor/font-awesome/css/fontawesome-all.min.css')}}
    {{Html::style('admin/assets/css/styles.css')}}


    @yield('additionStyle')
    <!-- <link rel="stylesheet" href="./vendor/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="./vendor/font-awesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="./css/styles.css"> -->
</head>
<body class="sidebar-fixed header-fixed">
<div class="page-wrapper">
    @include('layout.admin.headerNavigation')

    <div class="main-container">
        @include('layout.admin.slideBar')

        @yield('content')

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
{{--{{Html::script('admin/assets/vendor/jquery/jquery.min.js')}}--}}
{{--{{Html::script('https://code.jquery.com/jquery-3.5.1.js')}}--}}



{{Html::script('admin/assets/vendor/popper.js/popper.min.js')}}
{{Html::script('admin/assets/vendor/bootstrap/js/bootstrap.min.js')}}
{{Html::script('admin/assets/js/carbon.js')}}

{{--{{Html::script('admin/assets/js/demo.js')}}--}}

@yield('additionScript')


<!-- <script src="./vendor/jquery/jquery.min.js"></script>
<script src="./vendor/popper.js/popper.min.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="./vendor/chart.js/chart.min.js"></script>
<script src="./js/carbon.js"></script>
<script src="./js/demo.js"></script> -->
</body>
</html>

@yield('modal')

