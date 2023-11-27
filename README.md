#  Uploading Files

## Step 1: Configure Filesystem 
In your filesystems.php configuration file, set the default filesystem driver to 'public':

`'default' => env('FILESYSTEM_DRIVER', 'public'),`

## Step 2: Create a Symbolic Link
Create a symbolic link to your storage directory by running the following Artisan command:

`php artisan storage:link`

## Step 3: Modify Your Form
In your edit form view (e.g., edit.blade.php), add enctype="multipart/form-data" to your form to enable file uploads:

```
<form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!-- other form fields -->
    <div class="form-group">
        <label for="image">Image:</label>
        <input class="form-control-file" @error('image') is-invalid @enderror type="file" name="image" id="image">
        @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <!-- submit button and closing tags -->
</form>
```
## Step 4: Update Your Controller
In your controller's update method, handle the image upload and update the post. You can use the store method from the Storage facade:

```
  // Handle image upload
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('uploads', 'public');
        // Store the image path in the database
        $post->image = $imagePath;
    }
```

## Step 5: Display the Image

```
    @if($post->image)
        <img class="img-fluid w-25" src="{{ asset('storage/' . $post->image) }}" alt="Uploaded File">
    @else
        No Image
    @endif
```

# Laravel 7 Pagination with paginate()
`$users = User::paginate(5);`

```
{{-- View --}}
@foreach ($users as $user)
    <!-- Display user information -->
@endforeach

{{ $users->links() }}
```

# 1-to-1 Relationship: User and UserDetails
Each user has one set of user details.
### Step 1: Database Migration 
Ensure your database tables are properly structured.
### Step 2: Create the Migration
`add_user_id_to_user_details_table.php`

    public function up()
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id'); // Add user_id column
            $table->foreign('user_id')->references('id')->on('users'); // Add foreign key constraint
        });
    }

    public function down()
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Remove foreign key constraint
            $table->dropColumn('user_id'); // Remove user_id column
        });
    }

Run php artisan migrate to apply the migration.

### Step 3: Define the Relationship in Models
```

class UserDetails extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

class User extends Model
{
    public function userDetails()
    {
        return $this->hasOne(UserDetails::class);
    }
}
```

### Step 4: Using the Relationship
Retrieve a User's UserDetails

```
$user = User::find(1);
$userDetails = $user->userDetails; // Get the associated user details

// Access user details data
echo $userDetails->address;
```
Retrieve the User of UserDetails
```
$userDetails = UserDetails::find(1);
$user = $userDetails->user; // Get the associated user

// Access user data
echo $user->name;
```

# 1-to-Many Relationship: User and Post
 Each user can have multiple posts.

### Step 1: Database Setup

### Step 2: Create the Migration
`add_user_id_to_posts_table.php`

```
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id'); // Add user_id column
            $table->foreign('user_id')->references('id')->on('users'); // Add foreign key constraint
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Remove foreign key constraint
            $table->dropColumn('user_id'); // Remove user_id column
        });
    }
```
Run php artisan migrate to apply the migration.

### Step 3: Define the Relationship in Models

```
class User extends Model
{
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
```
```
namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

```

### Step 4: Using the Relationship


# Many-to-many Relationship: User and UserDetails
Each user can have multiple roles, and each role can be associated with multiple users.

### Step 1: Database Setup

### Step 2: Create the Migration
`create_role_user_table.php`

```
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');
            $table->primary(['user_id', 'role_id']);
        });
    }
```
Run php artisan migrate to apply the migration.

### Step 3: Define the Relationship in Models

```
class User extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
```
```
class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
```

### Step 4: Using the Relationship

```
$user = User::find(1);
$roles = $user->roles; // Get all roles associated with the user

foreach ($roles as $role) {
    echo $role->name;
}
```

## Role() vs. Role
Using Parentheses (role()): If you define a relationship with parentheses, you will use a method to access the related data.
`$roles = $user->roles();`
Without Parentheses (role): If you define the relationship without parentheses, you can access the related data directly as a property.
`$roles = $user->roles;`

Use role() (with parentheses) when you want to retrieve the related data with additional query builder methods or if you need to access the intermediate pivot table. This is useful when you want to filter, order, or further manipulate the related data.
 
Use role (without parentheses) when you want to directly access the related data as a property without additional query builder methods. This is useful when you just need to get the related data as-is.

## attach, detach, and sync
attach($ids, $attributes = []): This method is used to attach one or more related models to the current model. It adds rows to the intermediate pivot table. For example, to assign roles to a user, you can use attach to add role IDs to the pivot table.

detach($ids = null): This method is used to detach related models from the current model. It removes rows from the intermediate pivot table. For example, to remove roles from a user, you can use detach with role IDs.

sync($ids, $detaching = true): This method is used to synchronize the related models. It will attach the specified IDs and detach any IDs not in the given array. The $detaching parameter controls whether to detach any IDs that are not in the array. This is useful when you want to completely replace the related data with a new set of data.







# Step 1: Install Guzzle

```
composer require guzzlehttp/guzzle
composer dump-autoload
```

# Step 2: Create a Model

```
php artisan make:model Models/Lead
```

# Step 3: Create a Migration for Leads
```
php artisan make:migration create_leads_table
php artisan migrate
```

# STEP Create the Mailable Class
```
php artisan make:mail NewContactForm
```

```
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewContactForm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var mixed
     */
    public $lead;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_lead)
    {
        $this->lead = $_lead;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Shinami') // Change the subject here
            ->replyTo($this->lead->email)
            ->view('emails.new-contact');
    }
}

```

# Step 4: Create a Controller
```
php artisan make:controller Api/ContactController


// app/Http/Controllers/Api/ContactController.php

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewContactForm;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        $newLead = new Lead();

        $newLead->name = $data['name'];
        $newLead->email = $data['email'];
        $newLead->message = $data['message'];
        $newLead->save();

        Mail::to('your-mailtrap-email@example.com')->send(new NewContactForm($newLead));

        return response()->json([
            'message' => 'Contact form submitted successfully',
            'payload' => $newLead,
        ]);
    }
}

```



# Step 5: Create Api Route
```
Route::namespace('Api')->group(function () {
    Route::get('posts', 'PostController@index');
    Route::get('posts/{id}', 'PostController@show');
    // Add more routes for creating, updating, and deleting posts as needed

    Route::get('categories', 'CategoryController@index');
    Route::get('categories/{id}', 'CategoryController@show');

    Route::post('contacts', 'ContactController@store');
});
```

# Step 6: Create a Mail View
views -> mails -> new_contact.blade.php

```
<!-- resources/views/emails/new_contact.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
</head>
<body>
    <h2>New Contact Form Submission</h2>

    <p><strong>Name:</strong> {{ $lead->name }}</p>
    <p><strong>Email:</strong> {{ $lead->email }}</p>
    <p><strong>Message:</strong> {{ $lead->message }}</p>

    <p>Thank you for using our contact form!</p>
</body>
</html>

```

# Step 7: Configure Mailtrap in .env
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=your-email@example.com
MAIL_FROM_NAME="${APP_NAME}"

##########################################
##########################################
##########################################


create prject security application with ur google account

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=mymails.xander@gmail.com
MAIL_PASSWORD=vpjqewhbcgxhxwod
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tunissansfrontier@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```













