<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $sources = Source::orderBy('created_at', 'desc')->paginate(5);

        return Inertia::render('Admin/Index', compact('sources'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        $request->merge(['token' => Hash::make(time())]);

        Source::create(
            $request->validate([
                'name' => 'required|string',
                'token' => 'required|unique:sources',
            ])
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request): Response
    {
        $source = Source::find($request->id);

        return Inertia::render('Admin/Edit', compact('source'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $source = Source::find($request->id);
        $data = $request->all();

        if ($data['gToken']) {
            $data['token'] = Hash::make(time());
        }
        unset($data['gToken']);

        $validator = Validator::make($data, [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return to_route('dashboard');
        }

        $source->update($data);

        return to_route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        Source::find($id)->delete();

        return to_route('dashboard');
    }
}
