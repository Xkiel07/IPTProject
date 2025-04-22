<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Bootstrap --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
    {{-- Fontawesome --}}
    <script src="https://kit.fontawesome.com/6d462838cf.js" crossorigin="anonymous"></script> 
    {{-- Css --}}
    <link rel="stylesheet" href="{{asset('LoginCss/Background.css')}}">
    <link rel="stylesheet" href="{{asset('LoginCss/Dimesions.css')}}" >
    <link rel="stylesheet" href="{{asset('LoginCss/LoginFormContainer.css')}}" >
    <link rel="stylesheet" href="{{asset('LoginCss/AdminForm.css')}}" >
    <link rel="stylesheet" href="{{asset('LoginCss/StaffForm.css')}}" >
    <title>Login</title>
</head>
<body>

    {{-- Top Area --}}
    <div class="TopArea">

    </div>{{-- Top Area --}}

    {{-- Main Area --}}
    <div class="MainArea"> 

        {{-- Left Side --}}
        <div class="LeftSide">

        </div>{{-- Left Side --}}

        {{-- Mid --}}
        <div class="Mid">

            {{-- Login Container --}}
            <div class="LoginContainer">

                {{-- Title Area --}}
                <div class="Title">
                    Login as
                </div>{{-- Title Area --}}

                {{-- Form Btns --}}
                <div class="BtnArea">
                 <button class="AdminFormBtn bg-white" onclick="openAdminPopup()">
                    <i class="fa-solid fa-user-tie"></i>
                 </button>
                 <button class="UserFormBtn bg-white" onclick="openStaffPopup()">
                    <i class="fa-solid fa-users"></i>
                 </button>
                </div>{{-- Form Btns --}}

                {{-- Btns Label --}}
                <div class="BtnsLabel">
                    <div class="AdminLabelArea">
                        <label class="AdminLabel">Admin</label>
                    </div>
                    <div class="StaffLabelArea">
                        <label class="StaffLabel">Staff</label>
                    </div>
                </div>{{-- Btns Label --}}

                {{-- Admin Login Form --}}
                {{-- {{route('Login.AdminProcess')}} --}}
                <form action="https://iptproject-idxs.onrender.com/Login-Admin-Page" method="POST" id="admin" class="AdminLoginForm">
                    @csrf
                    @method('POST')
                    <div class="AdminFormName">
                        Admin
                    </div>

                    <div class="AdminInputArea">
                        <input type="text" name="username" class="AdminUsername" placeholder="Username *">
                        <input type="password" name="password" class="AdminPassword" placeholder="Password *">
                    </div>
                    <div class="AdminLoginBtnArea">
                        <button type="submit" class="btn btn-primary AdminLoginBtn">
                            Login
                          </button>
                        <a href="{{route('Forgot.Password')}}" class="ForgotPassword">Forgot Password?</a>
                    </div>
                    <div class="AdminFormErrors">
                        @if ($errors->any())
                        <div class="error-summary">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>

                      
                </form>{{-- Admin Login Form --}}

                
                {{-- Staff Login Form --}}
                <form action="https://iptproject-idxs.onrender.com/Login-Staff-Page" method="POST" id="staff"  class="StaffLoginForm">
                    @csrf
                    @method('POST')
                    <div class="StaffFormName">
                        Staff
                    </div>

                    <div class="StaffInputArea">
                        <input type="text" name="username" class="StaffUsername" placeholder="Username *">
                        <input type="password" name="password" class="StaffPassword" placeholder="Password *">
                    </div>

                    <div class="StaffLoginBtnArea">
                        <button type="submit" class="StaffLoginBtn bg-primary">Login</button>
                    </div>
                    <div class="StaffFormErrors">
                        @if ($errors->any())
                        <div class="error-summary">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </form>{{-- Staff Login Form --}}
                
                
            </div>{{-- Login Container --}}

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
    <script src="{{asset('/javascript/Adminpopup.js')}}" ></script>
    <script src="{{asset('/javascript/Staffpopup.js')}}" ></script>
</html>
