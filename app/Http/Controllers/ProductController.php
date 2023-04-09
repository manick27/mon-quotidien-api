<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = product::with('category')->get();
        foreach ($products as $product) {
            $product->withUrl();
        }
        return response()->json($products);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'nullable|integer',
            'price' => 'required|integer',
            'state' => 'required|string|max:255',
            'state_description' => 'required|string',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => 'required|integer|exists:users,id',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        $product = new Product($request->all());
        // $product = new Product($request->validated());

        $images = ['main_image', 'image1', 'image2', 'image3', 'image4'];

        // Parcourir le tableau et uploader chaque image si elle existe
        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                // Générer un nom unique pour l'image
                $imageName = time() . '_' . $request->$image->getClientOriginalName();

                // Déplacer l'image dans le dossier public/images
                $request->$image->move(public_path('images'), $imageName);

                // Enregistrer le chemin de l'image dans l'attribut correspondant du produit
                $product->$image = $imageName;
            }
        }

        // Enregistrer le produit dans la base de données
        $product->save();

        // Retourner une réponse JSON avec le produit
        return response()->json(['product' => $product, ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
