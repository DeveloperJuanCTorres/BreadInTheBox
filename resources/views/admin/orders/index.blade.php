<x-admin-layout>

    <div class="container py-12 mx-auto">

        <section class="grid lg:grid-cols-5 gap-6 text-white">
           
            <a href="{{ route('admin.orders.index') . "?status=2" }}" class="bg-blue-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl">
                    {{$recibido}}
                </p>
                <p class="uppercase text-center">Recibido</p>
                <p class="text-center text-2xl mt-2">
                    <i class="zmdi zmdi-check"></i>
                </p>
            </a>

            <a href="{{ route('admin.orders.index') . "?status=3" }}" class="bg-yellow-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl">
                    {{$enviado}}
                </p>
                <p class="uppercase text-center">Enviado</p>
                <p class="text-center text-2xl mt-2">
                    <i class="zmdi zmdi-dropbox"></i>
                </p>
            </a>

            <a href="{{ route('admin.orders.index') . "?status=4" }}" class="bg-pink-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl">
                    {{$transito}}
                </p>
                <p class="uppercase text-center">Transito</p>
                <p class="text-center text-2xl mt-2">
                    <i class="zmdi zmdi-truck"></i>
                </p>
            </a>

            <a href="{{ route('admin.orders.index') . "?status=5" }}" class="bg-green-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl">
                    {{$entregado}}
                </p>
                <p class="uppercase text-center">Entregado</p>
                <p class="text-center text-2xl mt-2">
                    <i class="zmdi zmdi-markunread-mailbox"></i>
                </p>
            </a>

            <a href="{{ route('admin.orders.index') . "?status=6" }}" class="bg-red-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl">
                    {{$anulado}}
                </p>
                <p class="uppercase text-center">Anulado</p>
                <p class="text-center text-2xl mt-2">
                    <i class="zmdi zmdi-close-circle-o"></i>
                </p>
            </a>
        </section>
        
        @livewire('list-orders',['status'=>$status])

    </div>

</x-admin-layout>