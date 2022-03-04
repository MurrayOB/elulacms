To DO:

Thoughts:

Is a model necessary? If I make an api call that you call for the collection name,
I can create a control that dynamically fetches the results and places it into JSON.
I can also create a helper function that returns the collectionData to use inside a controller
so that it can be passed return view('example')->with('collectionName', $collectionData)

1. Create a model for the Collection
2. Return list of Collections
3. Allow to delete a collection
4. Return a specific collections data (getCollectionDataByName)

Commands:
php artisan vendor:publish --tag=public --force

Docs:

Schema:
https://laravel.com/docs/5.0/schema

Responses:
https://laravel.com/docs/9.x/responses
