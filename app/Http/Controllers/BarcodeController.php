<?php

namespace App\Http\Controllers;

use App\Barcode;
use Illuminate\Http\Request;
use Datatables;

class BarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('barcode_settings.access')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $barcodes = Barcode::where('business_id', $business_id)
                        ->select(['name', 'description', 'id', 'is_default']);

            return Datatables::of($barcodes)
                ->addColumn(
                    'action',
                    '<a href="{{action(\'BarcodeController@edit\', [$id])}}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</a>
                        &nbsp;
                        <button type="button" data-href="{{action(\'BarcodeController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_barcode_button" @if($is_default) disabled @endif><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>&nbsp;
                        @if($is_default)
                            <button type="button" class="btn btn-xs btn-success" disabled><i class="fa fa-check-square-o" aria-hidden="true"></i> @lang("barcode.default")</button>
                        @else
                            <button class="btn btn-xs btn-info set_default" data-href="{{action(\'BarcodeController@setDefault\', [$id])}}">@lang("barcode.set_as_default")</button>
                        @endif
                        '
                )
                ->editColumn('name', function ($row) {
                    if ($row->is_default == 1) {
                        return $row->name . ' &nbsp; <span class="label label-success">' . __("barcode.default") .'</span>' ;
                    } else {
                        return $row->name ;
                    }
                })
                ->removeColumn('id')
                ->removeColumn('is_default')
                ->rawColumns([2])
                ->make(false);
        }

        return view('barcode.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('barcode_settings.access')) {
            abort(403, 'Unauthorized action.');
        }

        return view('barcode.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('barcode_settings.access')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['name', 'description', 'width', 'height', 'top_margin',
                                    'left_margin', 'row_distance', 'col_distance',
                                    'stickers_in_one_row', 'paper_width']);
            $business_id = $request->session()->get('user.business_id');
            $input['business_id'] = $business_id;

            if (!empty($request->input('is_default'))) {
                //get_default
                $default = Barcode::where('business_id', $business_id)
                                ->where('is_default', 1)
                                ->update(['is_default' => 0 ]);
                $input['is_default'] = 1;
            }
            if (!empty($request->input('is_continuous'))) {
                $input['is_continuous'] = 1;
                $input['stickers_in_one_sheet'] = 28;
            } else {
                $input['stickers_in_one_sheet'] = $request->input('stickers_in_one_sheet');
                $input['paper_height'] = $request->input('paper_height');
            }

            $barcode = Barcode::create($input);
            $output = ['success' => 1,
                            'msg' => __('barcode.added_success')
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => __("messages.something_went_wrong")
                        ];
        }

        return redirect('barcodes')->with('status', $output);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function show(Barcode $barcode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('barcode_settings.access')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $barcode = Barcode::where('business_id', $business_id)->find($id);

        return view('barcode.edit')
            ->with(compact('barcode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('barcode_settings.access')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['name', 'description', 'width', 'height', 'top_margin',
                                  'left_margin', 'row_distance', 'col_distance',
                                  'stickers_in_one_row', 'paper_width']);

            if (!empty($request->input('is_continuous'))) {
                $input['is_continuous'] = 1;
                $input['stickers_in_one_sheet'] = 28;
                $input['paper_height'] = 0;
            } else {
                $input['is_continuous'] = 0;
                $input['stickers_in_one_sheet'] = $request->input('stickers_in_one_sheet');
                $input['paper_height'] = $request->input('paper_height');
            }

            $barcode = Barcode::where('id', $id)->update($input);
            
            $output = ['success' => 1,
                          'msg' => __('barcode.updated_success')
                      ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                           'msg' => __("messages.something_went_wrong")
                       ];
        }

        return redirect('barcodes')->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('barcode_settings.access')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $barcode = Barcode::find($id);
                if ($barcode->is_default != 1) {
                    $barcode->delete();
                    $output = ['success' => true,
                                'msg' => __("barcode.deleted_success")
                                ];
                } else {
                    $output = ['success' => false,
                                'msg' => __("messages.something_went_wrong")
                                ];
                }
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }

            return $output;
        }
    }

    /**
     * Sets barcode setting as default
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function setDefault($id)
    {
        if (!auth()->user()->can('barcode_settings.access')) {
            abort(403, 'Unauthorized action.');
        }
        
        if (request()->ajax()) {
            try {
                //get_default
                $business_id = request()->session()->get('user.business_id');
                $default = Barcode::where('business_id', $business_id)
                                ->where('is_default', 1)
                                 ->update(['is_default' => 0 ]);
                                 
                $barcode = Barcode::find($id);
                $barcode->is_default = 1;
                $barcode->save();

                $output = ['success' => true,
                            'msg' => __("barcode.default_set_success")
                        ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }
            return $output;
        }
    }
}
