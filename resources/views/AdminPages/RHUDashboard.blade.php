@if(Auth::check() && Auth::user()->Position === 'Admin')
    <x-AdminNavigation>
@else
    <x-StaffNavigation>
@endif

{{-- Load Google Charts only once --}}
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {packages:['corechart']});
    google.charts.setOnLoadCallback(fetchDashboardData);
</script>

{{-- CSS --}}
<link rel="stylesheet" href="{{ asset('AdminAccountCss/Dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('AdminAccountCss/FirstArea.css') }}">
<link rel="stylesheet" href="{{ asset('AdminAccountCss/SecondArea.css') }}">
<link rel="stylesheet" href="{{ asset('AdminAccountCss/ThirdArea.css') }}">

<x-slot name="Title">
    Dashboard
</x-slot>

{{-- Dashboard --}}
<div class="DashboardForm bg-neutral-400 us:mt-3 us:w-5/6 us:h-fit us:max-h-[700px] lg:max-h-fit us:mx-auto us:grid us:grid-flow-row us:rounded-md us:overflow-auto md:w-11/12 gap-1">

    <div class="Title us:bg-blue-500 us:w-full us:flex">
        <span class="DashboardTitle us:text-white us:font-semibold us:font-font-Arial us:italic us:text-xl us:mx-auto us:py-1 x:text-2xl x:py-1">Dashboard</span>
    </div>

    <div class="FirstArea us:full us:h-fit us:grid us:grid-cols-2 us:m-0 us:p-0 md:grid-cols-3 gap-1">
        <div class="ThisMonthCount w-full h-full us:text-center us:grid us:grid-rows-3 bg-white">
            <span class="ThisMonth us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-lg md:text-lg">This Month</span>
            <span class="us:text-md us:font-semibold font-font-Arial us:mx-2 x:text-3xl md:text-3xl" id="Total"></span>  
            <span class="us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">Total Patient</span>
        </div>

        <div class="Month w-full h-full us:text-center us:grid us:grid-rows-3 bg-white">
            <span class="us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-lg md:text-lg">This Month PieChart</span>
            <span class="us:text-md us:font-semibold font-font-Arial us:mx-2 x:text-3xl md:text-3xl" id="Month"></span>
            <span class="us:text-md us:font-semibold font-font-Arial us:mx-2 x:text-sm md:text-sm" id="Year"></span>
        </div>

        <div class="PieChartFigure w-full h-fit us:justify-center us:col-span-2 md:col-span-1 md:row-span-2 md:h-full bg-white">
            <div id="piechart_3d" class="us:m-0 us:p-0 us:w-full us:h-full"></div>
        </div>

        <div class="Highest us:text-center us:col-span-2 us:grid us:grid-rows-3 md:col-span-1 bg-white" id="HighestConsultationArea"></div>
        <div class="Lowest us:text-center us:col-span-2 us:grid us:grid-rows-3 md:col-span-1 bg-white" id="LowestConsultationArea"></div>
    </div>

    <div class="SecondArea us:w-full us:h-auto us:max-h-[200px] us:m-0 us:p-0 us:overflow-auto">
        <div class="us:w-full us:h-auto px-1">
            <table class="text-center border table table-striped table-hover">
                <thead id="BreakDownLabel"></thead>
                <tbody id="BreakDown"></tbody>
            </table>
        </div>
    </div>

    <div class="ThirdArea bg-white us:w-full us:h-fit us:m-0 us:p-0 us:overflow-auto">
        <div class="Graph w-full us:w-full h-fit">
            <div id="chart_div" class="us:w-full us:h-fit us:min-h-fit us:text-tiny" style="overflow: hidden;"></div>
        </div>
    </div>
</div>

{{-- JS --}}
<script src="{{ asset('/javascript/Date.js') }}"></script>
<script src="{{ asset('javascript/AdminBtn/DashboardOutput.js') }}"></script>

@if(Auth::check() && Auth::user()->Position === 'Admin')
    </x-AdminNavigation>
@else
    </x-StaffNavigation>
@endif
