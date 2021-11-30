<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has("success"))
            <div class="mb-5" role="alert">
                <div class="bg-green-500 text-white font-bold rounded-t px-4 py-2">
                    Success!
                </div>
                <div class="border border-t-0 border-green-400 rounded-b bg-green-100 px-4 py-3 text-green-700">
                    <p>
                        <ul>
                          <li>{{ session("success") }}</li>
                        </ul>
                    </p>
                </div>
            </div>
        @endif
           <div style="margin-bottom: 30px">
               <a href="{{ route("users.create") }}" class="text-white font-bold py-2 px-4 rounded" style="background-color: rgba(5, 150, 105, 1); font-weight: bold">
                Create User
                </a>
           </div>
           <div class="bg-white">
               <table class="table-auto w-full">
                   <thead>
                       <tr>
                           <th class="border px-6 py-4">ID</th>
                           <th class="border px-6 py-4">Name</th>
                           <th class="border px-6 py-4">Email</th>
                           <th class="border px-6 py-4">Roles</th>
                           <th class="border px-6 py-4">Action</th>
                       </tr>
                   </thead>
                   <tbody>
                       @forelse ($user as $item)
                       <tr>
                        <td class="border px-6 py-4">{{ $item->id }}</td>
                        <td class="border px-6 py-4">{{ $item->name }}</td>
                        <td class="border px-6 py-4">{{ $item->email }}</td>
                        <td class="border px-6 py-4">{{ $item->roles }}</td>
                        <td class="border px-6 py-4 text-center flex">
                            <a href="{{ route("users.edit", $item->id) }}" class="inline-block bg-blue-500 font-bold hover:bg-blue-700 text-white py-2 px-4 mx-2 rounded">Edit</a>
                            <form action="{{ route("users.destroy", $item->id) }}" method="post">
                                @method("delete")
                                @csrf
                            <button type="submit" class="inline-block bg-red-500 hover:bg-red-700 font-bold text-white py-2 px-4 mx-2 rounded" onclick="return confirm('Yakin ingin dihapus?')">Hapus</button>
                            </form>
                        </td>
                       </tr>
                       @empty
                          <tr>
                              <td colspan="5">Data empty</td>
                        </tr> 
                       @endforelse
                   </tbody>
               </table>
           </div>
           <div class="text-center mt-5">{{ $user->links() }}</div>
        </div>
    </div>
</x-app-layout>
