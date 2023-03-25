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
    dd($request->arrayData);
  }
}
