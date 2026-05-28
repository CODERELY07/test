
# Repair Ticket Edit Modal — Step-by-Step Guide

This guide explains how to implement an **Edit Repair Ticket Modal** using:

-   Laravel
    
-   Alpine.js
    
-   Laravel Precognition
    
-   Form Request Validation
    
-   Modal Event Dispatching
    

----------

# 1. Create the Update Route

The first step is creating the update route.

Inside `routes/web.php`:

```php
use App\Http\Controllers\RepairController;
use Laravel\Precognition\Http\Middleware\HandlePrecognitiveRequests;

Route::resource('/repairs', RepairController::class)->middleware([HandlePrecognitiveRequests::class]);;
```

## Why `{repair}`?

Because the controller uses Laravel Route Model Binding:

```php
public function update(UpdateRepairRequest $request, Repair $repair)

```

Laravel automatically finds the repair record using the ID from the URL.

Example:

```http
PATCH /repairs/5

```

Automatically becomes:

```php
Repair::find(5)

```

----------

# 2. Create the Form Request Validation

Create a request:

```bash
php artisan make:request UpdateRepairRequest

```

Inside:

`app/Http/Requests/UpdateRepairRequest.php`

Add validation rules:

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRepairRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'estimated_cost' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'in:pending,ongoing,completed'],
            'description' => ['nullable', 'string'],
        ];
    }
}

```

## Purpose

This validates the update request before saving.

Examples:

### Valid

```json
{
    "name": "John",
    "estimated_cost": 1500
}

```

### Invalid

```json
{
    "name": "",
    "estimated_cost": -20
}

```

----------

# 3. Create the Update Controller Method

Inside `RepairController.php`:

```php
public function update(UpdateRepairRequest $request, Repair $repair)
{
    $validated = $request->validated();

    try {

        $repair->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'model' => $validated['model'],
            'category' => $validated['category'],
            'estimated_cost' => $validated['estimated_cost'],
            'status' => $validated['status'],
        ]);

        return response()->json([
            'message' => 'Ticket updated successfully!',
            'data' => $repair
        ], 200);

    } catch (\Exception $e) {

        \Log::error('Repair Ticket Update Failed: '.$e->getMessage());

        return response()->json([
            'message' => 'Something went wrong.'
        ], 500);
    }
}

```

## What happens here?

1.  Validate request
    
2.  Find repair automatically
    
3.  Update fields
    
4.  Return JSON response
    

----------

# 4. Create the Edit Button

Inside the table row:

```blade
<button
    type="button"
    @click="$dispatch('open-edit-repair-modal', @js([
        'id' => $repair->id,
        'ticket_number' => $repair->ticket_number,
        'name' => $repair->name,
        'model' => $repair->model,
        'category' => $repair->category,
        'estimated_cost' => $repair->estimated_cost,
        'description' => $repair->description,
        'status' => strtolower($repair->status->value ?? $repair->status),
    ]))">

    Edit
</button>

```

## Why use `@js()`?

Without `@js()`:

```blade
'{{ $repair->description }}'

```

quotes can break Alpine.

Example:

```txt
John's laptop

```

causes JavaScript errors.

`@js()` safely converts PHP → JSON.

----------

# 5. Create the Modal State

Inside the modal:

```html
x-data="{
    openEditModal: false,
    form: null,
}"

```

## Purpose

Tracks:

### Modal open/close state

```js
openEditModal

```

### Form data

```js
form

```

----------

# 6. Create Dynamic Precognition Form

Precognition caches the URL.

Because each repair has a different ID:

```http
/repairs/1
/repairs/2
/repairs/3

```

we dynamically rebuild the form.

```js
createForm(id = 0) {
    return $form('patch', `/repairs/${id}`, {
        id: '',
        ticket_number: '',
        name: '',
        model: '',
        category: '',
        estimated_cost: '',
        description: '',
        status: ''
    });
}

```

----------

# 7. Initialize the Form

Inside `init()`:

```js
init() {
    this.form = this.createForm();
}

```

This prevents Alpine compile errors before modal opens.

----------

# 8. Open the Modal

Listen for dispatched event:

```html
@open-edit-repair-modal.window="
    openModal($event.detail)
"

```

Create method:

```js
openModal(data) {

    this.form = this.createForm(data.id);

    this.form.id = data.id;
    this.form.ticket_number = data.ticket_number ?? '';
    this.form.name = data.name ?? '';
    this.form.model = data.model ?? '';
    this.form.category = data.category ?? '';
    this.form.estimated_cost = Number(data.estimated_cost ?? 0);
    this.form.description = data.description ?? '';
    this.form.status = data.status ?? 'pending';

    this.openEditModal = true;
}

```

## What happens?

When clicking Edit:

```js
$dispatch(...)

```

passes repair data.

Modal receives it:

```js
$event.detail

```

and fills form fields.

----------

# 9. Bind Inputs with `x-model`

Example:

```html
<input
    type="text"
    x-model="form.name"
>

```

This makes the input reactive.

Changing the field updates:

```js
form.name

```

automatically.

----------

# 10. Add Validation

Example:

```html
@change="form.validate?.('name')"

```

This validates only one field.

Show errors:

```html
<template x-if="form.invalid?.('name')">
    <div x-text="form.errors.name"></div>
</template>

```

----------

# 11. Submit Update

```js
submitUpdate() {

    this.form.submit()
        .then(() => {

            this.openEditModal = false;

            alert('Ticket successfully updated!');

            window.location.reload();
        })
        .catch(error => {
            console.error(error);
        });
}

```

## What happens?

1.  Sends PATCH request
    
2.  Runs validation
    
3.  Updates database
    
4.  Closes modal
    
5.  Refreshes page
    

----------

# 12. Final Flow

### User clicks Edit

↓

### Repair data dispatched

↓

### Modal opens

↓

### Form auto-filled

↓

### User edits data

↓

### Validation runs

↓

### Submit PATCH request

↓

### Controller updates database

↓

### Success response

↓

### Modal closes and reloads page

----------

# Common Errors

## 404 Not Found

Wrong route parameter:

❌ Wrong:

```php
Route::patch('/repairs/{id}')

```

✅ Correct:

```php
Route::patch('/repairs/{repair}')

```

----------

## PATCH /repairs 405

Wrong URL.

Must be:

```http
PATCH /repairs/5

```

not:

```http
PATCH /repairs

```

----------

## `this.form.patch is not a function`

Precognition forms do not support:

```js
form.patch()

```

Use:

```js
form.submit()

```

----------

## Modal Empty

You forgot:

```js
openModal($event.detail)

```

or dispatch data.

----------

## Description breaks modal

Use:

```blade
@js()

```

instead of:

```blade
'{{ }}'

```
