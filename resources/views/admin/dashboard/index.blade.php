@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title"><h5 class="mb-0 font-medium">Default</h5></div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Default</li>
                    </ul>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-x-6">
                @foreach ([
                    ['Daily Sales', '$ 249.95', '67%', '75%', 'arrow-up', 'text-success-500', 'bg-theme-bg-1'],
                    ['Monthly Sales', '$ 2.942.32', '36%', '35%', 'arrow-down', 'text-danger-500', 'bg-theme-bg-2'],
                    ['Yearly Sales', '$8.638.32', '80%', '80%', 'arrow-up', 'text-success-500', 'bg-theme-bg-1'],
                ] as [$label, $amount, $percentage, $progress, $icon, $trendClass, $progressClass])
                    <div class="col-span-12 xl:col-span-4 md:col-span-6">
                        <div class="card">
                            <div class="card-header !pb-0 !border-b-0"><h5>{{ $label }}</h5></div>
                            <div class="card-body">
                                <div class="flex items-center justify-between gap-3 flex-wrap">
                                    <h3 class="font-light flex items-center mb-0"><i class="feather icon-{{ $icon }} {{ $trendClass }} text-[30px] mr-1.5"></i>{{ $amount }}</h3>
                                    <p class="mb-0">{{ $percentage }}</p>
                                </div>
                                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mt-6 dark:bg-themedark-bodybg"><div class="{{ $progressClass }} h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]" role="progressbar" style="width: {{ $progress }}"></div></div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach ([
                    ['facebook-f', '12,281', '+7.2%', 'text-success-500', '35,098', '60%', '350', '45%', 'bg-theme-bg-1', 'bg-theme-bg-2'],
                    ['twitter', '11,200', '+6.2%', 'text-purple-500', '34,185', '40%', '800', '70%', 'bg-success-500', 'bg-primary-500'],
                    ['google-plus-g', '10,500', '+5.9%', 'text-purple-500', '25,998', '80%', '900', '50%', 'bg-theme-bg-1', 'bg-theme-bg-2'],
                ] as [$network, $total, $change, $changeClass, $target, $targetWidth, $duration, $durationWidth, $targetClass, $durationClass])
                    <div class="col-span-12 xl:col-span-4 md:col-span-6">
                        <div class="card card-social">
                            <div class="card-body border-b border-theme-border dark:border-themedark-border">
                                <div class="flex items-center justify-center">
                                    <div class="shrink-0"><i class="fab fa-{{ $network }} text-primary-500 text-[36px]"></i></div>
                                    <div class="grow ltr:text-right rtl:text-left"><h3 class="mb-2">{{ $total }}</h3><h5 class="{{ $changeClass }} mb-0">{{ $change }} <span class="text-muted">Total Likes</span></h5></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="grid grid-cols-12 gap-x-6">
                                    <div class="col-span-6"><h6 class="text-center mb-2.5"><span class="text-muted m-r-5">Target:</span>{{ $target }}</h6><div class="w-full bg-theme-bodybg rounded-lg h-1.5 dark:bg-themedark-bodybg"><div class="{{ $targetClass }} h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]" role="progressbar" style="width: {{ $targetWidth }}"></div></div></div>
                                    <div class="col-span-6"><h6 class="text-center mb-2.5"><span class="text-muted m-r-5">Duration:</span>{{ $duration }}</h6><div class="w-full bg-theme-bodybg rounded-lg h-1.5 dark:bg-themedark-bodybg"><div class="{{ $durationClass }} h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]" role="progressbar" style="width: {{ $durationWidth }}"></div></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-span-12 xl:col-span-4 md:col-span-6">
                    <div class="card user-list">
                        <div class="card-header"><h5>Rating</h5></div>
                        <div class="card-body">
                            <div class="flex items-center justify-between gap-1 mb-5">
                                <h2 class="font-light flex items-center m-0">4.7 <i class="fas fa-star text-[10px] ml-2.5 text-warning-500"></i></h2>
                                <h6 class="flex items-center m-0">0.4 <i class="fas fa-caret-up text-success text-[22px] ml-2.5"></i></h6>
                            </div>
                            @foreach ([[5, 384, '70%'], [4, 145, '35%'], [3, 24, '25%'], [2, 1, '10%'], [1, 0, '0%']] as [$stars, $reviews, $width])
                                <div class="flex items-center justify-between gap-2 mb-2"><h6 class="flex items-center gap-1"><i class="fas fa-star text-[10px] mr-2.5 text-warning-500"></i>{{ $stars }}</h6><h6>{{ $reviews }}</h6></div>
                                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mb-6 mt-3 dark:bg-themedark-bodybg"><div class="bg-theme-bg-1 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]" role="progressbar" style="width: {{ $width }}"></div></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-8 md:col-span-6">
                    <div class="card table-card">
                        <div class="card-header"><h5>Recent Users</h5></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                        @foreach ([
                                            ['avatar-1.jpg', 'Isabella Christensen', 'Lorem Ipsum is simply dummy text of…', 'text-success', '11 MAY 12:56'],
                                            ['avatar-2.jpg', 'Mathilde Andersen', 'Lorem Ipsum is simply dummy text of…', 'text-danger', '11 MAY 10:35'],
                                            ['avatar-3.jpg', 'Karla Sorensen', 'Lorem Ipsum is simply dummy text of…', 'text-success', '9 MAY 17:38'],
                                            ['avatar-1.jpg', 'Ida Jorgensen', 'Lorem Ipsum is simply dummy text of…', 'text-danger', '19 MAY 12:56'],
                                            ['avatar-2.jpg', 'Albert Andersen', 'Lorem Ipsum is simply dummy text of…', 'text-success', '21 July 12:56'],
                                        ] as [$avatar, $name, $description, $status, $time])
                                            <tr class="unread">
                                                <td><img class="rounded-full max-w-10" style="width: 40px" src="{{ asset('vendor/dattaable/assets/images/user/'.$avatar) }}" alt="{{ $name }}"></td>
                                                <td><h6 class="mb-1">{{ $name }}</h6><p class="m-0">{{ $description }}</p></td>
                                                <td><h6 class="text-muted"><i class="fas fa-circle {{ $status }} text-[10px] ltr:mr-4 rtl:ml-4"></i>{{ $time }}</h6></td>
                                                <td><a href="#!" class="badge bg-theme-bg-2 text-white text-[12px] mx-2">Reject</a><a href="#!" class="badge bg-theme-bg-1 text-white text-[12px]">Approve</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
