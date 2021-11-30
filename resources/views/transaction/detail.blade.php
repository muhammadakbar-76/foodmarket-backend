<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaction &raquo; {{ $transaction->food->name }} by {{ $transaction->user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="w-full md:w-1/6 px-4 mb-4 md:mb-0">
            <img src="{{ $transaction->food->picturePath }}" alt="" class="w-full rounded"> 
            {{-- gak pake asset()? --}}
          </div>
            <div class="w-full md:w-5/6 px-4 mb-4 md:mb-0">
                <div class="flex flex-wrap mb-3">
                    <div class="w-2/6">
                        <div class="text-sm">Product Name</div>
                        <div class="text-xl font-bold">{{ $transaction->food->name }}</div>
                    </div>
                    <div class="w-1/6">
                        <div class="text-sm">Quantity</div>
                        <div class="text-xl font-bold">{{ $transaction->quantity }}</div>
                    </div>
                    <div class="w-1/6">
                        <div class="text-sm">Total</div>
                        <div class="text-xl font-bold">{{ $transaction->total }}</div>
                    </div>
                    <div class="w-1/6">
                        <div class="text-sm">Status</div>
                        <div class="text-xl font-bold">{{ $transaction->status }}</div>
                    </div>
                </div>
                <div class="flex flex-wrap mb-3">
                    <div class="w-2/6">
                        <div class="text-sm">User Name</div>
                        <div class="text-xl font-bold">{{ $transaction->user->name }}</div>
                    </div>
                    <div class="w-3/6">
                        <div class="text-sm">Email</div>
                        <div class="text-xl font-bold">{{ $transaction->user->email }}</div>
                    </div>
                    <div class="w-1/6">
                        <div class="text-sm">City</div>
                        <div class="text-xl font-bold">{{ $transaction->user->city }}</div>
                    </div>
                </div>
                <div class="flex flex-wrap mb-3">
                    <div class="w-4/6">
                        <div class="text-sm">Address</div>
                        <div class="text-xl font-bold">{{ $transaction->user->address }}</div>
                    </div>
                    <div class="w-1/6">
                        <div class="text-sm">Number</div>
                        <div class="text-xl font-bold">{{ $transaction->user->houseNumber }}</div>
                    </div>
                    <div class="w-1/6">
                        <div class="text-sm">Phone</div>
                        <div class="text-xl font-bold">{{ $transaction->user->phoneNumber }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
