<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ManageProviderController extends Controller
{
    public function index()
    {
        $providers = Provider::all();
        return view('providers.index', compact('providers'));
    }

    public function edit($id)
    {
        $provider = Provider::findOrFail($id);
        return view('providers.edit', compact('provider'));
    }

    public function update(Request $request, $id)
    {
        $provider = Provider::findOrFail($id);
        $provider->update($request->all());
        return redirect()->route('manage_providers.index')->with('success', 'Provider updated successfully');
    }

    public function destroy($id)
    {
        $provider = Provider::findOrFail($id);
        $provider->delete();
        return redirect()->route('manage_providers.index')->with('success', 'Provider deleted successfully');
    }
}
