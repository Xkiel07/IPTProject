<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css','resources/js/app.js'])
    {{-- Bootstrap --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
    {{-- Fontawesome --}}
    {{-- <script src="https://kit.fontawesome.com/6d462838cf.js" crossorigin="anonymous"></script> --}}
    {{-- Css --}}
    <link rel="stylesheet" href="{{asset('LoginCss/Background.css')}}">
    <title>Login</title>
</head>
<body>

    {{-- Login Container --}}
        <div class="LoginContainer us:bg-black us:w-full us:max-w-[250px] us:h-full us:max-h-[700px] us:mt-10 us:mx-auto us:rounded-md x:max-w-[400px]">
          <div class="Title us:flex us:pt-3 us:w-full us:h-fit">
              <label class="us:mx-auto us:font-semibold us:font-font-Arial us:text-2xl x:text-4xl us:text-white">Login As</label>
          </div>
          <div class="BtnArea us:w-full us:h-[100px] x:h-[150px] us:flex us:flex-row us:justify-evenly">
              <button type="button" class="btn bg-white us:opacity-100 us:w-[80px] us:h-[80px] x:w-[120px] x:h-[120px] us:my-auto" data-bs-toggle="modal" data-bs-target="#adminLoginModal">
                  <span><i class="fa-solid fa-user-tie us:text-5xl x:text-7xl"></i></span>
              </button>
              <button type="button" class="btn bg-white us:w-[80px] us:h-[80px] x:w-[120px] x:h-[120px] us:my-auto" data-bs-toggle="modal" data-bs-target="#staffLoginModal">
                  <span><i class="fa-solid fa-users us:text-5xl x:text-7xl"></i></span>
              </button>
          </div>
          <div class="ButtonName us:w-full us:h-[50px] us:grid us:grid-cols-7 us:mb-10">
              <span class="us:text-xl us:col-start-2 us:ml-1 us:mt-3 us:font-semibold us:font-font-Arial x:pl-4 x:text-2xl us:text-white">Admin</span>
              <span class="us:text-xl us:col-start-5 us:ml-5 us:mt-3 us:font-semibold us:font-font-Arial x:pl-4 x:text-2xl us:text-white">Staff</span>
          </div>

          {{-- Admin Modal --}}
          <div class="modal fade us:mt-11 Admin" id="adminLoginModal" tabindex="-1" aria-labelledby="adminLoginTitle" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header us:justify-center">
                          <h1 class="modal-title us:text-xl x:text-4xl" id="adminLoginTitle">Admin</h1>
                      </div>
                      <div class="modal-body">
                          <form action="{{ route('Login.AdminProcess') }}" method="POST" id="admin" class="AdminLoginForm">
                              @csrf
                              @method('POST')
                              <div class="AdminInputArea us:flex us:flex-col">
                                  <input type="text" name="username" class="AdminUsername us:my-1 x:text-lg" placeholder="Username *">
                                  <input type="password" name="password" class="AdminPassword us:my-1 x:text-lg" placeholder="Password *">
                              </div>
                              <div class="AdminLoginBtnArea us:flex us:flex-row us:justify-around us:my-1">
                                  <button type="submit" class="AdminLoginBtn btn bg-primary x:text-lg us:text-white">Login</button>
                                  <a href="{{ route('Forgot.Password') }}" class="ForgotPassword us:mt-2 x:text-lg">Forgot Password?</a>
                              </div>
                          </form>
                      </div>
                      <div class="modal-footer us:flex us:flex-col">
                        <div class="AdminFormErrors">
                          @if ($errors->any())
                          <div class="error-summary us:text-sm us:text-red-500">
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                          @endif
                      </div>
                      </div>
                  </div>
              </div>
          </div>

          {{-- Staff Modal --}}
          <div class="modal fade us:mt-11 Staff" id="staffLoginModal" tabindex="-1" aria-labelledby="staffLoginTitle" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header us:justify-center">
                          <h1 class="modal-title us:text-xl x:text-4xl" id="staffLoginTitle">Staff</h1>
                      </div>
                      <div class="modal-body">
                          <form action="{{ route('Login.StaffProcess') }}" method="POST" id="staff" class="StaffLoginForm">
                              @csrf
                              @method('POST')
                              <div class="StaffInputArea us:flex us:flex-col">
                                  <input type="text" name="username" class="StaffUsername us:my-1 x:text-lg" placeholder="Username *">
                                  <input type="password" name="password" class="StaffPassword us:my-1 x:text-lg" placeholder="Password *">
                              </div>
                              <div class="StaffLoginBtnArea us:flex us:flex-row us:justify-around us:my-1">
                                  <button type="submit" class="StaffBtn btn bg-primary x:text-lg us:text-white">Login</button>
                              </div>
                          </form>
                      </div>
                      <div class="modal-footer us:flex us:flex-col">
                        <div class="StaffFormErrors">
                          @if ($errors->any())
                          <div class="error-summary us:text-sm us:text-red-500">
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                          @endif
                      </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
  {{-- Login Container --}}

</body>
    {{-- Javascript --}}
    <script src="{{asset('/javascript/Adminpopup.js')}}" ></script>
    <script src="{{asset('/javascript/Staffpopup.js')}}" ></script>
</html>
