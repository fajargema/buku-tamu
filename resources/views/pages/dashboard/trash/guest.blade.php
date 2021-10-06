<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Guest') }}
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
                    { data: 'DT_RowIndex', width: '5%' },
                    { data: 'date', name: 'date' },
                    { data: 'name', name: 'name' },
                    { data: 'address', name: 'address' },
                    { data: 'necessity', name: 'necessity' },
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
            <div class="mb-10 grid grid-cols-3 gap-4">
                <a href="{{ route('dashboard.restore-all') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white
                    font-bold py-2 px-4 rounded shadow-lg">
                    <i class='bx bx-plus-medical'></i> Kembalikan Semua
                </a>

                <a href="{{ route('dashboard.force-all') }}" target="_blank"
                    class="bg-red-500 hover:bg-red-700 text-white
                    font-bold py-2 px-4 rounded shadow-lg">
                    <i class='bx bxs-file-pdf'></i> Hapus Semua
                </a>
            </div>

            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Keperluan</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
