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
