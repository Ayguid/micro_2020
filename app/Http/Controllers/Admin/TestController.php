<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models440\File;

use App\Http\Controllers\Controller;


class TestController extends Controller
{
  //

  public function indexFiles()
  {
    // $files = File::where('file_path', 'regexp','[Ø-ø]')->get();
    // $files = File::where('file_path', 'regexp','Ñ')->get();
    $files = File::where('file_path', 'regexp','^.*\.(dxf)$')->where('file_path', 'regexp',' ')->get();

    // foreach ($files as $file) {
    //   $str = $file->file_path;
    //   $pattern = '/ñ/i';
    //   $file->file_path = preg_replace($pattern, 'n', $str);
    //   $file->update();
    // }
    // foreach ($files as $file) {
    //   $str = $file->file_path;
    //   $pattern = '/ /i';
    //   $file->file_path = preg_replace($pattern, '', $str);
    //   $file->update();
    // }

    // $pattern = '/ /i';
    return $files;
  }





}
