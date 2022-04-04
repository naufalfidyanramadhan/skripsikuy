<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataBarang;
use Gate;
use App\Http\Requests\MassDestroyDataBarangRequest;
use App\Http\Requests\StoreDataBarangRequest;
use App\Http\Requests\UpdateDataBarangRequest;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DataBarangController extends Controller
{

    public function index(Request $request)
    {
        abort_if(Gate::denies('data_barang_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DataBarang::query()->select(sprintf('%s.*', (new DataBarang())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'data_barang_show';
                $editGate = 'data_barang_edit';
                $deleteGate = 'data_barang_delete';
                $crudRoutePart = 'data-barang';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('nama', function ($row) {
                return $row->nama ? $row->nama : '';
            });
            $table->editColumn('kategori', function ($row) {
                return $row->kategori ? $row->kategori : '';
            });
            $table->editColumn('varian', function ($row) {
                return $row->varian ? $row->varian : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.masterData.dataBarang');
    }


    public function show(DataBarang $data_barang)
    {
        abort_if(Gate::denies('data_barang_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.masterData.dataBarangShow', compact('data_barang'));
    }

    public function create()
    {
        abort_if(Gate::denies('data_barang_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.masterData.dataBarangCreate');
    }

    public function edit(DataBarang $data_barang)
    {
        abort_if(Gate::denies('data_barang_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.masterData.dataBarangEdit', compact('data_barang'));
    }

    public function update(UpdateDataBarangRequest $request, DataBarang $data_barang)
    {
        $data_barang->update($request->all());

        return redirect()->route('admin.data-barang.index');
    }

    public function store(StoreDataBarangRequest $request)
    {
        $data_barang = DataBarang::create($request->all());

        return redirect()->route('admin.data-barang.index');
    }


    public function destroy(DataBarang $data_barang)
    {
        abort_if(Gate::denies('data_barang_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data_barang->delete();

        return back();
    }

    public function massDestroy(MassDestroyDataBarangRequest $request){
        
        DataBarang::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
    
}