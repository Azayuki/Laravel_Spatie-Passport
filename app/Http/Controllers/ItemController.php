<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
       $items = Item::orderBy('id', 'DESC')->get();
       return $this->Ok($items, "Items retrieved!");
    }

    public function show($id)
    {
       $item = Item::find($id);
       if(!$item){
           return $this->NoDataFound();
       }
       return $this->Ok($item, "Item retrieved!");
    }

    public function store(AddItemRequest $request){
        $item = Item::create($request->validated());
        return $this->Created($item, "Item created!");
    }

    public function update(UpdateItemRequest $request, $id)
    {
       $item = Item::find($id);
       if(!$item){
           return $this->NoDataFound();
       }

        $item->update($request->validated());
        return $this->Ok($item, "Item updated successfully");
    }

    public function destroy($id)
    {
       $item = Item::find($id);
       if(!$item){
           return $this->NoDataFound();
       }

       $item->delete();
       return $this->Ok(null, "Item deleted successfully");
    }
}
