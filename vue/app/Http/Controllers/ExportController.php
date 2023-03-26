<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportRequest;

class ExportController extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(ExportRequest $request)
  {
    $fileName = $request->fileName;
    $arrayData = $request->arrayData;
    /*
    $headers = array(
      "Content-type"        => "text/csv",
      "Content-Disposition" => "attachment; filename=$fileName",
      "Pragma"              => "no-cache",
      "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
      "Expires"             => "0"
    );
    */
    $columns = array('name', 'description');
    //dd($fileName,$arrayData,$headers,$columns,public_path('temp/'.$fileName));
    //$callback = function () use ($arrayData, $fileName, $columns) {
    $file = fopen(public_path('temp/' . $fileName), 'w');
    fputcsv($file, $columns);

    foreach ($arrayData as $data) {
      fputcsv($file, array($data['name'], $data['description']));
    }

    fclose($file);
    //};
    //return response()->stream($callback, 200, $headers);
  }
}
