<?php
namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * User Login
     * @OA\Post (
     *     path="/api/login",
     *     tags={"authentication"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "email":"user@test.com",
     *                     "password":"password"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Valid credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=200),
     *                  @OA\Property(property="status", type="string", example="success"),
     *                  @OA\Property(property="message", type="string", example=null),
     *              ),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="user", type="object",
     *                      @OA\Property(property="id", type="number", example=2),
     *                      @OA\Property(property="name", type="string", example="User"),
     *                      @OA\Property(property="email", type="string", example="user@test.com"),
     *                      @OA\Property(property="email_verified_at", type="string", example=null),
     *                      @OA\Property(property="updated_at", type="string", example="2022-06-28 06:06:17"),
     *                      @OA\Property(property="created_at", type="string", example="2022-06-28 06:06:17"),
     *                  ),
     *                  @OA\Property(property="access_token", type="object",
     *                      @OA\Property(property="token", type="string", example="randomtokenasfhajskfhajf398rureuuhfdshk"),
     *                      @OA\Property(property="type", type="string", example="Bearer"),
     *                      @OA\Property(property="expires_in", type="number", example=3600),
     *                  ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Invalid credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=401),
     *                  @OA\Property(property="status", type="string", example="error"),
     *                  @OA\Property(property="message", type="string", example="Incorrect username or password!"),
     *              ),
     *              @OA\Property(property="data", type="object", example={}),
     *          )
     *      )
     * )
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    /**
     * User Register
     * @OA\Post (
     *     path="/api/register",
     *     tags={"authentication"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                           property="role_id",
     *                           type="string"
     *                       )
     *                 ),
     *                 example={
     *                     "name":"User",
     *                     "email":"user@test.com",
     *                     "password":"password",
     *                      "role_id":"1"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=200),
     *                  @OA\Property(property="status", type="string", example="success"),
     *                  @OA\Property(property="message", type="string", example=null),
     *              ),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="user", type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="name", type="string", example="User"),
     *                      @OA\Property(property="email", type="string", example="user@test.com"),
     *                      @OA\Property(property="role_id", type="int", example="1"),
     *                      @OA\Property(property="email_verified_at", type="string", example=null),
     *                      @OA\Property(property="updated_at", type="string", example="2022-06-28 06:06:17"),
     *                      @OA\Property(property="created_at", type="string", example="2022-06-28 06:06:17"),
     *                  ),
     *                  @OA\Property(property="access_token", type="object",
     *                      @OA\Property(property="token", type="string", example="randomtokenasfhajskfhajf398rureuuhfdshk"),
     *                      @OA\Property(property="type", type="string", example="Bearer"),
     *                      @OA\Property(property="expires_in", type="number", example=3600),
     *                  ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=422),
     *                  @OA\Property(property="status", type="string", example="error"),
     *                  @OA\Property(property="message", type="object",
     *                      @OA\Property(property="email", type="array", collectionFormat="multi",
     *                        @OA\Items(
     *                          type="string",
     *                          example="The email has already been taken.",
     *                          )
     *                      ),
     *                  ),
     *              ),
     *              @OA\Property(property="data", type="object", example={}),
     *          )
     *      )
     * )
     * @throws ValidationException
     */
    public function register(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'role_id' => 'required|integer|exists:roles,id',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * User Logout
     * @OA\Post (
     *     path="/api/logout",
     *     tags={"authentication"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *
     *                 ),
     *                 example={}
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=200),
     *                  @OA\Property(property="status", type="string", example="success"),
     *                  @OA\Property(property="message", type="string", example="Successfully logged out"),
     *              ),
     *              @OA\Property(property="data", type="object", example={}),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Invalid token",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=422),
     *                  @OA\Property(property="status", type="string", example="error"),
     *                  @OA\Property(property="message", type="string", example="Unauthenticated."),
     *              ),
     *              @OA\Property(property="data", type="object", example={}),
     *          )
     *      ),
     *      security={{ "apiAuth": {} }}
     * )
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function createNewToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
