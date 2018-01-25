<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        @yield('styles')
        <link href="{{ mix('css/frontend.css') }}" rel="stylesheet" type="text/css" />
        <style>
            /* .navbar-default {
                background-color: transparent;
                border-color: transparent;
            } */

            .navbar {
                padding: 0px;
                background: transparent;
                border: none;
                border-radius: 0;
                margin-top: -20px;
                box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
            }

            .navbar-brand {
                float: none;
                height: 50px;
                padding: 5px;
                font-size: 18px;
                line-height: 20px;
            }

            .navbar-default .navbar-nav>li>a {
                color: #bc0050;
            }

            .panel-body {
                padding: 0px;
                background-color: transparent;
            }

            .panel-default {
                border-color: transparent;
            }

            .panel {
                margin-bottom: 20px;
                background-color: transparent;
                box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 1px;
                border-width: 1px;
                border-style: solid;
                border-color: transparent;
                border-image: initial;
                border-radius: 0px;
            }
        </style>
    </head>
    
    <body>

        <div class="wrapper">
            <nav id="sidebar" class="in">
                <div class="sidebar-header text-center">
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        <h3>
                            <svg width="70px" height="51px" viewBox="0 0 90 73" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>{{ config('app.name', 'Laravel') }}</title>
                                <desc></desc>
                                <defs></defs>
                                <g id="web" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="webMain" transform="translate(-467.000000, -15.000000)">
                                        <g id="logo" transform="translate(467.000000, 15.000000)">
                                            <path d="M14.2889828,31.0758462 L33.7678062,6.04387265 C33.8179569,5.98391808 33.8677305,5.92622595 33.9186353,5.86966504 C35.1867309,4.62306258 39.521182,4.89757153 39.521182,10.5272675 L39.521182,21.2885463 L23.8161026,42.1463247 C21.8066819,44.812229 18.85194,46.5384679 15.4726141,46.5384679 C9.67700617,46.5384679 5.81276477,42.8401385 5.81276477,36.0441566 L5.81276477,30.7549573 C5.81276477,31.7738079 9.22074816,37.3706985 14.2889828,31.0758462" id="Fill-1" fill="#FF0069"></path>
                                            <path d="M12.948263,0.000113121821 C16.8886731,0.000113121821 20.0836104,3.34097757 20.0836104,7.46275965 L20.0836104,23.6297532 L14.2891336,31.0758085 C9.22052191,37.3706608 5.81291559,31.7737702 5.81291559,30.7552967 L5.81291559,7.46275965 C5.81291559,3.34097757 9.00747582,0.000113121821 12.948263,0.000113121821" id="Fill-3" fill="#96006A"></path>
                                            <path d="M79.5892326,2.01583085 C76.4953508,-0.335217663 72.0817145,0.266590425 69.7302889,3.36047223 L48.0440817,31.607745 C44.095376,35.7212315 40.8593378,33.8562298 39.6251787,31.4429643 C39.5972753,31.3882887 39.5689948,31.3373839 39.5407144,31.2853479 L39.5407144,36.5918925 C39.5407144,43.4093675 43.416645,47.1193862 49.2311066,47.1193862 C52.6209905,47.1193862 55.5855364,45.3878682 57.6009902,42.7140454 L80.933874,11.8747746 C83.2852996,8.78051574 82.6827374,4.36687936 79.5892326,2.01583085" id="Fill-5" fill="#FF0069"></path>
                                            <path d="M39.5407144,31.4543896 L39.5407144,31.285461 C39.5689948,31.3371199 39.5972753,31.3884018 39.6251787,31.4430774 C40.8593378,33.8563429 44.095376,35.7209676 48.0440817,31.6074811 L53.7918014,24.121079 L53.7918014,10.4944244 C53.7918014,3.69844252 49.5998838,0.000113121821 43.8042758,0.000113121821 C40.42495,0.000113121821 36.884614,1.6158698 33.7677308,6.04383494 C34.7929916,4.60907318 39.5211066,4.64791167 39.5211066,10.5272298 L39.5199754,31.4114033 L39.5407144,31.4543896 Z" id="Fill-7" fill="#96006A"></path>
                                            <g id="Group" transform="translate(0.000000, 47.255668)" fill="#1F0016">
                                                <polygon id="Fill-9" points="23.6664801 24.2571571 16.5665775 24.2571571 13.8995421 9.60637299 11.2698368 24.2571571 4.24497174 24.2571571 -0.000113121822 4.31000934 6.01080337 4.31000934 8.07678489 19.82429 11.1947993 4.31000934 16.9798493 4.31000934 19.7222993 19.82429 22.126515 4.31000934 27.7988202 4.31000934"></polygon>
                                                <path d="M47.1443861,24.2571571 L41.9980974,24.2571571 L41.7345236,21.7401966 C40.2699731,23.8438854 38.3163592,24.8955412 35.686654,24.8955412 C31.9675856,24.8955412 30.1270935,22.4913255 30.1270935,18.6225592 L30.1270935,4.31000934 L36.0622184,4.31000934 L36.0622184,17.8706762 C36.0622184,19.8993275 36.7383098,20.5003814 37.978125,20.5003814 C39.2179401,20.5003814 40.3450105,19.6742151 41.2088842,18.1712031 L41.2088842,4.31000934 L47.1443861,4.31000934 L47.1443861,24.2571571 Z" id="Fill-12"></path>
                                                <path d="M64.6116396,4.00940695 L63.6727285,9.7567496 C63.0335902,9.60667465 62.5456581,9.4939299 61.8695667,9.4939299 C59.3899364,9.4939299 58.3756107,11.334799 57.7372265,14.3773989 L57.7372265,24.2570817 L51.8017246,24.2570817 L51.8017246,4.30993393 L56.9857206,4.30993393 L57.4740298,8.17907727 C58.3756107,5.39929706 60.3292245,3.74621018 62.6206956,3.74621018 C63.3722015,3.74621018 63.9732555,3.82162473 64.6116396,4.00940695" id="Fill-14"></path>
                                                <path d="M75.5802707,18.7351154 L75.5802707,15.2038292 L74.1153431,15.2038292 C71.4106004,15.2038292 70.0957478,16.1431174 70.0957478,18.1336844 C70.0957478,19.7117338 70.9596214,20.6506449 72.4249261,20.6506449 C73.8148162,20.6506449 74.866472,19.9372233 75.5802707,18.7351154 M82.7552107,20.9138417 L81.5157727,24.782985 C79.1492642,24.5952028 77.608922,23.8814041 76.7073411,21.8904601 C75.2797437,24.1068936 73.0633102,24.8957298 70.6968017,24.8957298 C66.7149136,24.8957298 64.1979531,22.3037318 64.1979531,18.6600779 C64.1979531,14.3022483 67.5037498,11.9357398 73.5519965,11.9357398 L75.5802707,11.9357398 L75.5802707,11.0718662 C75.5802707,8.70498062 74.6413596,7.99118193 72.1994366,7.99118193 C70.9219141,7.99118193 68.9690544,8.36674637 66.9781104,9.04321486 L65.6255505,5.13636424 C68.1421339,4.19707606 70.8845839,3.67105959 73.1383477,3.67105959 C78.9237747,3.67105959 81.4030279,6.11260556 81.4030279,10.7332549 L81.4030279,18.4722957 C81.4030279,20.0122608 81.8162996,20.5756074 82.7552107,20.9138417" id="Fill-16"></path>
                                                <path d="M86.0160226,3.47656547 L86.4341963,3.47656547 C86.85237,3.47656547 87.1314038,3.32460516 87.1314038,2.93169537 C87.1314038,2.55122898 86.8904543,2.41208914 86.396112,2.41208914 L86.0160226,2.41208914 L86.0160226,3.47656547 Z M87.0047074,3.89473914 L87.9424873,5.36532281 L87.1438472,5.36532281 L86.3580276,4.00899217 L86.0160226,4.00899217 L86.0160226,5.36532281 L85.344079,5.36532281 L85.344079,1.87966243 L86.3071228,1.87966243 C87.3342689,1.87966243 87.8286113,2.22204448 87.8286113,2.93169537 C87.8286113,3.43848112 87.4734088,3.7555993 87.0047074,3.89473914 L87.0047074,3.89473914 Z M89.0073407,3.6669872 C89.0073407,2.15831918 87.9553077,1.04293803 86.4722807,1.04293803 C85.0397813,1.04293803 83.9624845,2.15831918 83.9624845,3.6669872 C83.9624845,5.18772155 85.0397813,6.27783883 86.4722807,6.27783883 C87.9553077,6.27783883 89.0073407,5.17527815 89.0073407,3.6669872 L89.0073407,3.6669872 Z M89.6664638,3.6669872 C89.6664638,5.4414915 88.2848693,6.86117035 86.4722807,6.86117035 C84.7102198,6.86117035 83.3161819,5.4539349 83.3161819,3.6669872 C83.3161819,1.90492631 84.7102198,0.459983581 86.4722807,0.459983581 C88.2848693,0.459983581 89.6664638,1.89248291 89.6664638,3.6669872 L89.6664638,3.6669872 Z" id="Fill-19"></path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </h3>
                    </a>
                    <strong>
                        <a class="navbar-brand" href="{{ url('/home') }}">
                            <svg width="70px" height="51px" viewBox="0 0 90 73" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>{{ config('app.name', 'Laravel') }}</title>
                                <desc></desc>
                                <defs></defs>
                                <g id="web" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="webMain" transform="translate(-467.000000, -15.000000)">
                                        <g id="logo" transform="translate(467.000000, 15.000000)">
                                            <path d="M14.2889828,31.0758462 L33.7678062,6.04387265 C33.8179569,5.98391808 33.8677305,5.92622595 33.9186353,5.86966504 C35.1867309,4.62306258 39.521182,4.89757153 39.521182,10.5272675 L39.521182,21.2885463 L23.8161026,42.1463247 C21.8066819,44.812229 18.85194,46.5384679 15.4726141,46.5384679 C9.67700617,46.5384679 5.81276477,42.8401385 5.81276477,36.0441566 L5.81276477,30.7549573 C5.81276477,31.7738079 9.22074816,37.3706985 14.2889828,31.0758462" id="Fill-1" fill="#FF0069"></path>
                                            <path d="M12.948263,0.000113121821 C16.8886731,0.000113121821 20.0836104,3.34097757 20.0836104,7.46275965 L20.0836104,23.6297532 L14.2891336,31.0758085 C9.22052191,37.3706608 5.81291559,31.7737702 5.81291559,30.7552967 L5.81291559,7.46275965 C5.81291559,3.34097757 9.00747582,0.000113121821 12.948263,0.000113121821" id="Fill-3" fill="#96006A"></path>
                                            <path d="M79.5892326,2.01583085 C76.4953508,-0.335217663 72.0817145,0.266590425 69.7302889,3.36047223 L48.0440817,31.607745 C44.095376,35.7212315 40.8593378,33.8562298 39.6251787,31.4429643 C39.5972753,31.3882887 39.5689948,31.3373839 39.5407144,31.2853479 L39.5407144,36.5918925 C39.5407144,43.4093675 43.416645,47.1193862 49.2311066,47.1193862 C52.6209905,47.1193862 55.5855364,45.3878682 57.6009902,42.7140454 L80.933874,11.8747746 C83.2852996,8.78051574 82.6827374,4.36687936 79.5892326,2.01583085" id="Fill-5" fill="#FF0069"></path>
                                            <path d="M39.5407144,31.4543896 L39.5407144,31.285461 C39.5689948,31.3371199 39.5972753,31.3884018 39.6251787,31.4430774 C40.8593378,33.8563429 44.095376,35.7209676 48.0440817,31.6074811 L53.7918014,24.121079 L53.7918014,10.4944244 C53.7918014,3.69844252 49.5998838,0.000113121821 43.8042758,0.000113121821 C40.42495,0.000113121821 36.884614,1.6158698 33.7677308,6.04383494 C34.7929916,4.60907318 39.5211066,4.64791167 39.5211066,10.5272298 L39.5199754,31.4114033 L39.5407144,31.4543896 Z" id="Fill-7" fill="#96006A"></path>
                                            <g id="Group" transform="translate(0.000000, 47.255668)" fill="#1F0016">
                                                <polygon id="Fill-9" points="23.6664801 24.2571571 16.5665775 24.2571571 13.8995421 9.60637299 11.2698368 24.2571571 4.24497174 24.2571571 -0.000113121822 4.31000934 6.01080337 4.31000934 8.07678489 19.82429 11.1947993 4.31000934 16.9798493 4.31000934 19.7222993 19.82429 22.126515 4.31000934 27.7988202 4.31000934"></polygon>
                                                <path d="M47.1443861,24.2571571 L41.9980974,24.2571571 L41.7345236,21.7401966 C40.2699731,23.8438854 38.3163592,24.8955412 35.686654,24.8955412 C31.9675856,24.8955412 30.1270935,22.4913255 30.1270935,18.6225592 L30.1270935,4.31000934 L36.0622184,4.31000934 L36.0622184,17.8706762 C36.0622184,19.8993275 36.7383098,20.5003814 37.978125,20.5003814 C39.2179401,20.5003814 40.3450105,19.6742151 41.2088842,18.1712031 L41.2088842,4.31000934 L47.1443861,4.31000934 L47.1443861,24.2571571 Z" id="Fill-12"></path>
                                                <path d="M64.6116396,4.00940695 L63.6727285,9.7567496 C63.0335902,9.60667465 62.5456581,9.4939299 61.8695667,9.4939299 C59.3899364,9.4939299 58.3756107,11.334799 57.7372265,14.3773989 L57.7372265,24.2570817 L51.8017246,24.2570817 L51.8017246,4.30993393 L56.9857206,4.30993393 L57.4740298,8.17907727 C58.3756107,5.39929706 60.3292245,3.74621018 62.6206956,3.74621018 C63.3722015,3.74621018 63.9732555,3.82162473 64.6116396,4.00940695" id="Fill-14"></path>
                                                <path d="M75.5802707,18.7351154 L75.5802707,15.2038292 L74.1153431,15.2038292 C71.4106004,15.2038292 70.0957478,16.1431174 70.0957478,18.1336844 C70.0957478,19.7117338 70.9596214,20.6506449 72.4249261,20.6506449 C73.8148162,20.6506449 74.866472,19.9372233 75.5802707,18.7351154 M82.7552107,20.9138417 L81.5157727,24.782985 C79.1492642,24.5952028 77.608922,23.8814041 76.7073411,21.8904601 C75.2797437,24.1068936 73.0633102,24.8957298 70.6968017,24.8957298 C66.7149136,24.8957298 64.1979531,22.3037318 64.1979531,18.6600779 C64.1979531,14.3022483 67.5037498,11.9357398 73.5519965,11.9357398 L75.5802707,11.9357398 L75.5802707,11.0718662 C75.5802707,8.70498062 74.6413596,7.99118193 72.1994366,7.99118193 C70.9219141,7.99118193 68.9690544,8.36674637 66.9781104,9.04321486 L65.6255505,5.13636424 C68.1421339,4.19707606 70.8845839,3.67105959 73.1383477,3.67105959 C78.9237747,3.67105959 81.4030279,6.11260556 81.4030279,10.7332549 L81.4030279,18.4722957 C81.4030279,20.0122608 81.8162996,20.5756074 82.7552107,20.9138417" id="Fill-16"></path>
                                                <path d="M86.0160226,3.47656547 L86.4341963,3.47656547 C86.85237,3.47656547 87.1314038,3.32460516 87.1314038,2.93169537 C87.1314038,2.55122898 86.8904543,2.41208914 86.396112,2.41208914 L86.0160226,2.41208914 L86.0160226,3.47656547 Z M87.0047074,3.89473914 L87.9424873,5.36532281 L87.1438472,5.36532281 L86.3580276,4.00899217 L86.0160226,4.00899217 L86.0160226,5.36532281 L85.344079,5.36532281 L85.344079,1.87966243 L86.3071228,1.87966243 C87.3342689,1.87966243 87.8286113,2.22204448 87.8286113,2.93169537 C87.8286113,3.43848112 87.4734088,3.7555993 87.0047074,3.89473914 L87.0047074,3.89473914 Z M89.0073407,3.6669872 C89.0073407,2.15831918 87.9553077,1.04293803 86.4722807,1.04293803 C85.0397813,1.04293803 83.9624845,2.15831918 83.9624845,3.6669872 C83.9624845,5.18772155 85.0397813,6.27783883 86.4722807,6.27783883 C87.9553077,6.27783883 89.0073407,5.17527815 89.0073407,3.6669872 L89.0073407,3.6669872 Z M89.6664638,3.6669872 C89.6664638,5.4414915 88.2848693,6.86117035 86.4722807,6.86117035 C84.7102198,6.86117035 83.3161819,5.4539349 83.3161819,3.6669872 C83.3161819,1.90492631 84.7102198,0.459983581 86.4722807,0.459983581 C88.2848693,0.459983581 89.6664638,1.89248291 89.6664638,3.6669872 L89.6664638,3.6669872 Z" id="Fill-19"></path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>                    
                        </a>
                    </strong>
                </div>

                <ul class="list-unstyled components">
                    <li>
                        <a href="{{ route('home') }}">
                            <i class="fa fa-tachometer fa-fw" aria-hidden="true"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    <li>
                        <a href="#driverSubmenu" data-toggle="collapse" aria-expanded="false">
                            <i class="fa fa-id-badge" aria-hidden="true"></i>
                            <span>Driver Management</span>
                        </a>
                        <ul class="collapse list-unstyled" id="driverSubmenu">
                            <li>
                                <a href="{{ route('drivers') }}">
                                    Add Driver
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>Driver Location</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('mydrivers') }}">
                                    Moderate Drivers
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#fleetSubmenu" data-toggle="collapse" aria-expanded="false">
                            <i class="fa fa-car fa-fw" aria-hidden="true"></i>
                            <span>Fleet Management</span>
                        </a>
                        <ul class="collapse list-unstyled" id="fleetSubmenu">
                            <li>
                                <a href="{{ route('vehicles') }}">
                                    Vehicle's List
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('registerform') }}">
                                    Register Vehicle
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    Vehicle info/Diagnosis
                                </a>
                            </li>                            
                        </ul>
                    </li>                    
                    <li>
                        <a href="#cardSubmenu" data-toggle="collapse" aria-expanded="false">
                            <i class="fa fa-qrcode fa-fw" aria-hidden="true"></i>
                            <span>Card & QR Control</span>
                        </a>
                        <ul class="collapse list-unstyled" id="cardSubmenu">
                            <li>
                                <a href="{{ route('mycards') }}">
                                    My Cards
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('newcard') }}">
                                    Request for Card
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li title="Payment Options">
                        <a href="#"><i class="fa fa-money fa-fw"></i>
                            <span>Payment Options</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('wallet') }}">
                            <i class="fa fa-google-wallet fa-fw" aria-hidden="true"></i>
                            <span>Wallet</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-line-chart fa-fw"></i> 
                            <span>Consumption History</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div id="content">
                <nav class="navbar navbar-default navbar-static-top" style="border-bottom: 1px solid #7c0e3b;">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" id="sidebarCollapse" class="btn btn-default navbar-btn">
                                <i class="glyphicon glyphicon-align-justify"></i>
                            </button>

                            <a href="{{ route('reminders') }}" class="btn btn-default navbar-btn" title="View all reminders.">
                                <i class="fa fa-bell-o"></i>
                            </a>

                            <a href="{{ route('chats') }}" class="btn btn-default navbar-btn" title="View all chats.">
                                <i class="fa fa-comment-o"></i>
                            </a>

                            <a href="{{ route('calendar') }}" class="btn btn-default navbar-btn" title="View all your Calendar Events.">
                                <i class="fa fa-calendar"></i>
                            </a>
                            
                            <a href="{{ route('messages') }}" class="btn btn-default navbar-btn" title="View all messages.">
                                <i class="fa fa-envelope-o"></i>
                            </a>

                            <a href="{{ route('auditlog') }}" class="btn btn-default navbar-btn" title="Audit Log / Historicals.">
                                <i class="fa fa-history"></i>
                            </a>

                            <button class="btn btn-default navbar-btn" title="Search." data-toggle="modal" data-target="#searchModal">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>

                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <img src="../images/blank.jpg" style="width:45px; height:45px; margin-top:-15px; padding-right:4px;" alt="{{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}'s Logo'" />
                                    <span>
                                        <i class="standout">{{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}</i>
                                        <br />
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out" aria-hidden="true"> Logout </i>
                                        </a>
                                    </span>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <div class="text-center">
                    <h1 class="standout" id="pgheader" name="pgheader">@yield('page_heading')</h1>
                    @yield('content')
                </div>
            </div>
        </div>

        <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel"> Enter Search Criteria. </h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" id="searchForm" name="searchForm" method="POST" action="{{ route('search') }}">
                            {{ csrf_field() }}
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <label style="color:black; text-align:left; float:left;">Filter by</label>
                                    <br /><br />

                                    <div class="row" style="margin-bottom:15px;" title="Filter by">
                                        <div class="col-md-4">
                                            <input type="checkbox" id="filter" name="filter[]" class="filter" value="1" /> Calendars
                                        </div>
                                        <div class="col-md-4">
                                            <input type="checkbox" id="filter" name="filter[]" class="filter" value="2" /> Cards
                                        </div>
                                        <div class="col-md-4">
                                            <input type="checkbox" id="filter" name="filter[]" class="filter" value="3" /> Drivers
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom:15px;" title="Filter by">
                                        <div class="col-md-4">
                                            <input type="checkbox" id="filter" name="filter[]" class="filter" value="4" /> Notications
                                        </div>
                                        <div class="col-md-4">
                                            <input type="checkbox" id="filter" name="filter[]" class="filter" value="5" /> Transactions
                                        </div>
                                        <div class="col-md-4">
                                            <input type="checkbox" id="filter" name="filter[]" class="filter" value="6" /> Users
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom:15px;" title="Filter by">
                                        <div class="col-md-4">
                                            <input type="checkbox" id="filter" name="filter[]" class="filter" value="7" /> Vehicles
                                        </div>
                                        <div class="col-md-4">
                                            <input type="checkbox" id="filter" name="filter[]" class="filter" value="8" /> Wallets
                                        </div>
                                        <div class="col-md-4">
                                            <input type="checkbox" id="filter" name="filter[]" class="filter" checked="checked" value="0" /> All Objects
                                        </div>
                                    </div>
                    
                                    <div class="row" style="margin-top:20px;">
                                        <div class="col-md-12" title="Search For">
                                            <label for="car_type" style="color:black; text-align:left; float:left;">Search For</label>
                                            <br /><br />
                                            <input class="form-control required" id="searchText" name="searchText" type="text" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="searchButton" name="searchButton">
                            <i class="fa fa-save fa-5w">&nbsp;&nbsp;</i>
                            Search.
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="{{ mix('js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/toastr.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
        <script>
            var oTable;

            var settings = {
                "async": true,
                "crossDomain": true,
                "url": '',
                "method": "POST",
                "processData": false,
                "data": ''
            };

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            var wurafleet = {
                temp: '',
                auditenddate: '',
                auditstartdate: '',
                toastType : {
                    Info: 'info',
                    Error: 'error',
                    Success: 'success',
                    Warning: 'warning'
                },
                toastTitle: 'Wurafleet Notification Service'
            };

            function Notify(toastType, toastMessage) {
                toastr[toastType](toastMessage, wurafleet.toastTitle);
            }
        </script>
        @yield('scripts')
        <script type="text/javascript" src="{{ mix('js/frontend.js') }}"></script>
        
    </body>

</html>
