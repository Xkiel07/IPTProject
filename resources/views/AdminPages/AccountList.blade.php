<x-AdminNavigation>
    {{-- Css --}}
    <link rel="stylesheet" href="{{ asset('AdminAccountCss/ActiveAccountList.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="{{asset('/javascript/jquery.js')}}" ></script>
    
    <x-slot:Title>
        Account List
    </x-slot:Title>

    {{-- Active Account List --}}
    <div class="ActiveAccountArea us:bg-white us:w-auto us:h-auto us:max-h-[300px] us:mt-3 us:mx-3">
        <div class="ActiveTitleArea us:bg-blue-500 us:w-full us:flex us:rounded-t-md">
            <label class="us:text-white us:font-semibold us:font-font-Arial us:italic us:text-xl us:mx-auto us:py-1 x:text-2xl x:py-1">Active Accounts</label>    
        </div>
        <div class="Error">
            @error('')
            <div class="">{{ $message }}</div>
            @enderror
        </div>
        <div class="TableArea us:overflow-x-auto us:overflow-y-auto us:max-h-[260px] us:h-fit">
            <table class="AccountsTable">
                <thead>
                <tr class="">
                    <th class="NameLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">Name</th>
                    <th class="UsernameLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">Username</th>
                    <th class="PositionLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">Position</th>
                    <th class="StatusLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">Status</th>
                    <th class="ActionsLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">Actions</th>
                </tr>
            </thead>

            <tbody id="ActiveAccountsList" class="">
                
            </tbody>
            </table>
        </div>
    </div>{{-- Active Account List --}}

    {{-- ------------------------------------------------------------------------------------------------- --}}

    {{-- Deactivated Account List --}}
    <div class="DeactivatedAccountArea us:bg-white us:w-auto us:h-auto us:max-h-[350px] us:mt-5 us:mx-3">
        <div class="TitleArea us:bg-blue-500 us:w-full us:flex us:rounded-t-md">
            <label class=" us:text-white us:font-semibold us:font-font-Arial us:italic us:text-xl us:mx-auto us:py-1 x:text-2xl x:py-1">Deactivated Accounts</label>
        </div>
        <div class="Error">
            @error('')
            <div class="">{{ $message }}</div>
            @enderror
        </div>
        <div class="TableArea us:overflow-x-auto us:overflow-y-auto us:max-h-[260px] us:h-fit">
            <table class="AccountsTable table-auto">
                <thead>
                <tr class="">
                    <th class="NameLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">Name</th>
                    <th class="UsernameLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">Username</th>
                    <th class="PositionLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">Position</th>
                    <th class="StatusLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">Status</th>
                    <th class="ActionsLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">Actions</th>
                </tr>
                </thead>
                <tbody id="DeActivatedAccountsList" class=" ">
                </tbody>
            </table>
        </div>
    </div>
    {{-- Deactivated Account List --}}


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function fetchData() {
            fetch('{{ route("Fetch.AccountList") }}', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Include the CSRF token here
                }
            })
            .then(response => response.json())
            .then(data => {
                var ActiveListOfAccounts = document.getElementById('ActiveAccountsList');
                var DeActivatedListOFAccounts = document.getElementById('DeActivatedAccountsList');

                // Clear any existing rows to prevent repeating the list
                ActiveListOfAccounts.innerHTML = '';
                DeActivatedListOFAccounts.innerHTML = '';

                // Populate active accounts
                data.ActiveAccounts.forEach(function(account) {
                    var row = `
                        <tr class=" us:place-content-center">
                            <td class="Name us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">${account.FirstName} ${account.MiddleName} ${account.LastName}</td>

                            <td class="Username us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">${account.username}</td>

                            <td class="Position us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">${account.Position}</td>

                            <td class=" ${account.ActivityStatus === 'Online' ? '' : 'offline'}">${account.ActivityStatus === 'Online' ? '<div class="OnlineArea us:grid us:grid-cols-4"><div class="bg-success bg-gradient us:mt-3 us:w-3 us:h-3 x:mt-3.5 x:mx-1 x:w-4 x:h-4 us:rounded-full us:col-start-2 us:col-end-2"></div><span class="Online x:ml-1 us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">Online</span></div>' : '<div class="OfflineArea us:grid us:grid-cols-4"><div class="bg-danger bg-gradient us:mt-3 us:w-3 us:h-3 x:mt-3.5 x:mx-1 x:w-4 x:h-4 us:rounded-full us:col-start-2 us:col-end-2"></div><span class="Offline x:ml-1 us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">Offline</span></div>'}
                            </td>

                            <td class="BtnArea us:flex us:flex-row us:w-max us:px-5">
                                <form action="{{ route('Redirect.UpdateAccount') }}" method="GET" class=" us:mx-2 us:mt-8 us:mb-9 x:mt-8">
                                    @csrf
                                    <input type="text" name="username" value="${account.username}" hidden>
                                    <button type="submit" class="btn btn-info Update">Update</button>
                                </form>
                                <form action="{{ route('Admin.Deactivated') }}" method="POST" class=" us:mx-2 us:mt-8 us:mb-9 x:mt-8">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="Deactivate" value="${account.username}" class="btn btn-danger Deactivate ">Deactivate</button>
                                </form>
                            </td>
                        </tr>`;
                    ActiveListOfAccounts.insertAdjacentHTML('beforeend', row);
                });
                if (data.ActiveAccounts.length === 0) {
                    ActiveListOfAccounts.innerHTML = `
                        <tr>
                            <td colspan="5" class=" us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">No active accounts available.</td>
                        </tr>`;
                }
                // Populate deactivated accounts
                data.DeactivatedAccounts.forEach(function(account) {
                    var row = `
                        
                        <tr>
                            <td class="Name us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">${account.FirstName} ${account.MiddleName} ${account.LastName}</td>

                            <td class="Username us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">${account.username}</td>

                            <td class="Position us:px-3 us:text-center us:text-sm us:font-font-Arial us:placeholder:italic us:placeholder:font-semibold us:py-2 x:text-lg">${account.Position}</td>
                            
                            <td class="${account.ActivityStatus === 'Online' ? '' : 'offline'}
