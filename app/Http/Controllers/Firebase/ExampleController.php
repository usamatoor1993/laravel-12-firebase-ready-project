<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\Facades\DB;
class ExampleController extends Controller
{
    //
    public function index()
    {
        // Initialize Firestore client
        $firestore = new FirestoreClient([
            'projectId' => config('services.firebase.project_id'),
        ]);

        // Reference to a collection
        $collection = $firestore->collection('example_collection');

        // Fetch documents from the collection
        $documents = $collection->documents();

        // Prepare data for view
        $data = [];
        foreach ($documents as $document) {
            if ($document->exists()) {
                $data[] = $document->data();
            }
        }

      return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Initialize Firestore client
        $firestore = new FirestoreClient([
            'projectId' => config('services.firebase.project_id'),
        ]);

        // Reference to a collection
        $collection = $firestore->collection('example_collection');

        // Add a new document to the collection
        $document = $collection->add([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'created_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Document created successfully',
            'document_id' => $document->id(),
        ]);
    }
    public function show($id){
        // Initialize Firestore client
        $firestore = new FirestoreClient([
            'projectId' => config('services.firebase.project_id'),
        ]);

        // Reference to a collection
        $collection = $firestore->collection('example_collection');

        // Fetch the document by ID
        $document = $collection->document($id)->snapshot();

        if ($document->exists()) {
            return response()->json([
                'status' => 'success',
                'data' => $document->data(),
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Document not found',
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        // Validate request data
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
        ]);

        // Initialize Firestore client
        $firestore = new FirestoreClient([
            'projectId' => config('services.firebase.project_id'),
        ]);

        // Reference to a collection
        $collection = $firestore->collection('example_collection');

        // Update the document by ID
        $document = $collection->document($id);
        $document->set($request->only(['name', 'email']), ['merge' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'Document updated successfully',
        ]);
    }
    public function destroy($id){
        // Initialize Firestore client
        $firestore = new FirestoreClient([
            'projectId' => config('services.firebase.project_id'),
        ]);

        // Reference to a collection
        $collection = $firestore->collection('example_collection');

        // Delete the document by ID
        $document = $collection->document($id);
        $document->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Document deleted successfully',
        ]);
    }
}
