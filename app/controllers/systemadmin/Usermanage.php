<?php

class Usermanage extends Controller
{
  public function index()
  {
    $URL['view'] = 'usermanage';

    $user = new User;
    $rows = $user->findAll();
    $URL['users'] = is_array($rows) && count($rows) > 0 ? $rows : [];

    // $logData = [
    //     'rows' => $rows,
    //     'timestamp' => date('Y-m-d H:i:s')
    // ];
    
    // file_put_contents(
    //     __DIR__ . '/test_log.txt',             // Adjust path if needed
    //     print_r($logData, true) . "\n",         // Human-readable format
    //     FILE_APPEND                             // Don’t overwrite old logs
    // );

    $this->view('systemadmin', $URL);
  }
}