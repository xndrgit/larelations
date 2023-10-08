

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
