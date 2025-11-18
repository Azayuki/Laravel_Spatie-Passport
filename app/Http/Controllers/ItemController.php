<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
       $items = Item::all();
       return $this->Success($items);
    }

    public function show($id)
    {
       $item = Item::find($id); 
       if(!$item){
           return $this->NotFound("Item not found");
       }
       return $this->Success($item);
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            "code" => "required|alpha_dash|unique:items|max:32",
            "name" => "required|string|max:128",
            "price" => "required|numeric|min:0",
            "item_type" => "required|string|max:64",
            "supplier" => "required|string|max:128",
            "currency" => "required|string|size:3",
            "image_url" => "sometimes|url|max:256",
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }
        
        $item = Item::create($validator->validated());
        return $this->Created($item);
    }

    public function update(Request $request, $id)
    {
       $item = Item::find($id); 
       if(!$item){
           return $this->NotFound("Item not found");
       }

       $validator = validator()->make($request->all(), [
            "code" => "sometimes|required|alpha_dash|unique:items,code,$id|max:32",
            "name" => "sometimes|required|string|max:128",
            "price" => "sometimes|required|numeric|min:0",
            "item_type" => "sometimes|required|string|max:64",
            "supplier" => "sometimes|required|string|max:128",
            "currency" => "sometimes|required|string|size:3",
            "image_url" => "sometimes|url|max:256",
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }

        $item->update($validator->validated());
        return $this->Success($item, "Item updated successfully");
    }

    public function destroy($id)
    {
       $item = Item::find($id); 
       if(!$item){
           return $this->NotFound("Item not found");
       }

       $item->delete();
       return $this->Success([], "Item deleted successfully");
    }
}
