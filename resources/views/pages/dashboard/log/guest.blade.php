<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Aktivitas Pengguna') }}
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            // AJAX Datatable

            let datatable = $('#crudTable').DataTable({
                ajax: {
                    url: '{!! url()->current() !!}'
                },
                columns: [
                    { data: 'id', name: 'id', width: '5%' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'user.name', name: 'user.name' },
                    { data: 'description', name: 'description' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '20%'
                    }
                ]
            })
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
            </div>

            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">

                    <table class="min-w-max w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">No</th>
                                <th class="py-3 px-6 text-left"></th>
                                <th class="py-3 px-6 text-left">Nama</th>
                                <th class="py-3 px-6 text-left">Aktivitas</th>
                                <th class="py-3 px-6 text-left">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($query as $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    {{ $loop->iteration }}
                                <td/>

                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <span class="bg-purple-200 text-purple-600 py-1 px-3 rounded-full text-xs">{{ $item->user->name }}</span>
                                </td>

                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">{{ $item->description }}</span>
                                </td>

                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <span class="bg-purple-200 text-purple-600 py-1 px-3 rounded-full text-xs">{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                    Halaman : {{ $query->currentPage() }} <br/>
	Jumlah Data : {{ $query->total() }} <br/>
	Data Per Halaman : {{ $query->perPage() }} <br/>


	{{ $query->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
