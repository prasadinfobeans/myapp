<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Aspera\Spreadsheet\XLSX\Reader;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\SiteProducts;
use Session;

class UploadController extends Controller {

    /**
     * Show the profile for a given user.
     *
     * @param  Request  $request
     * @return \Illuminate\View\View
     */
    public function upload(Request $request) {
        Validator::make(['file' => $request->filename->getClientOriginalExtension()], ['file' => 'required|in:xlsx,xls'])->validate();
        $storeArr = [];
        $file = $request->file('filename');
        $name = date("Y-m-d_H-i-s") . '.' . isset($request->filename) ? $request->filename->getClientOriginalExtension() : '';
        $file->move(storage_path(), $name);
        $reader = new Reader();
        $reader->open(storage_path() . '/' . $name);
        $i = 0;
        foreach ($reader as $row) {
            Validator::make(['col_a' => 10, 'col_b' => 10], [
                'col_a' => 'required|integer',
                'col_b' => 'required|integer'
                    ],
                    [
                        'col_a.validate_int' => 'Please specify integer value in column A row ' . ($i + 1),
                        'col_b.validate_int' => 'Please specify integer value in column B row ' . ($i + 1)
                    ]
            )->validate();
            $storeArr[$i]['col_a'] = (int) $row[0];
            $storeArr[$i]['col_b'] = (int) $row[1];
            $storeArr[$i]['col_c'] = ((int) $row[0] + (int) $row[1]);
            $i++;
        }
        if (SiteProducts::insert($storeArr)) {
            Session::flash('message', 'Data Saved');
        } else {
            Session::flash('message', 'Failed to saved data');
        }
        $reader->close();
        return Redirect::to('/');
    }

}
