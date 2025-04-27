<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
    {{-- Bootstrap --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
    {{-- Fontawesome --}}
    {{-- <script src="https://kit.fontawesome.com/6d462838cf.js" crossorigin="anonymous"></script> --}}
    {{-- Css --}}
    <link rel="stylesheet" href="{{asset('AdminAccountCss/AdminAccountBackground.css')}}">
    <link rel="stylesheet" href="{{asset('AdminAccountCss/AdminNavigation.css')}}">
    <link rel="stylesheet" href="{{asset('AdminAccountCss/AdminSidebar.css')}}">
    <title>{{$Title}}</title>
</head>
<body>

    {{-- Top Area --}}
    <div class="TopArea w-full h-4xl">

        <div class="MenuBtnArea" id="MenuBtnArea1">
            <button class="MenuBtn" onclick="toggleMenu()">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>

        <form action="{{route('Admin.Result')}}" method="GET" class="SearchBarArea">
            @csrf
            
            <input type="text" name="Search" class="SearchBox" placeholder="Search" autocomplete="on">
            <button type="submit" class="SearchBtn">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>{{-- Top Area --}}

    {{-- Main Area --}}
    <div class="MainArea">

        {{-- Left Side --}}
        <div class="LeftSide" id="NavBarArea">
            <div class="LogoArea">
                
            </div>
            <div class="ProfilePictureArea1">
                @if (Auth::user()->profile_picture)
                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="img-thumbnail profilepicture1">
                @else
                    <img src="{{ asset('images/DefaultImage.webp') }}" alt="No Profile Picture" class="img-thumbnail profilepicture1">
                @endif
            </div>            
            <div class="NameArea">
                <p>{{  Auth::user()->FirstName }}</p>
            </div>

            <div class="DashboardArea">
                <button class="Dashboard" onclick="redirectToAdminDashboard()">
                    <i class="fa-solid fa-chart-line"></i>
                    <span class="ButtonName">Dashboard</span>
                </button>
                
            </div>
            <div class="NewPatientArea">
                <button class="NewPatient" onclick="redirectToAdminNewPatient()">
                    <i class="fa-solid fa-user-injured"></i>
                    <span class="ButtonName">New Patient</span>
                </button>
            </div>
            <div class="PatientTableArea">
                <button class="PatientTable" onclick="redirectToPatientList()">
                    <i class="fa-solid fa-hospital-user"></i>
                    <span class="ButtonName">Patient Table</span>
                </button>
            </div>
            <div class="contain2">
                <form action="{{route ('RedirectTo.Settings')}}" method="GET" class="SettingsArea">
                    @csrf
                    @method('GET')
                    <input type="text" class="" name="SettingsPage"  value="{{Auth::user()->username}}" hidden>
                    <button type="submit" class="Settings"> 
                        <i class="fa-solid fa-gear"></i>
                        <span class="ButtonName">Setting</span>
                    </button>
                </form> 
                <div class="LogoutArea">
                    <form action="{{route('Log-Out')}}" method="POST" class="LogoutArea">
                        @csrf
                        @method('POST')
                        <button class="Logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="ButtonName">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>{{-- Left Side --}}

        {{-- Mid --}}
        <div class="Mid">

            {{$slot}}

        </div>{{-- Mid --}}

        {{-- Right Side --}}
        <div class="RightSide">

        </div>{{-- Right Side --}}
        
    </div>{{-- Main Area --}}

    {{-- Bottom Area --}}
    <div class="BottomArea">

    </div>{{-- Bottom Area --}}

</body>
    {{-- Javascript --}}
    <script src="{{asset('/javascript/Sidebar.js')}}" ></script>
    <script src="{{asset('/javascript/AdminBtn/AdminDashboardBtn.js')}}" ></script>
    <script src="{{asset('/javascript/AdminBtn/AdminNewPatientBtn.js')}}" ></script>
    <script src="{{asset('/javascript/AdminBtn/PatientListBtn.js')}}" ></script>
    <script src="{{asset('/javascript/AdminBtn/Settings.js')}}" ></script>
</html>
