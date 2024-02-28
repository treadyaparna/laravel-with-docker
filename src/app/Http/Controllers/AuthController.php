<?php
namespace App\Http\Controllers;

use App\Enums\HttpStatus;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Response\ApiResponse;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * var UserService
     */
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;

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
     *                      @OA\Property(property="emailVerifiedAt", type="string", example=null),
     *                      @OA\Property(property="updatedAt", type="string", example="2022-06-28 06:06:17"),
     *                      @OA\Property(property="createdAt", type="string", example="2022-06-28 06:06:17"),
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
    public function login(LoginRequest $request): JsonResponse
    {
        $loginUser = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        try {
            $token = auth()->attempt($loginUser);

            if (!$token) {
                return ApiResponse::response(HttpStatus::HTTP_UNAUTHORIZED, 'Login failed');
            }
            return $this->createNewToken($token);
        } catch (Exception $e) {
            return ApiResponse::response($e->getCode(), $e->getMessage());
        }
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
     *                           property="roleId",
     *                           type="string"
     *                       )
     *                 ),
     *                 example={
     *                     "name":"User",
     *                     "email":"user@test.com",
     *                     "password":"password",
     *                      "roleId":"1"
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
     *                      @OA\Property(property="roleId", type="int", example="1"),
     *                      @OA\Property(property="emailVerifiedAt", type="string", example=null),
     *                      @OA\Property(property="updatedAt", type="string", example="2022-06-28 06:06:17"),
     *                      @OA\Property(property="createdAt", type="string", example="2022-06-28 06:06:17"),
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
    public function register(RegistrationRequest $request): JsonResponse
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password  = bcrypt($request->input('password'));
        $roleId = $request->input('roleId');

        try {
            return $this->userService->addUser($name, $email, $password, $roleId) ?
                ApiResponse::response(HttpStatus::HTTP_CREATED, 'Registration successfully'):
                ApiResponse::response(HttpStatus::CANT_COMPLETE_REQUEST, 'Registration failed');
        } catch (Exception $e) {
            return ApiResponse::response($e->getCode(), $e->getMessage());
        }
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
        return ApiResponse::response(HttpStatus::HTTP_OK, 'User successfully signed out');
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function userProfile(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function createNewToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
