@extends('errors.master', [
  'code' => 505,
  'title' => 'Oooops',
  'message' => ($exception->getMessage() == '') ? 'Something went wrong. ' :  $exception->getMessage(),
  'image' => '/media/error/bg6.jpg'
])