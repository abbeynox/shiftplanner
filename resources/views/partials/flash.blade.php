@if(Session::has('fail'))
    <div class="sm:m-6 sm:py-6 w-full bg-red-50 border border-red-500 p-4 my-2 rounded">
        {{Session::get('fail')}}
    </div>
@endif

@if(Session::has('info'))
    <div class="sm:m-6 sm:py-6 w-full bg-green-50 border p-4 my-2 rounded text-xl">
        {{Session::get('info')}}
    </div>
@endif
