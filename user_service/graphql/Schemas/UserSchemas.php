   namespace App\GraphQL\Schemas;

   use GraphQL\Type\Definition\Type;
   use GraphQL\Type\Schema;

   class UserSchema {
       public function buildSchema() {
           return new Schema([
               'query' => [
                   'users' => [
                       'type' => Type::listOf(Type::string()), // Ubah sesuai model
                       'resolve' => function($root, $args) {
                           return \App\Models\User::all(); // Ambil data User
                       }
                   ],
               ],
           ]);
       }
   }
   