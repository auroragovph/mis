@extends('errors.master', [
  'code' => 503,
  'title' => 'Service Unavailable',
  'message' => 'The server in temporarily unable to service your <br> request due to maintenance downtime or capacity problems.  Please try again later.',
  'image' => '/media/error/bg6.jpg'
])