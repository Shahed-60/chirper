<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;


class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view(
            'chirps.index',
            //  haalt alle chirps uit de database, samen met de gerelateerde user voor elke chirp,
            //  sorteert ze op de created_at timestamp, en stuurt ze naar de chirps.
            // index view om gerenderd te worden.
            ['chirps' => Chirp::with('user')->latest()->get()]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // de validate methode zorgt ervoor dat de data die je binnenkrijgt
        //  voldoet aan de regels die je hebt opgesteld en dat is in dit geval
        //  dat het een string is en maximaal 255 tekens lang.
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
        // $request->user() haalt de ingelogde gebruiker op en met de chirps() methode
        // met de create methode maak je een nieuwe chirp aan.
        // Dus, in totaal, $request->user()->chirps()->create($validated);
        // maakt een nieuwe "chirp" aan die is gekoppeld aan de momenteel geauthenticeerde
        // gebruiker, met de gevalideerde request data, en slaat het op in de database.
        $request->user()->chirps()->create($validated);
        // na het opslaan van de informatie wordt de gebruiker teruggeleid naar de index pagina.
        return redirect(route('chirps.index'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        // de authorize methode controleert of de huidige gebruiker geautoriseerd is om de chirp te bewerken.
        // Als de gebruiker niet geautoriseerd is, wordt er een 403 response geretourneerd.
        Gate::authorize('edit-chirp', $chirp);
        // de view methode retourneert de chirp.edit view, samen met de chirp die moet worden bewerkt.
        return view(
            'chirps.edit',
            ['chirp' => $chirp]
        );
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update', $chirp);
        $validated  = $request->validate([
            'message' => 'required|string|max:255',
        ]);
        $chirp->update($validated);
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        // de authorize methode controleert of de huidige gebruiker geautoriseerd is om de chirp te verwijderen.
        Gate::authorize('delete', $chirp);
        $chirp->delete();
        return redirect(route('chirps.index'));
    }
}
