<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Food') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           <div style="margin-bottom: 30px">
               <a href="{{ route("food.create") }}" class="text-white font-bold py-2 px-4 rounded" style="background-color: rgba(5, 150, 105, 1); font-weight: bold">
                Create Food
                </a>
           </div>
           <div class="bg-white">
               <table class="table-auto w-full">
                   <thead>
                       <tr>
                           <th class="border px-6 py-4">ID</th>
                           <th class="border px-6 py-4">Name</th>
                           <th class="border px-6 py-4">Ingredients</th>
                           <th class="border px-6 py-4">Price</th>
                           <th class="border px-6 py-4">Rate</th>
                           <th class="border px-6 py-4">Types</th>
                           <th class="border px-6 py-4">Action</th>
                       </tr>
                   </thead>
                   <tbody>
                       @forelse ($food as $item)
                       <tr>
                        <td class="border px-6 py-4">{{ $item->id }}</td>
                        <td class="border px-6 py-4">{{ $item->name }}</td>
                        <td class="border px-6 py-4">{{ $item->ingredients }}</td>
                        <td class="border px-6 py-4">${{ $item->price }}</td>
                        <td class="border px-6 py-4">{{ $item->rate }}</td>
                        <td class="border px-6 py-4">{{ $item->types }}</td>
                        <td class="border px-6 py-4 text-center flex">
                            <a href="{{ route("food.edit", $item->id) }}" class="inline-block bg-blue-500 font-bold hover:bg-blue-700 text-white py-2 px-4 mx-2 rounded">Edit</a>
                            <form action="{{ route("food.destroy",$item->id) }}" method="post">
                                @method("delete")
                                @csrf
                            <button type="submit" class="inline-block bg-red-500 hover:bg-red-700 font-bold text-white py-2 px-4 mx-2 rounded" onclick="return confirm('Yakin ingin dihapus?')">Hapus</button>
                            </form>
                        </td>
                       </tr>
                       @empty
                          <tr>
                              <td colspan="7">Data empty</td>
                        </tr> 
                       @endforelse
                   </tbody>
               </table>
           </div>
           <div class="text-center mt-5">{{ $food->links() }}</div>
        </div>
    </div>
</x-app-layout>