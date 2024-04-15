<div>
<div class="fixed-banner "></div> 
    
    <div class="banner-category container-fluid" data-banner="fixed">
        <img src="{{asset('images/bg-bread-special.webp')}}" alt="" class="banner-category__img">
        <div class="banner-category__box-title">
            <h1 class="banner-category__title"> My suscriptions </h1>
        </div>
    </div>

    <div class="container py-12">
        @if (Auth::user()->idPaymentMethod)
            @if ($suscriptions->count())
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-3" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div>
                        <p class="font-bold">Remember</p>
                        <p class="text-sm">
                            The “SUSPEND” button allows you to pause a subscription, but it must be done 
                            at least 24hrs before your scheduled payment. Payments are initiated one day 
                            before the delivery date. The “Edit” button allows you to modify your 
                            delivery date/frequency. If you want to edit the products in your subscription, 
                            you must create a new order. The “Cancel” button will cancel a subscription indefinitely, 
                            just like the suspend orders must be canceled at least one day prior to the scheduled payment. 
                            Please refer to our FAQ section if you have any more questions.</p>
                        </div>
                    </div>
                </div>
                <x-table-responsive>
                    <section class="bg-white shadow-lg rounded-lg px-12 py-8  text-gray-700">
                        <ul>
                            @foreach ($suscriptions as $suscription)
                                <li>
                                    <span class="flex items-center py-2 px-4 suscription-link">
                                        
                                        <span class="w-12 text-center">
                                            <i class="las la-bell text-blue-500 text-lg"></i>
                                        </span>

                                        <span>
                                            <strong>Total amount:</strong> $ {{ number_format($suscription->final_total,2)}}
                                            <br>
                                            <strong>Subscription:</strong> {{$suscription->recur_interval}} day interval
                                            <br>
                                            @if($suscription->is_suspend)
                                            <strong class="text-red-600">This subscription is suspended</strong> 
                                            @else
                                            <strong>Next order:</strong> {{$suscription->nextInvoices()}}
                                            @endif
                                        </span>

                                        <span class="ml-auto">
                                            @if($suscription->recur_stopped_on)
                                                <button class="btn btn-success" wire:click="activate({{$suscription->id}})"> <i class="las la-power-off mr-1"></i> Activate</button>
                                            @else
                                                <button class="btn" wire:click="suspende({{$suscription->id}})"> <i class="las la-minus-circle mr-1"></i> Suspend</button>
                                            @endif
                                        </span>

                                        <span class="ml-2">
                                            <button class="btn btn-danger"  wire:click="$emit('deleteSuscription', {{$suscription->id}})"><i class="las la-times mr-1"></i> Cancel</button>
                                        </span>

                                        <span class="ml-2">
                                            <a href="{{route('suscription.edit',$suscription)}}" target="blank" class="btn btn-edit"><i class="las la-pen mr-1"></i> Edit</a>
                                        </span>

                                        <span class="ml-2">
                                            <a href="{{route('suscription.show',$suscription)}}" target="blank" class="btn btn-see"><i class="las la-eye mr-1"></i> See detail </a>
                                        </span>

                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                </x-table-responsive>
            @else
            <div class="bg-white shadow-lg rounded-lg px-12 py-8 mt-12 text-gray-700">
                <span class="font-bold text-lg">
                    You don't  have any registered subscription
                </span>
            </div>
            @endif
        @else
            <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
                <p class="text-xl font-bold">Remember</p>
                <p class="text-lg">To register a subscription you first have to register a payment method <a class="font-bold" href="/user/profile">“in this link”</a> or you can go to the payment methods section in your profile</p>
            </div>
        @endif


    </div>

    @push('script')
        <script>
            Livewire.on('deleteSuscription', id => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('suscription', 'delete', id)
                    }
                })
            });
        </script>
    @endpush

    @push('seo')
		<title>Bread in the box | My suscriptions</title>
	@endpush
</div>
