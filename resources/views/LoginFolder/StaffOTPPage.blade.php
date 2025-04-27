<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="preload" as="style" href="https://iptproject-idxs.onrender.com/build/assets/app-B-IqB1m-.css" /><link rel="preload" as="style" href="https://iptproject-idxs.onrender.com/build/assets/app-B7vS8Mbm.css" /><link rel="modulepreload" href="https://iptproject-idxs.onrender.com/build/assets/app-D0pfYVUt.js" /><link rel="stylesheet" href="https://iptproject-idxs.onrender.com/build/assets/app-B-IqB1m-.css" /><link rel="stylesheet" href="https://iptproject-idxs.onrender.com/build/assets/app-B7vS8Mbm.css" /><script type="module" src="https://iptproject-idxs.onrender.com/build/assets/app-D0pfYVUt.js"></script>
    {{-- Bootstrap --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
    {{-- Fontawesome --}}
    {{-- <script src="https://kit.fontawesome.com/6d462838cf.js" crossorigin="anonymous"></script> --}}
    {{-- Css --}}
    <link rel="stylesheet" href="{{asset('LoginCss/Background.css')}}">
    <link rel="stylesheet" href="{{asset('LoginCss/OTP.css')}}" >
    <title>OTP Confirmation</title>
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

            {{-- OTP Container --}}
            <div class="OTPContainer">

                {{-- OTP Form --}}
                <div class="OTPForm">
                {{-- form for inputing the OTP to verifying --}}
                <form action="{{route('StaffOTP.Confirm')}}" method="POST" class="">
                    @csrf
                    @method('POST')
                    <div class="OTPLabelArea">
                        <h2 class="OTPLAbel">Enter the OTP for verification.</h2>
                    </div>
                    <div class="OTPInput">
                        <input type="text" name="OTPcode" class="OTPValue">
                    </div>
                    <div class="OTPerror">
                        @error('OTPcode')
                        <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="OTPBtnArea">
                        <button type="submit" class="btn btn-primary OTPBtn">Confirm</button>
                    </div>
                </form>{{-- OTP Form --}}
                </div>
            </div>{{-- OTP Container --}}

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
