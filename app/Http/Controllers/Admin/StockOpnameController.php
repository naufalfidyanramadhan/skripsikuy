<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;
use App\Http\Requests\MassDestroyStockOpnameRequest;
use App\Http\Requests\StoreStockOpnameRequest;
use App\Http\Requests\UpdateStockOpnameRequest;
use App\Models\StockOpname;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StockOpnameController extends Controller
{
    public function index(Request $request){
        abort_if(Gate::denies('stock_opname_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = StockOpname::query()->select(sprintf('%s.*', (new StockOpname())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'stock_opname_show';
                $editGate = 'stock_opname_edit';
                $deleteGate = 'stock_opname_delete';
                $crudRoutePart = 'stock-opname';

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

        return view('admin.stockOpname.index');
    }

    public function show(StockOpname $stock_opname)
    {
        abort_if(Gate::denies('stock_opname_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.stockOpname.show', compact('stock_opname'));
    }

    public function destroy(StockOpname $stock_opname)
    {
        abort_if(Gate::denies('stock_opname_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stock_opname->delete();

        return back();
    }

    public function massDestroy(MassDestroyStockOpnameRequest $request){
        
        StockOpname::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
