@extends('layouts.horizontal', [
    '__module_title__' => 'System Modules',
    '__navigation__' => authenticated()->can('sys.sudo') ? 'system::layouts.navigation' : null
])
