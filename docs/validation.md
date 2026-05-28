### VALIDATION USING BLADE AND ALPINE (LARAVEL PRECOGNITION)

Laravel Precognition allows your frontend Alpine components to interview your backend validation rules in real-time. This gives users instant feedback as they type, before they officially submit the form.

---

#### 1. Install & Register the Alpine Plugin
To use the `$form` magic helper inside your Alpine components, you must install the official Laravel Precognition package and register its plugin.

```bash
npm install laravel-precognition-alpine

```

Add the plugin registration code to your `resources/js/app.js` bundle wrapper:

JavaScript

```
import  Alpine  from  'alpinejs';

import  Precognition  from  'laravel-precognition-alpine';

window.Alpine  =  Alpine;

Alpine.plugin(Precognition);

Alpine.start();

```

#### 2. Create a Dedicated Form Request

Precognition relies on standard Laravel Form Requests. This means your validation logic lives cleanly outside of your controller code.

Execute this command to generate your request class:

Bash

```
php artisan make:request StoreRepairesRequest

```

File code path: `app/Http/Requests/StoreRepairesRequest.php`

PHP

```
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRepairesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * CRITICAL: Must return true for your experiment/application to execute.
     */
    public function authorize(): bool
    {
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
        ];
    }
}

```

#### 3. Setup Your Routing Resource

You must attach the `HandlePrecognitiveRequests` middleware to your route. Without this, Laravel won't catch the live, typing validation requests sent by Alpine.

File code path: `routes/web.php`

PHP

```
use App\Http\Controllers\RepairController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

// The middleware automatically intercepts validation requests and safely ignores standard page loads (like index)
Route::resource('/repairs', RepairController::class)
    ->middleware([HandlePrecognitiveRequests::class]);

```

#### 4. Build the Frontend Blade View Form

Now hook the Alpine attributes directly into your markup fields.

-   `x-data="{ form: $form(...) }"`: Initializes the live form tracking instance targeting your POST route endpoint.
    
-   `@submit.prevent="form.submit()"`: Diverts traditional form submissions into a smooth AJAX payload request.
    
-   `@change="form.validate('name')"`: Fires off a background request to test **only** this input against your `StoreRepairesRequest` rules as soon as the user changes focus.
    
-   `:disabled="form.processing"`: Prevents double-submission issues by turning off the submit button during active server communication.
    

HTML

```
 <form
    x-data="{
        form: $form('post', '/repairs', {
            name: '',
            model: '',
            category: '',
            estimated_cost: '',
            description: '',
        }),

        submitData() {
            this.form.submit()
                .then(response => {
                    this.form.reset();
                    openCreateModal = false
                    alert('Ticket created.')
                })
                .catch(error => {
                });
        },

    }"
    @submit.prevent="submitData()"
    class="mt-4 space-y-4"
    >
    @csrf
    
    <div>
        <label class="text-xs font-medium text-gray-600 dark:text-gray-400">Customer Name</label>
        <input
            id="name"
            name="name"
            x-model="form.name"
            @change="form.validate('name')"
            type="text" 
            placeholder="John Doe" 
            class="block mt-1.5 w-full rounded-xl border border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-950 text-xs py-2.5 px-3.5 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-slate-500 focus:border-slate-500 transition">
        
        <template x-if="form.invalid('name')">
            <div class="mt-1.5 text-xs font-medium text-red-400" x-text="form.errors.name"></div>
        </template>
    </div>

    <div class="pt-3 flex items-center justify-end gap-2 border-t border-gray-100 dark:border-gray-800/60 mt-6">
        <button type="button" @click="openCreateModal = false" class="px-4 py-2.5 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/60 text-xs font-semibold rounded-xl transition">
            Cancel
        </button>
        <button :disabled="form.processing" class="px-4 py-2.5 bg-slate-600 hover:bg-slate-500 text-white text-xs font-semibold rounded-xl shadow-sm transition active:scale-[0.98]">
            Register Ticket
        </button>
    </div>
</form>

```

#### 5. Handle the Response in Your Controller

When the user clicks the "Register Ticket" button and validation passes, your controller's `store()` method completes execution. Returning a JSON payload lets Precognition's frontend processor know the action was successful.

File code path: `app/Http/Controllers/RepairController.php`

PHP

```
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRepairesRequest;

class RepairController extends Controller
{
 public function store(StoreRepairesRequest $request){
        $validated = $request->validated();

        try {
            $ticket_number = 'TKN-' . Str::ulid();


            $repair = Repair::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'model' => $validated['model'],
                'category' => $validated['category'],
                'estimated_cost' => $validated['estimated_cost'],
                'ticket_number' => $ticket_number
            ]);


            return response()->json([
                'message' => 'Ticket registered successfully!',
                'data' => $repair
            ], 201);

        } catch (Exception $e) {
            Log::error('Repair Ticket Creation Failed: ' . $e->getMessage(), [
                'input_payload' => $validated,
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);


            return response()->json([
                'message' => 'Something went wrong on our end. Please try again later.'
            ], 500);
        }
    }
}
```
