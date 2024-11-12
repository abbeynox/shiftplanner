<div class="flex sm:pt-8 sm:justify-end pt-0 justify-end">
@foreach($available_locales as $locale_name => $available_locale)
        @if($available_locale !== $current_locale)
            <a class="bg-green-800 hover:bg-green-600 py-2 px-4 rounded md:mr-4 text-white font-bold"
               href="/language/{{ $available_locale }}">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                    {{ $locale_name }}
                </span>
            </a>
        @endif
    @endforeach
</div>
