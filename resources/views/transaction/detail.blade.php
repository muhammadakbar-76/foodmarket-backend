<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaction &raquo; {{ $transaction->food->name }} by {{ $transaction->user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="w-full rounded overflow-hidden shadow-lg px-6 py-6 bg-white">
        <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
            <div class="w-full md:w-1/6 px-4 mb-4 md:mb-0">
                <img src="https://picsum.photos/200" alt="" class="rounded"> 
                {{-- gak pake asset()? --}}
              </div>
                <div class="w-full md:w-5/6 px-4 mb-4 md:mb-0">
                    <div class="flex flex-wrap mb-3">
                        <div class="w-5/6">
                            <div class="text-sm">Product Name</div>
                            <div class="text-xl font-bold">{{ $transaction->food->name }}</div>
                        </div>
                        <div class="w-1/6 px-4">
                            <div class="text-sm">Quantity</div>
                            <div class="text-xl font-bold">{{ $transaction->quantity }}</div>
                        </div>
                        <div class="w-1/6 px-4">
                            <div class="text-sm">Total</div>
                            <div class="text-xl font-bold">{{ $transaction->total }}</div>
                        </div>
                        <div class="w-1/6 px-4">
                            <div class="text-sm">Status</div>
                            <div class="text-xl font-bold">{{ $transaction->status }}</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mb-3">
                        <div class="w-4/6">
                            <div class="text-sm">User Name</div>
                            <div class="text-xl font-bold">{{ $transaction->user->name }}</div>
                        </div>
                        <div class="w-3/6 px-4">
                            <div class="text-sm">Email</div>
                            <div class="text-xl font-bold">{{ $transaction->user->email }}</div>
                        </div>
                        <div class="w-1/6 px-4">
                            <div class="text-sm">City</div>
                            <div class="text-xl font-bold">{{ $transaction->user->city }}</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mb-3">
                        <div class="w-4/6">
                            <div class="text-sm">Address</div>
                            <div class="text-xl font-bold">{{ $transaction->user->address }}</div>
                        </div>
                        <div class="w-1/6 px-4">
                            <div class="text-sm">Number</div>
                            <div class="text-xl font-bold">{{ $transaction->user->houseNumber }}</div>
                        </div>
                        <div class="w-1/6 px-4">
                            <div class="text-sm">Phone</div>
                            <div class="text-xl font-bold">{{ $transaction->user->phoneNumber }}</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mb-3">
                        <div class="w-5/6">
                            <div class="text-sm">Payment Url</div>
                            <div class="text-lg">
                                <a href="{{ $transaction->payment_url }}">{{ $transaction->payment_url }}</a>
                            </div>
                        </div>
                        <div class="w-1/6 px-4">
                            <div class="text-sm mb-1">Change Status</div>
                            <a href="{{ route("transaction.changeStatus",["id" => $transaction->id, "status" => "ON_DELIVERY"]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded w-full block">On Delivery</a>
                            <a href="{{ route("transaction.changeStatus",["id" => $transaction->id, "status" => "DELIVERED"]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold px-4 rounded w-full block">Delivered</a>
                            <a href="{{ route("transaction.changeStatus",["id" => $transaction->id, "status" => "CANCELED"]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold px-4 rounded w-full block">Canceled</a>
                        </div>
                    </div>
                </div>
        </div>
        </div>
        </div>
    </div>
</x-app-layout>
