<?php

// Test globally, inside every file
test('globals')
->expect(['dd', 'dump'])
->not 
->toBeUsed();

test('models')
->expect('App\Models')
->not
->toOnlyBeUsedIn('App\Http\Controllers');