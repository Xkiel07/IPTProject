<x-AdminNavigation>
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('AdminAccountCss/ActiveAccountList.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- JavaScript --}}
    <script src="{{ asset('/javascript/jquery.js') }}"></script>
    
    <x-slot:Title>
        Account List
    </x-slot:Title>

    {{-- Active Account List --}}
    <div class="ActiveAccountArea us:bg-white us:w-auto us:h-auto us:max-h-[300px] us:mt-3 us:mx-3">
        <div class="ActiveTitleArea us:bg-blue-500 us:w-full us:flex us:rounded-t-md">
            <label class="us:text-white us:font-semibold us:text-xl us:mx-auto us:py-1">Active Accounts</label>    
        </div>
        <div class="Error">
            @error('') {{-- Handle specific error messages --}}
            <div class="">{{ $message }}</div>
            @enderror
        </div>
        <div class="TableArea us:overflow-x-auto us:max-h-[260px] us:h-fit">
            <table class="AccountsTable">
                <thead>
                    <tr>
                        <th class="NameLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:py-2">Name</th>
                        <th class="UsernameLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:py-2">Username</th>
                        <th class="PositionLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:py-2">Position</th>
                        <th class="StatusLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:py-2">Status</th>
                        <th class="ActionsLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:py-2">Actions</th>
                    </tr>
                </thead>
                <tbody id="ActiveAccountsList">
                    {{-- Active accounts will be populated here dynamically --}}
                </tbody>
            </table>
        </div>
    </div>

    {{-- Deactivated Account List --}}
    <div class="DeactivatedAccountArea us:bg-white us:w-auto us:h-auto us:max-h-[350px] us:mt-5 us:mx-3">
        <div class="TitleArea us:bg-blue-500 us:w-full us:flex us:rounded-t-md">
            <label class="us:text-white us:font-semibold us:text-xl us:mx-auto us:py-1">Deactivated Accounts</label>
        </div>
        <div class="Error">
            @error('') {{-- Handle error messages for deactivated accounts --}}
            <div class="">{{ $message }}</div>
            @enderror
        </div>
        <div class="TableArea us:overflow-x-auto us:max-h-[260px] us:h-fit">
            <table class="AccountsTable table-auto">
                <thead>
                    <tr>
                        <th class="NameLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:py-2">Name</th>
                        <th class="UsernameLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:py-2">Username</th>
                        <th class="PositionLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:py-2">Position</th>
                        <th class="StatusLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:py-2">Status</th>
                        <th class="ActionsLabel us:px-3 us:text-center us:text-sm us:font-font-Arial us:py-2">Actions</th>
                    </tr>
                </thead>
                <tbody id="DeActivatedAccountsList">
                    {{-- Deactivated accounts will be populated here dynamically --}}
                </tbody>
            </table>
        </div>
    </div>

    {{-- Script to handle data fetching and table population --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function fetchData() {
                fetch('{{ route("Fetch.AccountList") }}', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const ActiveListOfAccounts = document.getElementById('ActiveAccountsList');
                    const DeActivatedListOFAccounts = document.getElementById('DeActivatedAccountsList');

                    // Clear existing rows
                    ActiveListOfAccounts.innerHTML = '';
                    DeActivatedListOFAccounts.innerHTML = '';

                    // Populate Active Accounts
                    data.ActiveAccounts.forEach(function(account) {
                        const row = `
                            <tr>
                                <td class="Name us:px-3 us:text-center us:text-sm">${account.FirstName} ${account.MiddleName} ${account.LastName}</td>
                                <td class="Username us:px-3 us:text-center us:text-sm">${account.username}</td>
                                <td class="Position us:px-3 us:text-center us:text-sm">${account.Position}</td>
                                <td class="${account.ActivityStatus === 'Online' ? 'Online' : 'Offline'}">
                                    ${account.ActivityStatus === 'Online' ? `
                                        <div class="OnlineArea us:grid us:grid-cols-4">
                                            <div class="bg-success bg-gradient us:w-4 us:h-4 us:rounded-full"></div>
                                            <span>Online</span>
                                        </div>` 
                                    : `
                                        <div class="OfflineArea us:grid us:grid-cols-4">
                                            <div class="bg-danger bg-gradient us:w-4 us:h-4 us:rounded-full"></div>
                                            <span>Offline</span>
                                        </div>`}
                                </td>
                                <td class="BtnArea us:flex us:justify-center us:px-3">
                                    <form action="{{ route('Redirect.UpdateAccount') }}" method="GET">
                                        @csrf
                                        <input type="text" name="username" value="${account.username}" hidden>
                                        <button type="submit" class="btn btn-info">Update</button>
                                    </form>
                                    <form action="{{ route('Admin.Deactivated') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" name="Deactivate" value="${account.username}" class="btn btn-danger">Deactivate</button>
                                    </form>
                                </td>
                            </tr>`;
                        ActiveListOfAccounts.insertAdjacentHTML('beforeend', row);
                    });

                    if (data.ActiveAccounts.length === 0) {
                        ActiveListOfAccounts.innerHTML = `
                            <tr>
                                <td colspan="5" class="us:px-3 us:text-center us:text-sm">No active accounts available.</td>
                            </tr>`;
                    }

                    // Populate Deactivated Accounts
                    data.DeactivatedAccounts.forEach(function(account) {
                        const row = `
                            <tr>
                                <td class="Name us:px-3 us:text-center us:text-sm">${account.FirstName} ${account.MiddleName} ${account.LastName}</td>
                                <td class="Username us:px-3 us:text-center us:text-sm">${account.username}</td>
                                <td class="Position us:px-3 us:text-center us:text-sm">${account.Position}</td>
                                <td class="Status">${account.ActivityStatus}</td>
                                <td class="BtnArea us:flex us:justify-center us:px-3">
                                    <form action="{{ route('Redirect.UpdateAccount') }}" method="GET">
                                        @csrf
                                        <input type="text" name="username" value="${account.username}" hidden>
                                        <button type="submit" class="btn btn-info">Update</button>
                                    </form>
                                </td>
                            </tr>`;
                        DeActivatedListOFAccounts.insertAdjacentHTML('beforeend', row);
                    });

                    if (data.DeactivatedAccounts.length === 0) {
                        DeActivatedListOFAccounts.innerHTML = `
                            <tr>
                                <td colspan="5" class="us:px-3 us:text-center us:text-sm">No deactivated accounts available.</td>
                            </tr>`;
                    }
                })
                .catch(error => console.error('Error fetching account data:', error));
            }

            fetchData();
        });
    </script>
</x-AdminNavigation>
