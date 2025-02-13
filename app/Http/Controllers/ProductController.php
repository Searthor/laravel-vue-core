<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::query();
        $products = $products->latest()->paginate(10);

        return response()->json([
            'products' => $products
        ], 200);
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'image' => 'nullable|string', // Ensure image is a string (base64)
        ]);

        $product = new Products();
        $product->name = $request->name;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->price = $request->price;

        // Check if there's an image and handle it
        if ($request->image) {
            $imageData = $request->image; // This is the base64 string
            $fileName = uniqid() . '.png'; // Generate a unique name for the image

            // Create the path where the image will be saved
            $path = public_path('upload/' . $fileName);

            // Remove the base64 header and decode the data
            $image = explode(',', $imageData)[1]; // Split off the metadata (data:image/png;base64,)

            // Save the decoded image to the path
            file_put_contents($path, base64_decode($image));

            // Store the filename in the product's image column
            $product->image = $fileName;
        }

        $product->save();

        return response()->json(['product' => $product], 201);
    }


    public function update(Request $request, $id)
    {


        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);


        try {
            $product =  Products::find($id);
            $product->name = $request->name;
            $product->description = $request->description;
            if (!empty($request->image) && $request->image !== 'undefined') {
                $imageData = $request->image;
                $fileName = uniqid() . '.png'; // Or derive the extension from the base64 string
                $path = public_path('upload/' . $fileName);

                // Ensure base64 format is valid
                if (strpos($imageData, ',') !== false) {
                    $image = explode(',', $imageData)[1]; // Remove base64 header
                    file_put_contents($path, base64_decode($image));
                    $product->image = $fileName;
                }
            }
            $product->type = $request->type;
            $product->quantity = $request->quantity;
            $product->price = $request->price;
            $product->update();
            return response()->json([
                'massage' => 'ok'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'massage' => $request
            ], 202);
        }
    }
}
