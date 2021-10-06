<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestRequest;
use App\Models\ActivityLog;
use App\Models\Guest;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use Alert;
use Carbon\Carbon;
use PhpOffice\PhpWord\TemplateProcessor;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Guest::query();
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a href="' . route('dashboard.guest.edit', $item->id) . '"
                            class="bg-gray-800 hover:bg-black text-white font-bold py-1 px-2 m-1 rounded shadow-lg">
                            <i class="bx bxs-pencil"></i> Edit
                        </a>
                        <form class="inline-block" action="' . route('dashboard.guest.destroy', $item->id) . '" method="POST">
                            <button type="submit" onclick="ConfirmDelete()"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 m-1 rounded shadow-lg">
                                    <i class="bx bx-trash"></i> Hapus
                            </button>
                        ' . method_field('delete') . csrf_field() . '
                        </form>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.dashboard.guest.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.guest.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuestRequest $request)
    {
        $data = $request->all();

        Guest::create($data);
        activity()->log('Menambahkan data tamu');
        notify()->success('Buku tamu telah ditambah');
        return redirect()->route('dashboard.guest.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Guest $guest)
    {
        return view('pages.dashboard.guest.edit', compact('guest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GuestRequest $request, Guest $guest)
    {
        $data = $request->all();

        $guest->update($data);
        activity()->log('Mengubah data tamu');

        notify()->success('Data tamu telah di ubah');
        return redirect()->route('dashboard.guest.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guest $guest)
    {
        $guest->delete();
        activity()->log('menghapus sementara data tamu');

        notify()->success('Data tamu telah dihapus');

        return redirect()->route('dashboard.guest.index');
    }

    public function createPDF()
    {
        $data = Guest::all();
        $pdf = PDF::loadview('pages.dashboard.guest.print', compact('data'));
        return $pdf->stream("Report-buku-tamu.pdf");
    }

    public function createWord()
    {

        $data = Guest::all();
        return view('pages.dashboard.guest.print-word', compact('data'));
    }

    public function trash()
    {
        if (request()->ajax()) {
            $query = Guest::onlyTrashed();
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a href="' . route('dashboard.restore', $item->id) . '"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 m-1 rounded shadow-lg">
                            <i class="bx bx-window-open"></i> Restore
                        </a>

                        <a href="' . route('dashboard.force', $item->id) . '"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 m-1 rounded shadow-lg">
                            <i class="bx bxs-trash"></i> Delete
                        </a>

                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.dashboard.trash.guest');
    }

    public function restore($id)
    {
        $guest = Guest::onlyTrashed()->find($id);
        $guest->restore();
        activity()->log('mengembalikan data tamu');

        notify()->success('Data tamu telah dikembalikan');

        return redirect()->route('dashboard.guest.index');
    }

    public function restoreAll()
    {
        $guest = Guest::onlyTrashed();
        $guest->restore();
        activity()->log('mengembalikan semua data tamu');

        notify()->success('Semua data tamu telah dikembalikan');

        return redirect()->route('dashboard.guest.index');
    }

    public function force($id)
    {
        $guest = Guest::onlyTrashed()->find($id);
        $guest->forceDelete();
        activity()->log('menghapus permanen data tamu');

        notify()->success('Data tamu telah dihapus permanen');

        return redirect()->route('dashboard.trash-guest');
    }

    public function forceAll()
    {
        $guest = Guest::onlyTrashed();
        $guest->forceDelete();
        activity()->log('menghapus permanen semua data tamu');

        notify()->success('Semua data tamu telah dihapus permanen');

        return redirect()->route('dashboard.trash-guest');
    }

    public function log(User $user)
    {
        $query = ActivityLog::with('user')->orderBy('id', 'DESC')->paginate(10);
        return view('pages.dashboard.log.guest', compact('user', 'query'));
    }
}
