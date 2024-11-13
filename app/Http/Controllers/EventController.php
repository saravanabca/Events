<?php

namespace App\Http\Controllers;

use App\Models\event;
use Illuminate\Http\Request;
use Carbon\Carbon;


class EventController extends Controller
{
    public function event()
    {
        return view('event');
    }


    public function event_add(Request $request)
{
    try{

        $request->validate([
            'name' => 'required|unique:events',
            'event_date' => 'required',
            'image' => 'required|image'
        ]);
        
      $eventData = $request->all();
      $mytime = date("Y-m-d");
      $eventdate = $request->input('event_date');
      // dd($eventdate,$mytime);
      
      if($eventdate === $mytime)  {
        return response()->json([
          'status_value' => false,
          'message' => 'event Created Failed'
      ]);
      }
    //   dd($eventData);
      $event = new event;
  
      $event->fill($eventData); 
  
      if ($request->hasFile('image')) {
        $image = $request->file('image');
        $originalFileName = $image->getClientOriginalName();
    
        // Replace empty spaces with underscores in the filename
        $newFileName = time() . '_' . str_replace(' ', '_', $originalFileName);
        // dd($newFileName);
    
        // Move the uploaded image to the desired directory
        $image->move(public_path('uploads/event/'), $newFileName);
          // dd($image);
    
        // Assign the file path to the food_image attribute
        $event->image = 'uploads/event/' . $newFileName;
  
    }

    $event->save();

   return response()->json([
      'status' =>'event_add_success',
      'status_value' => true,
      'message' => 'event Created Successfuly'
  ]);
}
  catch (Exception $e) {
    return response()->json([
        'status_value' => false,
        'message' => $e->getMessage()
    ]); 
}
   
}

public function event_get()
{
    $eventdetails = event::get();
    
    // dd($eventdetails);
// Return the view with billing details
    return response()->json(['eventdetails' => $eventdetails]);
}

public function event_update(Request $request)
{
    try{
      $event_id = $request->input('event_id');
        // dd($event_id);
      // Find the event by ID
      $event = event::find($event_id);
      if ($event) {
        $event->update($request->all());

        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $originalFileName = $image->getClientOriginalName();
        
            // Replace empty spaces with underscores in the filename
            $newFileName = time() . '_' . str_replace(' ', '_', $originalFileName);
            // dd($newFileName);
        
            // Move the uploaded image to the desired directory
            $image->move(public_path('uploads/event/'), $newFileName);
              // dd($image);
        
            // Assign the file path to the food_image attribute
            $event->image = 'uploads/event/' . $newFileName;
      
        }

        $event->save();

        return response()->json([
          'status' => 'event_update_success',
          'status_value' => true,
          'message' => 'event Updated Successfully'
      ]);
      
      }
      else{
        return response()->json([
          'status' => 'event_update_fail',
          'status_value' => false,
          'message' => 'event Not Found'
      ]);
      }
  



}
catch (Exception $e) {
  return response()->json([
      'status' => 'event_update_fail',
      'status_value' => false,
      'message' => $e->getMessage()
  ]);
}
   
}

public function event_delete(Request $request)
{
    $id = $request->input('selectedId');
    // dd($id);
    if (!is_array($id)) {
      $id = [$id]; 
  }

    event::whereIn('id', $id)->delete();
    // CustomerModel::whereIn('id', $id)->update(['flag' => 0]);

    return response()->json([
      'status' => true,
      'message' => 'event Deleted Successfully'
  ]);

}

   
}