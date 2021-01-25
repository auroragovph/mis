@extends('errors.master', [
  'code' => 403,
  'title' => 'Forbidden',
  'message' => 'The server understood the request but <br> you are not allowed to access the resource.',
  'image' => '/media/error/bg6.jpg'
])