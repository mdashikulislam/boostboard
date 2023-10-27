@extends('panel.layout.app')
@section('title', 'Dashboard')

@section('content')
    <style>
        /* Style for the closable section */
        #closable {
            position: relative;
        }

        /* Style for the cross icon */
        .cross {
            position: absolute;
            top: -25px;
            right: 10px;
            width: 30px;
            height: 20px;
            cursor: pointer;
            z-index: 10;
            /* background: #fff;
            border-radius: 5px; */
        }
        .cross:before, .cross:after {
            content: '';
            position: absolute;
            width: 2px;
            height: 15px;
            background-color: #000;
            top: 3px;
            left: 14px;
            transform-origin: center;
        }
        .cross:before {
            transform: rotate(45deg);
        }
        .cross:after {
            transform: rotate(-45deg);
        }
        @media screen and (max-width:799px){
            iframe{
                width: 100%;
            }
        }
    </style>
    <div class="page-header dashboard-header">
        <div class="container">
            <div class="row g-2 items-center justify-between max-md:flex-col max-md:items-start max-md:gap-4">
                <div class="col">
                    <div class="page-pretitle">
                        {{ __('User Dashboard') }}
                    </div>
                    <h2 class="mb-2 page-title">
                        {{ __('Welcome') }}, {{ \Illuminate\Support\Facades\Auth::user()->name }}.
                    </h2>
                </div>
                <div class="col-auto">
                    <div class="btn-list">
                        <a href="{{ LaravelLocalization::localizeUrl(route('dashboard.user.openai.documents.all')) }}"
                            class="btn">
                            {{ __('My Documents') }}
                        </a>
                        <a href="{{ LaravelLocalization::localizeUrl(route('dashboard.user.openai.list')) }}"
                            class="btn btn-primary items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="!me-2" width="18" height="18"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            {{ __('New') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body user-page-body">
        <div class="container">
            <div class="row">
                <div class="col-12" id="closable">
                    <div class="cross" id="cross"></div>
                    <div class="single-card">
                        <div class="card-wrapper">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-6 col-lg-8">
                                    <div class="card-text text-card">
                                        {{-- <h2>🎥 Getting Started!</h2> --}}
                                        {{-- <p> <span>Hey Student!</span> Welkom bij BoostBoard! Wil je alle ins en outs van BoostBoard leren kennen? Bekijk dan onze handige introductievideo!</p> --}}
                                        <h2>Hey 
                                            <span class="up-icon">
                                                Student!
                                                <img class="light-shape" src="/images/dashboard/light-shape.svg" alt="shape">
                                            </span>
                                        </h2>
                                        <p>
                                            <span>Welkom bij BoostBoard!</span>
                                             We laten je met veel plezier zien hoe je BoostBoard inzet om nóg betere verslagen en teksten te schrijven! Bespaar tijd en geniet zo nóg meer van de leuke kanten van het studentenleven!
                                        </p>
                                        <img class="mike-shape" src="/images/dashboard/mike-shape.svg" alt="mike shape">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="relative card-video">
                                        <iframe src="https://www.youtube.com/embed/xvEQeuq_wH8" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="col-lg-8 col-md-6 col-12">
                    <div class="single-card">
                        <div class="card-wrapper overview-card">
                            <img class="overview-shape" src="/images/dashboard/overview-shape.svg" alt="shape">
                            <h2 class="title black">{{ __('Overview') }}</h2>
                            <div class="content-wrap">
                                <div class="count-wrapper">
                                    <div class="count-single">
                                        <p class="count-title">{{ __('Words Left') }}</p>
                                        <p class="count">
                                            @if (Auth::user()->remaining_words == -1)
                                                Unlimited
                                            @else
                                                {{ number_format((int) Auth::user()->remaining_words) }}
                                            @endif
                                        </p>
                                    </div>
                                    @if ($setting->feature_ai_image)
                                        <div class="count-single">
                                            <p class="count-title">{{ __('Images Left') }}</p>
                                            <p class="count">
                                                @if (Auth::user()->remaining_images == -1)
                                                    Unlimited
                                                @else
                                                    {{ number_format((int) Auth::user()->remaining_images) }}
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                    <div class="count-single">
                                        <p class="count-title">{{ __('Hours Saved') }}</p>
                                        <p class="count">
                                            {{ number_format(($total_words * 0.5) / 60) }}</p>
                                    </div>
                                </div>
                                <div class="progress-bar-single">
                                    <h2 class="title black progress-title">{{ __('Your Documents') }}</h2>
                                    <div class="progress progress-separated">
                                        @if ($total_documents != 0)
                                            <div class="progress-bar grow-0 shrink-0 basis-auto bg-primary"
                                                role="progressbar"
                                                style="width: {{ (100 * (int) $total_text_documents) / (int) $total_documents }}%"
                                                aria-label="{{ __('Text') }}"></div>
                                        @endif
                                        @if ($setting->feature_ai_image && $total_documents != 0)
                                            <div class="progress-bar grow-0 shrink-0 basis-auto bg-[#9E9EFF]"
                                                role="progressbar"
                                                style="width: {{ (100 * (int) $total_image_documents) / (int) $total_documents }}%"
                                                aria-label="{{ __('Images') }}"></div>
                                        @endif
                                    </div>
                                    <div class="row report-wrap">
                                        <div class="col-auto d-flex align-items-center">
                                            <span class="legend text-legend"></span>
                                            <span>{{ __('Text') }}</span>
                                            <span
                                                class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{ $total_text_documents }}</span>
                                        </div>
                                        @if ($setting->feature_ai_image)
                                            <div class="col-auto d-flex align-items-center">
                                                <span class="legend image-legend"></span>
                                                <span>{{ __('Image') }}</span>
                                                <span
                                                    class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{ $total_image_documents }}</span>
                                            </div>
                                        @endif
                                        <div class="col-auto d-flex align-items-center">
                                            <span class="legend bg-success"></span>
                                            <span>{{ __('Total') }}</span>
                                            <span
                                                class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{ $total_documents }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-card">
                        <div class="card-wrapper upgrade-card">
                            <img class="air-shape" src="/images/dashboard/air-shape.svg" alt="shape">
                            <h2 class="title white">Upgraden</h2>
                            <p class="content">Je bent momenteel geabonneerd op het <span>Premium abonnement.</span> Deze wordt automatisch vernieuwd over 30 dagen.</p>
                            <div class="button-box-plus">
                                <a href="#" class="upgrade-btn plus-btn">
                                    <img src="/images/dashboard/plus.svg" alt="plus">
                                    Tokens bijkopen
                                </a>

                            </div>
                            <div class="button-box-minus">
                                <a href="#" class="upgrade-btn minus-btn">
                                    <img src="/images/dashboard/minus.svg" alt="minus">
                                    Abonnement opzeggen
                                </a>                                
                            </div>
                        </div>
                    </div>
                </div>
{{-- 
                <div class="col-12">
                    @include('panel.user.payment.subscriptionStatus')
                </div>

                @if ($ongoingPayments != null)
                    <div class="col-lg-4 col-md-6 col-12">
                        @include('panel.user.payment.ongoingPayments')
                    </div> 
                @endif --}}
                
                {{-- <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-heading">{{ __('Documents') }}</h3>
                        </div>
                        <div class="card-table table-responsive">
                            <table class="table table-vcenter">
                                <tbody>
                                    @foreach (Auth::user()->openai()->orderBy('created_at', 'desc')->take(4)->get() as $entry)
                                        @if ($entry->generator != null)
                                            <tr>
                                                <td class="w-1 !pe-0">
                                                    <span class="avatar w-[43px] h-[43px] [&_svg]:w-[20px] [&_svg]:h-[20px]"
                                                        style="background: {{ $entry->generator->color }}">
                                                        @if ($entry->generator->image !== 'none')
                                                            {!! html_entity_decode($entry->generator->image) !!}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="td-truncate">
                                                    <a href="{{ LaravelLocalization::localizeUrl(route('dashboard.user.openai.documents.single', $entry->slug)) }}"
                                                        class="block text-truncate text-heading hover:no-underline">
                                                        <span class="font-medium">{{ __($entry->generator->title) }}</span>
                                                        <br>
                                                        <span
                                                            class="italic text-muted opacity-80 dark:!text-white dark:!opacity-50">{{ __($entry->generator->description) }}</span>
                                                    </a>
                                                </td>
                                                <td class="text-nowrap">
                                                    <span class="text-heading">{{ __('in Workbook') }}</span>
                                                    <br>
                                                    <span
                                                        class="italic text-muted opacity-80 dark:!text-white dark:!opacity-50">{{ $entry->created_at->format('M d, Y') }}</span>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-heading">{{ __('Favorite Templates') }}</h3>
                        </div>
                        <div class="card-table table-responsive">
                            <table class="table table-vcenter">
                                <tbody>
                                    @php 
                                        $plan = Auth::user()->activePlan();
                                        $plan_type = 'regular';

                                        if ( $plan != null ) {
                                            $plan_type = strtolower($plan->plan_type);
                                        }
                                    @endphp
                                    @foreach (\Illuminate\Support\Facades\Auth::user()->favoriteOpenai as $entry)
                                        @php
                                            $upgrade = false;
                                            if ( $entry->premium == 1 && $plan_type === 'regular' ){
                                                $upgrade = true;
                                            }
                                        @endphp
                                        <tr class="relative">
                                            <td class="w-1 !pe-0">
                                                <span class="avatar w-[43px] h-[43px] [&_svg]:w-[20px] [&_svg]:h-[20px]"
                                                    style="background: {{ $entry->color }}">
                                                    @if ($entry->image !== 'none')
                                                        {!! html_entity_decode($entry->image) !!}
                                                    @endif

                                                    @if ($entry->active == 1)
                                                        <span class="badge bg-green !w-[9px] !h-[9px]"></span>
                                                    @else
                                                        <span class="badge bg-red !w-[9px] !h-[9px]"></span>
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="td-truncate">
                                                @if($upgrade)
                                                    <div class="absolute top-0 left-0 w-full h-full transition-all z-2 @if($upgrade) bg-white opacity-75 dark:!bg-black @endif">
                                                        <div class="absolute top-4 left-1/2 z-10 bg-[#E2FFFC] text-black font-medium p-2 rounded-md">
                                                            {{__('Upgrade')}}
                                                        </div>
                                                        <a href="{{ LaravelLocalization::localizeUrl(route('dashboard.user.payment.subscription')) }}" class="z-20 inline-block w-full h-full absolute top-0 left-0 overflow-hidden -indent-[99999px]">
                                                            {{__('Upgrade')}}
                                                        </a>
                                                    </div>
                                                    <a href="#"
                                                        class="text-heading hover:no-underline">
                                                        <span class="font-medium">{{ __($entry->title) }}</span>
                                                        <br>
                                                        <span class="block italic text-muted opacity-80 text-truncate dark:!text-white dark:!opacity-50">{{ __($entry->description) }}</span>
                                                    </a>
                                                @elseif ($entry->active == 1)
                                                    <a href="@if ($entry->type == 'voiceover') {{ LaravelLocalization::localizeUrl(route('dashboard.user.openai.generator', $entry->slug)) }}@else {{ LaravelLocalization::localizeUrl(route('dashboard.user.openai.generator.workbook', $entry->slug)) }} @endif"
                                                        class="text-heading hover:no-underline">
                                                        <span class="font-medium">{{ __($entry->title) }}</span>
                                                        <br>
                                                        <span class="block italic text-muted opacity-80 text-truncate dark:!text-white dark:!opacity-50">{{ __($entry->description) }}</span>
                                                    </a>
                                                @else
                                                    <div class="text-heading hover:no-underline">
                                                        <span class="font-medium">{{ __($entry->title) }}</span>
                                                        <br>
                                                        <span class="block italic text-muted opacity-80 text-truncate dark:!text-white dark:!opacity-50">{{ __($entry->description) }}</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-nowrap">
                                                <span class="text-heading">{{ __('in Workbook') }}</span>
                                                <br>
                                                <span
                                                    class="italic text-muted opacity-80">{{ $entry->created_at->format('M d, Y') }}</span>
                                            </td>
                                        </tr>
                                        @if ($loop->iteration == 4)
                                        @break
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> --}}
                <div class="col-lg-6 col-12">
                    <div class="table-wrapper">
                        <h2 class="table-title">Documenten</h2>
                        <div class="single-content">
                            <div class="content-details">
                                <div class="avatar">
                                    <img class="table-avater" src="/images/dashboard/table-avater.svg" alt="avatar">
                                </div>
                                <div class="content">
                                    <p>Schrijf een samenvatting.</p>
                                    <span>Creëer een beknopt overzicht van een tekst of materiaal vo...</span>
                                </div>
                            </div>
                            <div class="content-date">
                                <p class="month">in Documenten</p>
                                <span class="month date">15 Okt, 2023</span>
                            </div>
                        </div>
                        <div class="single-content">
                            <div class="content-details">
                                <div class="avatar">
                                    <img class="table-avater" src="/images/dashboard/table-avater.svg" alt="avatar">
                                </div>
                                <div class="content">
                                    <p>Schrijf een samenvatting.</p>
                                    <span>Creëer een beknopt overzicht van een tekst of materiaal vo...</span>
                                </div>
                            </div>
                            <div class="content-date">
                                <p class="month">in Documenten</p>
                                <span class="month date">15 Okt, 2023</span>
                            </div>
                        </div>
                        <div class="single-content">
                            <div class="content-details">
                                <div class="avatar">
                                    <img class="table-avater" src="/images/dashboard/av-02.svg" alt="avatar">
                                </div>
                                <div class="content">
                                    <p>Schrijf een samenvatting.</p>
                                    <span>Creëer een beknopt overzicht van een tekst of materiaal vo...</span>
                                </div>
                            </div>
                            <div class="content-date">
                                <p class="month">in Documenten</p>
                                <span class="month date">15 Okt, 2023</span>
                            </div>
                        </div>
                        <div class="single-content">
                            <div class="content-details">
                                <div class="avatar">
                                    <img class="table-avater" src="/images/dashboard/av-04.svg" alt="avatar">
                                </div>
                                <div class="content">
                                    <p>Schrijf een samenvatting.</p>
                                    <span>Creëer een beknopt overzicht van een tekst of materiaal vo...</span>
                                </div>
                            </div>
                            <div class="content-date">
                                <p class="month">in Documenten</p>
                                <span class="month date">15 Okt, 2023</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="table-wrapper fav-table">
                        <h2 class="table-title">Favoriete sjablonen</h2>
                        <div class="single-content">
                            <div class="content-details">
                                <div class="avatar">
                                    <img class="table-avater" src="/images/dashboard/av-2-1.svg" alt="avatar">
                                </div>
                                <div class="content">
                                    <p>Schrijf over een specifieke ervaring in je reflectieverslag</p>
                                    <span>Schrijf een bepaalde gebeurtenis uit en reflecteer hierop.</span>
                                </div>
                            </div>
                        </div>
                        <div class="single-content">
                            <div class="content-details">
                                <div class="avatar">
                                    <img class="table-avater" src="/images/dashboard/av-2-2.svg" alt="avatar">
                                </div>
                                <div class="content">
                                    <p>Schrijf over een specifieke ervaring in je reflectieverslag</p>
                                    <span>Schrijf een bepaalde gebeurtenis uit en reflecteer hierop.</span>
                                </div>
                            </div>
                        </div>
                        <div class="single-content">
                            <div class="content-details">
                                <div class="avatar">
                                    <img class="table-avater" src="/images/dashboard/av-2-3.svg" alt="avatar">
                                </div>
                                <div class="content">
                                    <p>Schrijf over een specifieke ervaring in je reflectieverslag</p>
                                    <span>Schrijf een bepaalde gebeurtenis uit en reflecteer hierop.</span>
                                </div>
                            </div>
                        </div>
                        <div class="single-content">
                            <div class="content-details">
                                <div class="avatar">
                                    <img class="table-avater" src="/images/dashboard/av-2-4.svg" alt="avatar">
                                </div>
                                <div class="content">
                                    <p>Schrijf over een specifieke ervaring in je reflectieverslag</p>
                                    <span>Schrijf een bepaalde gebeurtenis uit en reflecteer hierop.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
    <script>
        // JavaScript to hide the element when the cross icon is clicked
        const crossIcon = document.getElementById('cross');
        const closableElement = document.getElementById('closable');

        crossIcon.addEventListener('click', function() {
            closableElement.style.display = 'none';
        });
    </script>
@endsection
